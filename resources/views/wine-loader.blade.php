<!-- Beautiful Wine Loader -->
<style>
    /* Wine Loader Styles */
    .wine-loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
    }

    .wine-loader-overlay.fade-out {
        opacity: 0;
        visibility: hidden;
    }

    .wine-loader-container {
        text-align: center;
        color: white;
        background: rgba(255, 255, 255, 0.1);
        padding: 40px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    /* Wine Glass Animation */
    .wine-loader-animation {
        margin-bottom: 30px;
    }

    .wine-glass {
        width: 60px;
        height: 80px;
        margin: 0 auto 20px;
        position: relative;
        border: 3px solid rgba(255, 255, 255, 0.6);
        border-radius: 0 0 30px 30px;
        background: rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .wine-glass::before {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 25px;
        border: 3px solid rgba(255, 255, 255, 0.6);
        border-top: none;
        background: rgba(255, 255, 255, 0.1);
    }

    .wine-fill {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(45deg, #ff6b6b, #ee5a24);
        border-radius: 0 0 27px 27px;
        animation: fillWine 2s ease-in-out infinite alternate;
    }

    @keyframes fillWine {
        0% {
            height: 20%;
        }

        100% {
            height: 70%;
        }
    }

    /* Loading Dots */
    .wine-loader-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .wine-loader-dots span {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.8);
        animation: dotPulse 1.4s ease-in-out infinite both;
    }

    .wine-loader-dots span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .wine-loader-dots span:nth-child(2) {
        animation-delay: -0.16s;
    }

    .wine-loader-dots span:nth-child(3) {
        animation-delay: 0s;
    }

    @keyframes dotPulse {

        0%,
        80%,
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        40% {
            transform: scale(1.2);
            opacity: 1;
        }
    }

    /* Loader Text */
    .wine-loader-text h4 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .wine-loader-text p {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
        animation: textFade 2s ease-in-out infinite alternate;
    }

    @keyframes textFade {
        0% {
            opacity: 0.6;
        }

        100% {
            opacity: 1;
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .wine-loader-container {
            padding: 30px 20px;
            margin: 20px;
        }

        .wine-glass {
            width: 50px;
            height: 70px;
        }

        .wine-loader-text h4 {
            font-size: 20px;
        }

        .wine-loader-text p {
            font-size: 14px;
        }
    }

    /* Dark theme variant */
    .wine-loader-overlay.dark-theme {
        background: rgba(18, 18, 18, 0.8);
    }

    .wine-loader-overlay.dark-theme .wine-loader-container {
        background: rgba(30, 30, 30, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Light theme variant */
    .wine-loader-overlay.light-theme {
        background: rgba(255, 255, 255, 0.8);
    }

    .wine-loader-overlay.light-theme .wine-loader-container {
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .wine-loader-overlay.light-theme .wine-glass {
        border-color: rgba(0, 0, 0, 0.3);
    }

    .wine-loader-overlay.light-theme .wine-glass::before {
        border-color: rgba(0, 0, 0, 0.3);
    }

    .wine-loader-overlay.light-theme .wine-loader-dots span {
        background: rgba(0, 0, 0, 0.6);
    }
</style>
<div id="wine-loader-overlay" class="wine-loader-overlay">
    <div class="wine-loader-container">
        <div class="wine-loader-animation">
            <div class="wine-glass">
                <div class="wine-fill"></div>
            </div>
            <div class="wine-loader-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="wine-loader-text">
            <h4>{{ $title ?? 'Loading Dashboard' }}</h4>
            <p>{{ $subtitle ?? 'Preparing your wine analytics...' }}</p>
        </div>
    </div>
</div>

<script>
    // Simple Wine Loader - Just show and hide
    window.hideWineLoader = function() {
        const loader = document.getElementById('wine-loader-overlay');
        if (loader) {
            loader.classList.add('fade-out');
            setTimeout(() => {
                if (loader.parentNode) {
                    loader.parentNode.removeChild(loader);
                }
            }, 500);
        }
    };

    // Auto-hide after 3 seconds
    setTimeout(() => {
        hideWineLoader();
    }, 3000);

    // Hide when page is fully loaded
    window.addEventListener('load', () => {
        setTimeout(hideWineLoader, 1000);
    });
</script>
