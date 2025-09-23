<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= esc($description) ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #34495e;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --border-color: #dee2e6;
            --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-text);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-light);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .main-container {
            padding: 2rem 0;
            min-height: calc(100vh - 76px);
        }

        .converter-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-medium);
            border: none;
            margin-bottom: 2rem;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .page-subtitle {
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 2rem;
        }

        .direction-selector {
            margin-bottom: 2rem;
        }

        .direction-btn {
            border: 2px solid var(--border-color);
            background: white;
            color: var(--dark-text);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0.25rem;
        }

        .direction-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .direction-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: var(--shadow-light);
        }

        .converter-section {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 1.5rem;
            align-items: start;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .converter-section {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .swap-button {
                order: -1;
                justify-self: center;
            }
        }

        .text-area-container {
            position: relative;
        }

        .text-area-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .script-indicator {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .script-latin {
            background: #e8f5e8;
            color: var(--success-color);
        }

        .script-cyrillic {
            background: #e3f2fd;
            color: var(--primary-color);
        }

        .text-area {
            width: 100%;
            min-height: 200px;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 15px;
            font-size: 1rem;
            line-height: 1.6;
            resize: vertical;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .text-area:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }

        .text-area.output {
            background: var(--light-bg);
            cursor: pointer;
        }

        .text-area.output:hover {
            background: #e9ecef;
        }

        .swap-button {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            cursor: pointer;
            align-self: center;
            margin-top: 1.5rem;
        }

        .swap-button:hover {
            background: var(--secondary-color);
            transform: rotate(180deg);
            box-shadow: var(--shadow-light);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
            color: white;
        }

        .btn-success-custom {
            background: var(--success-color);
            color: white;
        }

        .btn-success-custom:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .status-message {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-weight: 600;
            text-align: center;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .status-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .character-count {
            position: absolute;
            bottom: 0.5rem;
            right: 1rem;
            font-size: 0.75rem;
            color: var(--secondary-color);
            background: white;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            box-shadow: var(--shadow-light);
        }

        .examples-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-medium);
            border: none;
        }

        .example-item {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .example-item:hover {
            background: #e9ecef;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .example-text {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.25rem;
        }

        .example-result {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .serbian-flag {
            display: inline-block;
            width: 1.5em;
            height: 1em;
            background: linear-gradient(to bottom, 
                #c6363c 0%, #c6363c 33.33%, 
                #002868 33.33%, #002868 66.66%, 
                #ffffff 66.66%, #ffffff 100%);
            border: 1px solid #ddd;
            border-radius: 2px;
            margin-right: 0.5em;
            vertical-align: middle;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-book-open me-2"></i>
                Serbian Dictionary API
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('converter') ?>">
                            <i class="fas fa-exchange-alt me-1"></i>Converter
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="container">
            <!-- Converter Card -->
            <div class="converter-card">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="text-center mb-4">
                            <span class="serbian-flag"></span>
                            <h1 class="page-title"><?= esc($title) ?></h1>
                            <p class="page-subtitle"><?= esc($description) ?></p>
                        </div>

                        <!-- Status Message -->
                        <div id="statusMessage" class="status-message"></div>

                        <!-- Direction Selector -->
                        <div class="direction-selector text-center">
                            <button class="direction-btn active" data-direction="auto">
                                <i class="fas fa-magic me-2"></i>Auto Detect
                            </button>
                            <button class="direction-btn" data-direction="latin-to-cyrillic">
                                <i class="fas fa-arrow-right me-2"></i>Latin → Cyrillic
                            </button>
                            <button class="direction-btn" data-direction="cyrillic-to-latin">
                                <i class="fas fa-arrow-left me-2"></i>Cyrillic → Latin
                            </button>
                        </div>

                        <!-- Converter Section -->
                        <div class="converter-section">
                            <!-- Input Text Area -->
                            <div class="text-area-container">
                                <div class="text-area-label">
                                    <i class="fas fa-edit"></i>
                                    <span>Input Text</span>
                                    <span id="inputScript" class="script-indicator script-latin">Latin</span>
                                </div>
                                <textarea 
                                    id="inputText" 
                                    class="text-area" 
                                    placeholder="Type your Serbian text here...&#10;&#10;Examples:&#10;• Zdravo, kako ste?&#10;• Добро јутро!&#10;• Miloš Petrović"
                                    autocomplete="off"
                                    spellcheck="false"
                                ></textarea>
                                <div id="inputCount" class="character-count">0 characters</div>
                            </div>

                            <!-- Swap Button -->
                            <button id="swapButton" class="swap-button" title="Swap input and output">
                                <i class="fas fa-exchange-alt"></i>
                            </button>

                            <!-- Output Text Area -->
                            <div class="text-area-container">
                                <div class="text-area-label">
                                    <i class="fas fa-eye"></i>
                                    <span>Output Text</span>
                                    <span id="outputScript" class="script-indicator script-cyrillic">Cyrillic</span>
                                    <div class="loading-spinner" id="loadingSpinner"></div>
                                </div>
                                <textarea 
                                    id="outputText" 
                                    class="text-area output" 
                                    placeholder="Transliterated text will appear here..."
                                    readonly
                                    title="Click to copy text"
                                ></textarea>
                                <div id="outputCount" class="character-count">0 characters</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button id="copyButton" class="btn-custom btn-success-custom">
                                <i class="fas fa-copy"></i>
                                <span>Copy to Clipboard</span>
                            </button>
                            <button id="clearButton" class="btn-custom btn-outline-custom">
                                <i class="fas fa-trash"></i>
                                <span>Clear All</span>
                            </button>
                            <a href="<?= base_url() ?>" class="btn-custom btn-primary-custom">
                                <i class="fas fa-home"></i>
                                <span>Back to API</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Examples Section -->
            <div class="examples-section">
                <h3 class="text-center mb-4">
                    <i class="fas fa-lightbulb me-2"></i>
                    Quick Examples
                </h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="example-item" data-text="Zdravo, kako ste?">
                            <div class="example-text">Zdravo, kako ste?</div>
                            <div class="example-result">→ Здраво, како сте?</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="example-item" data-text="Добро јутро!">
                            <div class="example-text">Добро јутро!</div>
                            <div class="example-result">→ Dobro jutro!</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="example-item" data-text="Miloš Petrović">
                            <div class="example-text">Miloš Petrović</div>
                            <div class="example-result">→ Милош Петровић</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="example-item" data-text="Београд је главни град Србије">
                            <div class="example-text">Београд је главни град Србије</div>
                            <div class="example-result">→ Beograd je glavni grad Srbije</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="example-item" data-text="Programiranje je zabavno">
                            <div class="example-text">Programiranje je zabavno</div>
                            <div class="example-result">→ Програмирање је забавно</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="example-item" data-text="Лако је учити српски језик">
                            <div class="example-text">Лако је учити српски језик</div>
                            <div class="example-result">→ Lako je učiti srpski jezik</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-code me-2"></i>
                Serbian Text Converter - Part of Serbian Dictionary API
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
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

                this.initEventListeners();
                this.updateCharacterCounts();
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
                        this.setDirection(e.target.dataset.direction);
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
                    const response = await fetch('<?= base_url('converter/translate') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            text: text,
                            direction: this.currentDirection
                        })
                    });

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
                        this.showStatus('Error: ' + data.error, 'error');
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

        // Initialize converter when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new SerbianConverter();
        });

        // Add some nice touch interactions
        document.addEventListener('DOMContentLoaded', () => {
            // Add ripple effect to buttons
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
    </script>

    <!-- Ripple Effect CSS -->
    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            pointer-events: none;
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        button {
            position: relative;
            overflow: hidden;
        }
    </style>
</body>
</html>