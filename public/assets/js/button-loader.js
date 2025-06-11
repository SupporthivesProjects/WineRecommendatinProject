/**
 * Button Loader Utility
 * A reusable function to add loading states to buttons
 */
class ButtonLoader {
    constructor() {
        this.loadingButtons = new Map();
    }

    /**
     * Initialize button loader for a specific button
     * @param {string} buttonSelector - CSS selector for the button
     * @param {Object} options - Configuration options
     */
    init(buttonSelector, options = {}) {
        const defaultOptions = {
            loadingText: 'Loading...',
            showSpinner: true,
            disableButton: true,
            pulseAnimation: true,
            minLoadingTime: 500,
            spinnerClass: 'spinner-border spinner-border-sm me-2',
            spinnerPosition: 'left' // 'left' or 'right'
        };

        const config = { ...defaultOptions, ...options };
        const button = document.querySelector(buttonSelector);

        if (!button) {
            console.warn(`Button with selector "${buttonSelector}" not found`);
            return;
        }

        // Store original button content and config
        this.loadingButtons.set(buttonSelector, {
            button: button,
            originalContent: button.innerHTML,
            config: config,
            isLoading: false
        });

        // Add event listener based on button type
        if (button.type === 'submit' || button.closest('form')) {
            this.initFormSubmit(buttonSelector);
        } else {
            this.initClickHandler(buttonSelector);
        }
    }

    /**
     * Initialize form submit handler
     */
    initFormSubmit(buttonSelector) {
        const buttonData = this.loadingButtons.get(buttonSelector);
        const form = buttonData.button.closest('form');

        if (form) {
            form.addEventListener('submit', (e) => {
                this.showLoader(buttonSelector);
            });
        }
    }

    /**
     * Initialize click handler for non-form buttons
     */
    initClickHandler(buttonSelector) {
        const buttonData = this.loadingButtons.get(buttonSelector);
        
        buttonData.button.addEventListener('click', (e) => {
            this.showLoader(buttonSelector);
        });
    }

    /**
     * Show loader on button
     */
    showLoader(buttonSelector) {
        const buttonData = this.loadingButtons.get(buttonSelector);
        
        if (!buttonData || buttonData.isLoading) return;

        const { button, config } = buttonData;
        buttonData.isLoading = true;

        // Create loader content
        let loaderContent = '';
        
        if (config.showSpinner) {
            const spinner = `<span class="${config.spinnerClass}" role="status" aria-hidden="true"></span>`;
            loaderContent = config.spinnerPosition === 'left' 
                ? spinner + config.loadingText 
                : config.loadingText + spinner;
        } else {
            loaderContent = config.loadingText;
        }

        // Update button
        button.innerHTML = loaderContent;
        
        if (config.disableButton) {
            button.disabled = true;
            button.classList.add('btn-loading');
        }
        
        if (config.pulseAnimation) {
            button.classList.add('btn-pulse');
        }

        // Minimum loading time
        if (config.minLoadingTime > 0) {
            setTimeout(() => {
                // This ensures minimum loading time for better UX
            }, config.minLoadingTime);
        }
    }

    /**
     * Hide loader and restore button
     */
    hideLoader(buttonSelector) {
        const buttonData = this.loadingButtons.get(buttonSelector);
        
        if (!buttonData || !buttonData.isLoading) return;

        const { button, originalContent } = buttonData;
        
        button.innerHTML = originalContent;
        button.disabled = false;
        button.classList.remove('btn-loading', 'btn-pulse');
        
        buttonData.isLoading = false;
    }

    /**
     * Reset all buttons (useful for validation errors)
     */
    resetAll() {
        this.loadingButtons.forEach((buttonData, selector) => {
            this.hideLoader(selector);
        });
    }

    /**
     * Destroy button loader instance
     */
    destroy(buttonSelector) {
        this.hideLoader(buttonSelector);
        this.loadingButtons.delete(buttonSelector);
    }
}

// Create global instance
window.ButtonLoader = new ButtonLoader();

// Auto-initialize buttons with data attributes
document.addEventListener('DOMContentLoaded', function() {
    // Auto-init buttons with data-loader attribute
    document.querySelectorAll('[data-loader]').forEach(button => {
        const options = {};
        
        // Parse data attributes
        if (button.dataset.loadingText) options.loadingText = button.dataset.loadingText;
        if (button.dataset.noSpinner) options.showSpinner = false;
        if (button.dataset.noDisable) options.disableButton = false;
        if (button.dataset.noPulse) options.pulseAnimation = false;
        if (button.dataset.minLoadingTime) options.minLoadingTime = parseInt(button.dataset.minLoadingTime);
        if (button.dataset.spinnerPosition) options.spinnerPosition = button.dataset.spinnerPosition;

        // Generate unique selector
        if (!button.id) {
            button.id = 'btn-loader-' + Math.random().toString(36).substr(2, 9);
        }

        window.ButtonLoader.init('#' + button.id, options);
    });
});
