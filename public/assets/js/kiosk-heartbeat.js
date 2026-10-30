/**
 * Kiosk heartbeat: tells the server once a minute that this browser is open.
 *
 * Loaded once by the user, home and login layouts (it used to be copied into
 * nine pages). The server decides from the session whether a user is logged in;
 * this script only identifies the device with a random key kept in localStorage.
 *
 * - Sends on page load, then every minute.
 * - Only one tab per browser sends within a minute (they all share one record).
 * - Sends straight away when the network comes back or the tab becomes visible.
 * - If the session expired (HTTP 419, e.g. after the computer slept for hours),
 *   it fetches a fresh CSRF token and retries instead of failing silently.
 * - Never interrupts the page: every failure is ignored.
 */
(function (window, document) {
    'use strict';

    if (window.KioskHeartbeat) {
        return;
    }

    var DEVICE_KEY = 'techsomm_kiosk_device_key';
    var KIOSK_ID_KEY = 'techsomm_kiosk_id';
    var LAST_SENT_KEY = 'techsomm_kiosk_last_sent';
    var HEARTBEAT_INTERVAL = 60 * 1000;
    var OTHER_TAB_WINDOW = 45 * 1000;
    var REQUEST_TIMEOUT = 10 * 1000;

    var heartbeatInProgress = false;
    var csrfToken = null;

    function storageGet(key) {
        try {
            return window.localStorage.getItem(key);
        } catch (error) {
            return null;
        }
    }

    function storageSet(key, value) {
        try {
            window.localStorage.setItem(key, value);
        } catch (error) {
            // Private mode or full storage: monitoring just continues without it
        }
    }

    function newUuid() {
        if (window.crypto && window.crypto.randomUUID) {
            return window.crypto.randomUUID();
        }
        // Fallback for older kiosk browsers (RFC 4122 version 4)
        var bytes = new Uint8Array(16);
        window.crypto.getRandomValues(bytes);
        bytes[6] = (bytes[6] & 0x0f) | 0x40;
        bytes[8] = (bytes[8] & 0x3f) | 0x80;
        var hex = Array.prototype.map.call(bytes, function (b) {
            return ('0' + b.toString(16)).slice(-2);
        }).join('');
        return hex.slice(0, 8) + '-' + hex.slice(8, 12) + '-' + hex.slice(12, 16) + '-' + hex.slice(16, 20) + '-' + hex.slice(20);
    }

    function getDeviceKey() {
        var key = storageGet(DEVICE_KEY);
        if (!key) {
            key = newUuid();
            storageSet(DEVICE_KEY, key);
        }
        return key;
    }

    function pageCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : null;
    }

    function withTimeout(promiseFactory) {
        var controller = window.AbortController ? new AbortController() : null;
        var timeoutId = setTimeout(function () {
            if (controller) {
                controller.abort();
            }
        }, REQUEST_TIMEOUT);

        return promiseFactory(controller ? controller.signal : undefined).finally(function () {
            clearTimeout(timeoutId);
        });
    }

    function postHeartbeat(token) {
        return withTimeout(function (signal) {
            return fetch('/kiosk/heartbeat', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    device_key: getDeviceKey(),
                    kiosk_id: storageGet(KIOSK_ID_KEY)
                }),
                signal: signal
            });
        });
    }

    // The page's token belongs to the old session once it has expired; ask for the current one
    function fetchFreshToken() {
        return withTimeout(function (signal) {
            return fetch('/kiosk/token', {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' },
                signal: signal
            });
        }).then(function (response) {
            return response.ok ? response.json() : null;
        }).then(function (data) {
            return data && data.token ? data.token : null;
        });
    }

    function sendHeartbeat(force) {
        if (heartbeatInProgress) {
            return Promise.resolve();
        }

        // Another tab of this browser reported less than a minute ago
        var lastSent = parseInt(storageGet(LAST_SENT_KEY) || '0', 10);
        if (!force && lastSent && Date.now() - lastSent < OTHER_TAB_WINDOW) {
            return Promise.resolve();
        }

        csrfToken = csrfToken || pageCsrfToken();
        if (!csrfToken) {
            return Promise.resolve();
        }

        heartbeatInProgress = true;

        return postHeartbeat(csrfToken)
            .then(function (response) {
                if (response.status !== 419) {
                    return response;
                }
                return fetchFreshToken().then(function (token) {
                    if (!token) {
                        return response;
                    }
                    csrfToken = token;
                    return postHeartbeat(token);
                });
            })
            .then(function (response) {
                if (!response.ok) {
                    return null;
                }
                storageSet(LAST_SENT_KEY, String(Date.now()));
                return response.json();
            })
            .then(function (data) {
                if (data && data.status === 'active' && data.kiosk_id) {
                    storageSet(KIOSK_ID_KEY, data.kiosk_id);
                }
            })
            .catch(function () {
                // Monitoring failures must not interrupt normal page usage
            })
            .finally(function () {
                heartbeatInProgress = false;
            });
    }

    // Report straight away so logins and logouts show up quickly, then every minute
    sendHeartbeat(true);
    setInterval(function () {
        sendHeartbeat(false);
    }, HEARTBEAT_INTERVAL);

    window.addEventListener('online', function () {
        sendHeartbeat(true);
    });

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') {
            sendHeartbeat(false);
        }
    });

    window.KioskHeartbeat = {
        send: function () {
            return sendHeartbeat(true);
        }
    };
})(window, document);
