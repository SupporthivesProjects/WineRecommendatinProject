(function () {
    if (window.__keepAliveLoaded) return;
    window.__keepAliveLoaded = true;

    const KEEPALIVE_URL = window.KEEPALIVE_URL || '/session-keepalive';
    const INTERVAL_MS = 5 * 60 * 1000;

    const csrfMeta = () => document.querySelector('meta[name="csrf-token"]');

    const refreshToken = () =>
        fetch(KEEPALIVE_URL, {
            credentials: 'same-origin',
            headers: { Accept: 'application/json' },
        })
            .then(r => (r.ok ? r.json() : Promise.reject(r)))
            .then(d => {
                const meta = csrfMeta();
                if (meta && d.token) meta.setAttribute('content', d.token);
            });

    const safeRefresh = () => refreshToken().catch(() => {});

    setInterval(safeRefresh, INTERVAL_MS);
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) safeRefresh();
    });
    window.addEventListener('online', safeRefresh);

    async function postWithRetry(url, options = {}) {
        const send = () => fetch(url, {
            ...options,
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                ...options.headers,
                'X-CSRF-TOKEN': csrfMeta()?.content || '',
            },
        });

        let res = await send();
        if (res.status === 419) {
            await refreshToken().catch(() => {});
            res = await send();
        }
        if (res.status === 401) location.href = '/login';
        return res;
    }

    window.refreshToken = refreshToken;
    window.postWithRetry = postWithRetry;
})();