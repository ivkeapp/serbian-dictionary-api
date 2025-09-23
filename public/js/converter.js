/**
 * Serbian Text Converter JavaScript
 * Handles live transliteration between Latin and Cyrillic scripts
 */

class SerbianConverter {
    constructor() {
        this.inputText = document.getElementById('inputText');
        this.outputText = document.getElementById('outputText');
        this.inputScript = document.getElementById('inputScript');
        this.outputScript = document.getElementById('outputScript');
        this.inputCount = document.getElementById('inputCount');
        this.outputCount = document.getElementById('outputCount');
        this.statusMessage = document.getElementById('statusMessage');
        this.loadingSpinner = document.getElementById('loadingSpinner');
        this.currentDirection = 'auto';
        this.debounceTimeout = null;
        this.apiEndpoint = window.location.origin + '/converter/translate';

        this.initEventListeners();
        this.updateCharacterCounts();
        this.updateScriptIndicators();
    }

    initEventListeners() {
        // Input text change with debouncing
        this.inputText.addEventListener('input', () => {
            this.updateCharacterCounts();
            this.debouncedTransliterate();
        });

        // Direction buttons
        document.querySelectorAll('.direction-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.setDirection(e.target.closest('.direction-btn').dataset.direction);
            });
        });

        // Copy button
        document.getElementById('copyButton').addEventListener('click', () => {
            this.copyToClipboard();
        });

        // Clear button
        document.getElementById('clearButton').addEventListener('click', () => {
            this.clearAll();
        });

        // Swap button
        document.getElementById('swapButton').addEventListener('click', () => {
            this.swapTextAreas();
        });

        // Output textarea click to copy
        this.outputText.addEventListener('click', () => {
            this.copyToClipboard();
        });

        // Example items
        document.querySelectorAll('.example-item').forEach(item => {
            item.addEventListener('click', () => {
                const text = item.dataset.text;
                this.inputText.value = text;
                this.updateCharacterCounts();
                this.transliterate();
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'Enter':
                        e.preventDefault();
                        this.transliterate();
                        break;
                    case 'c':
                        if (e.target === this.outputText) {
                            e.preventDefault();
                            this.copyToClipboard();
                        }
                        break;
                    case 'l':
                        e.preventDefault();
                        this.clearAll();
                        break;
                }
            }
        });
    }

    setDirection(direction) {
        this.currentDirection = direction;
        
        // Update active button
        document.querySelectorAll('.direction-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`[data-direction="${direction}"]`).classList.add('active');

        // Update script indicators
        this.updateScriptIndicators();

        // Transliterate if there's text
        if (this.inputText.value.trim()) {
            this.transliterate();
        }
    }

    updateScriptIndicators() {
        switch(this.currentDirection) {
            case 'latin-to-cyrillic':
                this.inputScript.textContent = 'Latin';
                this.inputScript.className = 'script-indicator script-latin';
                this.outputScript.textContent = 'Cyrillic';
                this.outputScript.className = 'script-indicator script-cyrillic';
                break;
            case 'cyrillic-to-latin':
                this.inputScript.textContent = 'Cyrillic';
                this.inputScript.className = 'script-indicator script-cyrillic';
                this.outputScript.textContent = 'Latin';
                this.outputScript.className = 'script-indicator script-latin';
                break;
            case 'auto':
            default:
                this.inputScript.textContent = 'Auto';
                this.inputScript.className = 'script-indicator script-latin';
                this.outputScript.textContent = 'Auto';
                this.outputScript.className = 'script-indicator script-cyrillic';
                break;
        }
    }

    debouncedTransliterate() {
        clearTimeout(this.debounceTimeout);
        this.debounceTimeout = setTimeout(() => {
            this.transliterate();
        }, 300);
    }

    async transliterate() {
        const text = this.inputText.value.trim();
        
        if (!text) {
            this.outputText.value = '';
            this.updateCharacterCounts();
            return;
        }

        this.showLoading(true);

        try {
            const response = await fetch(this.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    text: text,
                    direction: this.currentDirection
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                this.outputText.value = data.data.transliterated;
                this.updateCharacterCounts();
                
                // Update script indicators for auto mode
                if (this.currentDirection === 'auto') {
                    if (data.data.detected_script === 'cyrillic') {
                        this.inputScript.textContent = 'Cyrillic';
                        this.inputScript.className = 'script-indicator script-cyrillic';
                        this.outputScript.textContent = 'Latin';
                        this.outputScript.className = 'script-indicator script-latin';
                    } else {
                        this.inputScript.textContent = 'Latin';
                        this.inputScript.className = 'script-indicator script-latin';
                        this.outputScript.textContent = 'Cyrillic';
                        this.outputScript.className = 'script-indicator script-cyrillic';
                    }
                }
            } else {
                this.showStatus('Error: ' + (data.error || 'Unknown error'), 'error');
            }
        } catch (error) {
            this.showStatus('Connection error. Please try again.', 'error');
            console.error('Transliteration error:', error);
        } finally {
            this.showLoading(false);
        }
    }

    updateCharacterCounts() {
        const inputLength = this.inputText.value.length;
        const outputLength = this.outputText.value.length;
        
        this.inputCount.textContent = `${inputLength} characters`;
        this.outputCount.textContent = `${outputLength} characters`;
    }

    async copyToClipboard() {
        const text = this.outputText.value;
        
        if (!text) {
            this.showStatus('No text to copy', 'error');
            return;
        }

        try {
            await navigator.clipboard.writeText(text);
            this.showStatus('Text copied to clipboard!', 'success');
        } catch (error) {
            // Fallback for older browsers
            this.outputText.select();
            document.execCommand('copy');
            this.showStatus('Text copied to clipboard!', 'success');
        }
    }

    clearAll() {
        this.inputText.value = '';
        this.outputText.value = '';
        this.updateCharacterCounts();
        this.inputText.focus();
        this.showStatus('Text cleared', 'success');
    }

    swapTextAreas() {
        const inputValue = this.inputText.value;
        const outputValue = this.outputText.value;
        
        if (!inputValue && !outputValue) {
            this.showStatus('No text to swap', 'error');
            return;
        }

        this.inputText.value = outputValue;
        this.outputText.value = inputValue;
        this.updateCharacterCounts();

        // Swap direction if not auto
        if (this.currentDirection === 'latin-to-cyrillic') {
            this.setDirection('cyrillic-to-latin');
        } else if (this.currentDirection === 'cyrillic-to-latin') {
            this.setDirection('latin-to-cyrillic');
        }

        this.showStatus('Text swapped', 'success');
        
        // Transliterate new input
        if (this.inputText.value.trim()) {
            this.transliterate();
        }
    }

    showStatus(message, type) {
        this.statusMessage.textContent = message;
        this.statusMessage.className = `status-message status-${type} show`;
        
        setTimeout(() => {
            this.statusMessage.classList.remove('show');
        }, 3000);
    }

    showLoading(show) {
        this.loadingSpinner.style.display = show ? 'block' : 'none';
    }
}

// Utility functions for Serbian text processing
class SerbianTextUtils {
    static readonly cyrillicPattern = /[\u0400-\u04FF]/;
    static readonly latinPattern = /[a-zA-ZčćđšžČĆĐŠŽ]/;
    
    static detectScript(text) {
        const hasCyrillic = this.cyrillicPattern.test(text);
        const hasLatin = this.latinPattern.test(text);
        
        if (hasCyrillic && hasLatin) {
            return 'mixed';
        } else if (hasCyrillic) {
            return 'cyrillic';
        } else if (hasLatin) {
            return 'latin';
        }
        
        return 'unknown';
    }
    
    static normalizeText(text) {
        return text.trim().replace(/\s+/g, ' ');
    }
    
    static getWordCount(text) {
        return text.trim() ? text.trim().split(/\s+/).length : 0;
    }
    
    static getSentenceCount(text) {
        return text.trim() ? text.split(/[.!?]+/).filter(s => s.trim()).length : 0;
    }
}

// Initialize converter when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('inputText')) {
        window.serbianConverter = new SerbianConverter();
    }
});

// Add ripple effect to buttons
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-custom, .direction-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { SerbianConverter, SerbianTextUtils };
}