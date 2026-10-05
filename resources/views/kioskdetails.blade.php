<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kiosk Display Information</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 10px;
        }

        .instruction {
            background: #fff3cd;
            border: 1px solid #ffe69c;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 6px;
        }

        .section {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-title {
            background: #222;
            color: white;
            padding: 12px 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .row {
            display: flex;
            border-bottom: 1px solid #eee;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            width: 40%;
            padding: 12px 15px;
            font-weight: bold;
            background: #fafafa;
        }

        .value {
            width: 60%;
            padding: 12px 15px;
            word-break: break-word;
        }

        .important {
            font-size: 22px;
            font-weight: bold;
        }

        .copy-box {
            margin-top: 20px;
        }

        textarea {
            width: 100%;
            min-height: 250px;
            padding: 15px;
            font-family: monospace;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }

        button {
            margin-top: 10px;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            background: #222;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #444;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .row {
                display: block;
            }

            .label,
            .value {
                width: 100%;
            }

            .label {
                padding-bottom: 5px;
            }

            .value {
                padding-top: 5px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Kiosk Display Information</h1>

    <div class="instruction">
        <strong>Instructions:</strong><br>
        Please send us a screenshot of this page.
        No settings need to be changed.
    </div>

    <!-- Browser Viewport -->
    <div class="section">
        <div class="section-title">
            Browser Viewport
        </div>

        <div class="row">
            <div class="label">window.innerWidth</div>
            <div class="value important" id="innerWidth"></div>
        </div>

        <div class="row">
            <div class="label">window.innerHeight</div>
            <div class="value important" id="innerHeight"></div>
        </div>

        <div class="row">
            <div class="label">document.clientWidth</div>
            <div class="value" id="clientWidth"></div>
        </div>

        <div class="row">
            <div class="label">document.clientHeight</div>
            <div class="value" id="clientHeight"></div>
        </div>
    </div>


    <!-- Visual Viewport -->
    <div class="section">
        <div class="section-title">
            Visual Viewport
        </div>

        <div class="row">
            <div class="label">Visual Viewport Width</div>
            <div class="value" id="visualWidth"></div>
        </div>

        <div class="row">
            <div class="label">Visual Viewport Height</div>
            <div class="value" id="visualHeight"></div>
        </div>

        <div class="row">
            <div class="label">Visual Viewport Scale</div>
            <div class="value" id="visualScale"></div>
        </div>

        <div class="row">
            <div class="label">Offset Left</div>
            <div class="value" id="visualOffsetLeft"></div>
        </div>

        <div class="row">
            <div class="label">Offset Top</div>
            <div class="value" id="visualOffsetTop"></div>
        </div>
    </div>


    <!-- Screen -->
    <div class="section">
        <div class="section-title">
            Screen Information
        </div>

        <div class="row">
            <div class="label">screen.width</div>
            <div class="value important" id="screenWidth"></div>
        </div>

        <div class="row">
            <div class="label">screen.height</div>
            <div class="value important" id="screenHeight"></div>
        </div>

        <div class="row">
            <div class="label">Available Width</div>
            <div class="value" id="availWidth"></div>
        </div>

        <div class="row">
            <div class="label">Available Height</div>
            <div class="value" id="availHeight"></div>
        </div>

        <div class="row">
            <div class="label">Color Depth</div>
            <div class="value" id="colorDepth"></div>
        </div>

        <div class="row">
            <div class="label">Pixel Depth</div>
            <div class="value" id="pixelDepth"></div>
        </div>
    </div>


    <!-- Device Pixel Ratio -->
    <div class="section">
        <div class="section-title">
            Pixel / Scaling Information
        </div>

        <div class="row">
            <div class="label">Device Pixel Ratio</div>
            <div class="value important" id="devicePixelRatio"></div>
        </div>

        <div class="row">
            <div class="label">Outer Window Width</div>
            <div class="value" id="outerWidth"></div>
        </div>

        <div class="row">
            <div class="label">Outer Window Height</div>
            <div class="value" id="outerHeight"></div>
        </div>
    </div>


    <!-- Orientation -->
    <div class="section">
        <div class="section-title">
            Orientation
        </div>

        <div class="row">
            <div class="label">Orientation</div>
            <div class="value important" id="orientation"></div>
        </div>

        <div class="row">
            <div class="label">Orientation Angle</div>
            <div class="value" id="orientationAngle"></div>
        </div>

        <div class="row">
            <div class="label">Portrait</div>
            <div class="value" id="portrait"></div>
        </div>

        <div class="row">
            <div class="label">Landscape</div>
            <div class="value" id="landscape"></div>
        </div>
    </div>


    <!-- Touch -->
    <div class="section">
        <div class="section-title">
            Touch / Pointer
        </div>

        <div class="row">
            <div class="label">Max Touch Points</div>
            <div class="value" id="maxTouchPoints"></div>
        </div>

        <div class="row">
            <div class="label">Touch Device</div>
            <div class="value" id="touchDevice"></div>
        </div>

        <div class="row">
            <div class="label">Coarse Pointer</div>
            <div class="value" id="pointerCoarse"></div>
        </div>

        <div class="row">
            <div class="label">Fine Pointer</div>
            <div class="value" id="pointerFine"></div>
        </div>

        <div class="row">
            <div class="label">Hover Available</div>
            <div class="value" id="hoverAvailable"></div>
        </div>
    </div>


    <!-- Browser -->
    <div class="section">
        <div class="section-title">
            Browser / Device
        </div>

        <div class="row">
            <div class="label">Platform</div>
            <div class="value" id="platform"></div>
        </div>

        <div class="row">
            <div class="label">Language</div>
            <div class="value" id="language"></div>
        </div>

        <div class="row">
            <div class="label">User Agent</div>
            <div class="value" id="userAgent"></div>
        </div>
    </div>


    <!-- Copyable Result -->
    <div class="copy-box">

        <h2>Complete Diagnostic Data</h2>

        <textarea id="result" readonly></textarea>

        <button onclick="copyResult()">
            Copy Diagnostic Data
        </button>

    </div>

</div>


<script>

(function () {

    const info = {

        // Browser viewport
        windowInnerWidth: window.innerWidth,
        windowInnerHeight: window.innerHeight,

        // Document viewport
        documentClientWidth: document.documentElement.clientWidth,
        documentClientHeight: document.documentElement.clientHeight,

        // Visual viewport
        visualViewportWidth: window.visualViewport
            ? window.visualViewport.width
            : null,

        visualViewportHeight: window.visualViewport
            ? window.visualViewport.height
            : null,

        visualViewportScale: window.visualViewport
            ? window.visualViewport.scale
            : null,

        visualViewportOffsetLeft: window.visualViewport
            ? window.visualViewport.offsetLeft
            : null,

        visualViewportOffsetTop: window.visualViewport
            ? window.visualViewport.offsetTop
            : null,

        // Screen
        screenWidth: screen.width,
        screenHeight: screen.height,

        screenAvailWidth: screen.availWidth,
        screenAvailHeight: screen.availHeight,

        screenColorDepth: screen.colorDepth,
        screenPixelDepth: screen.pixelDepth,

        // Device Pixel Ratio
        devicePixelRatio: window.devicePixelRatio,

        // Browser window
        windowOuterWidth: window.outerWidth,
        windowOuterHeight: window.outerHeight,

        // Orientation
        orientationType: screen.orientation
            ? screen.orientation.type
            : null,

        orientationAngle: screen.orientation
            ? screen.orientation.angle
            : null,

        // Device
        userAgent: navigator.userAgent,
        platform: navigator.platform,
        language: navigator.language,

        // Touch
        maxTouchPoints: navigator.maxTouchPoints,

        touchDevice: 'ontouchstart' in window,

        // Pointer
        pointerCoarse: window.matchMedia('(pointer: coarse)').matches,
        pointerFine: window.matchMedia('(pointer: fine)').matches,
        hoverAvailable: window.matchMedia('(hover: hover)').matches,

        // Orientation media queries
        portrait: window.matchMedia('(orientation: portrait)').matches,
        landscape: window.matchMedia('(orientation: landscape)').matches
    };


    // Helper to safely display values
    function set(id, value) {

        const element = document.getElementById(id);

        if (element) {
            element.textContent =
                value === null || value === undefined
                    ? 'Not available'
                    : value;
        }
    }


    // Browser viewport
    set('innerWidth', info.windowInnerWidth);
    set('innerHeight', info.windowInnerHeight);

    set('clientWidth', info.documentClientWidth);
    set('clientHeight', info.documentClientHeight);


    // Visual viewport
    set('visualWidth', info.visualViewportWidth);
    set('visualHeight', info.visualViewportHeight);
    set('visualScale', info.visualViewportScale);
    set('visualOffsetLeft', info.visualViewportOffsetLeft);
    set('visualOffsetTop', info.visualViewportOffsetTop);


    // Screen
    set('screenWidth', info.screenWidth);
    set('screenHeight', info.screenHeight);
    set('availWidth', info.screenAvailWidth);
    set('availHeight', info.screenAvailHeight);
    set('colorDepth', info.screenColorDepth);
    set('pixelDepth', info.screenPixelDepth);


    // Scaling
    set('devicePixelRatio', info.devicePixelRatio);
    set('outerWidth', info.windowOuterWidth);
    set('outerHeight', info.windowOuterHeight);


    // Orientation
    set('orientation', info.orientationType);
    set('orientationAngle', info.orientationAngle);
    set('portrait', info.portrait);
    set('landscape', info.landscape);


    // Touch
    set('maxTouchPoints', info.maxTouchPoints);
    set('touchDevice', info.touchDevice);
    set('pointerCoarse', info.pointerCoarse);
    set('pointerFine', info.pointerFine);
    set('hoverAvailable', info.hoverAvailable);


    // Browser
    set('platform', info.platform);
    set('language', info.language);
    set('userAgent', info.userAgent);


    // Put complete data into textarea
    document.getElementById('result').value =
        JSON.stringify(info, null, 4);


    // Also log to console
    console.table(info);

})();


function copyResult() {

    const textarea = document.getElementById('result');

    textarea.select();

    navigator.clipboard.writeText(textarea.value)
        .then(function () {

            alert('Diagnostic data copied.');

        })
        .catch(function () {

            alert('Please manually copy the diagnostic data.');

        });
}

</script>

</body>
</html>