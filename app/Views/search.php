<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= lang('App.search.tagline') ?>">
    
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
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --border-color: #dee2e6;
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .github-link {
            color: #15191F;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .github-link:hover {
            background: #15191F;
            color: white;
            transform: translateY(-2px);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            padding-top: 76px;
        }

        .search-section {
            text-align: center;
            padding: 2rem 1rem;
        }

        .search-tagline {
            font-size: 1.5rem;
            color: var(--secondary-color);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 100%;
            padding: 18px 55px 18px 25px;
            font-size: 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 4px 25px rgba(44, 90, 160, 0.15);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        /* Autosuggest dropdown */
        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            margin-top: 8px;
            overflow: hidden;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.25s ease;
        }

        .suggestions-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .suggestion-item {
            padding: 14px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover,
        .suggestion-item.selected {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        }

        .suggestion-item.selected {
            background: linear-gradient(135deg, #e8edff 0%, #dce4ff 100%);
        }

        .suggestion-word {
            font-weight: 500;
            color: var(--dark-text);
        }

        .suggestion-cyrillic {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .suggestion-message {
            padding: 14px 25px;
            color: #6c757d;
            text-align: center;
            font-style: italic;
        }

        /* Result display */
        .result-container {
            max-width: 700px;
            margin: 2.5rem auto 0;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .result-container.show {
            opacity: 1;
            transform: translateY(0);
        }

        .result-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .result-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1.5rem 2rem;
        }

        .result-header h3 {
            margin: 0;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .selected-word {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .selected-word-cyrillic {
            font-size: 1.5rem;
            opacity: 0.9;
            margin-top: 0.25rem;
        }

        .result-body {
            padding: 1.5rem 2rem;
        }

        .script-labels {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .script-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--light-bg);
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .script-badge i {
            color: var(--primary-color);
        }

        .similar-section h4 {
            color: var(--secondary-color);
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .similar-words-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .similar-word {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .similar-word:hover {
            background: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(44, 90, 160, 0.15);
        }

        .similar-word-latin {
            font-weight: 500;
            font-style: italic;
            color: var(--dark-text);
        }

        .similar-word-cyrillic {
            font-size: 0.85rem;
            color: #6c757d;
            font-style: italic;
        }

        /* Examples section */
        .examples-section {
            margin-top: 2rem;
            text-align: center;
        }

        .examples-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .example-words {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .example-word {
            background: white;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .example-word:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 1.5rem 0;
            text-align: center;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: white;
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .search-tagline {
                font-size: 1.2rem;
            }
            
            .search-input {
                font-size: 1rem;
                padding: 15px 50px 15px 20px;
            }
            
            .selected-word {
                font-size: 2rem;
            }
            
            .selected-word-cyrillic {
                font-size: 1.2rem;
            }
            
            .result-body {
                padding: 1rem 1.25rem;
            }
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
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-book-open me-2"></i>
                <?= lang('App.site.title') ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url() ?>">
                            <i class="fas fa-search me-1"></i><?= lang('App.nav.home') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('docs') ?>">
                            <i class="fas fa-book me-1"></i><?= lang('App.nav.api_docs') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('converter') ?>">
                            <i class="fas fa-exchange-alt me-1"></i><?= lang('App.nav.converter') ?>
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <?= view('components/language_switcher') ?>
                    <a href="<?= esc($github_url) ?>" target="_blank" class="github-link">
                        <i class="fab fa-github"></i>
                        <span class="d-none d-lg-inline"><?= lang('App.nav.github') ?></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <section class="search-section">
            <div class="container">
                <p class="search-tagline">
                    <span class="serbian-flag"></span>
                    <?= lang('App.search.tagline') ?>
                </p>
                
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <input 
                            type="text" 
                            class="search-input" 
                            id="searchInput"
                            placeholder="<?= lang('App.search.placeholder') ?>"
                            autocomplete="off"
                            autofocus
                        >
                        <i class="fas fa-search search-icon" id="searchIcon"></i>
                    </div>
                    
                    <div class="suggestions-dropdown" id="suggestionsDropdown">
                        <!-- Suggestions will be injected here -->
                    </div>
                </div>
                
                <!-- Example words to try -->
                <div class="examples-section" id="examplesSection">
                    <p class="examples-label"><?= lang('App.search.try_examples') ?></p>
                    <div class="example-words">
                        <span class="example-word" data-word="kuća">kuća</span>
                        <span class="example-word" data-word="majka">majka</span>
                        <span class="example-word" data-word="sunce">sunce</span>
                        <span class="example-word" data-word="ljubav">ljubav</span>
                        <span class="example-word" data-word="sreća">sreća</span>
                    </div>
                </div>

                <!-- Result display -->
                <div class="result-container" id="resultContainer">
                    <div class="result-card">
                        <div class="result-header">
                            <h3><?= lang('App.search.result_title') ?></h3>
                            <p class="selected-word" id="selectedWordLatin"></p>
                            <p class="selected-word-cyrillic" id="selectedWordCyrillic"></p>
                        </div>
                        <div class="result-body">
                            <div class="script-labels">
                                <span class="script-badge">
                                    <i class="fas fa-font"></i>
                                    <?= lang('App.search.latin') ?>: <strong id="resultLatin"></strong>
                                </span>
                                <span class="script-badge">
                                    <i class="fas fa-language"></i>
                                    <?= lang('App.search.cyrillic') ?>: <strong id="resultCyrillic"></strong>
                                </span>
                            </div>
                            <div class="similar-section">
                                <h4>
                                    <i class="fas fa-th-list"></i>
                                    <?= lang('App.search.similar_words') ?>
                                </h4>
                                <div class="similar-words-list" id="similarWordsList">
                                    <!-- Similar words will be injected here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">
                <?= lang('App.footer.builtWith') ?> <i class="fas fa-heart text-danger"></i> 
                | <a href="<?= esc($github_url) ?>" target="_blank"><?= lang('App.footer.viewOnGithub') ?></a>
                | <?= lang('App.footer.license') ?>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Search functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchIcon = document.getElementById('searchIcon');
        const suggestionsDropdown = document.getElementById('suggestionsDropdown');
        const resultContainer = document.getElementById('resultContainer');
        const examplesSection = document.getElementById('examplesSection');
        
        let suggestions = [];
        let selectedIndex = -1;
        let debounceTimer = null;
        const API_BASE = '<?= base_url('api') ?>';
        
        // Translations
        const i18n = {
            noResults: '<?= lang('App.search.no_results') ?>',
            minChars: '<?= lang('App.search.min_chars') ?>',
            loading: '<?= lang('App.search.loading') ?>'
        };
        
        // Debounce function
        function debounce(func, wait) {
            return function(...args) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(this, args), wait);
            };
        }
        
        // Fetch suggestions from API
        async function fetchSuggestions(query) {
            if (query.length < 2) {
                hideSuggestions();
                return;
            }
            
            showLoading();
            
            try {
                // Search for words starting with or containing the query
                const response = await fetch(`${API_BASE}/words?starts_with=${encodeURIComponent(query)}&limit=6`);
                const data = await response.json();
                
                if (data.data && data.data.length > 0) {
                    suggestions = data.data;
                    renderSuggestions(suggestions, query);
                } else {
                    // Try contains search as fallback
                    const containsResponse = await fetch(`${API_BASE}/words?contains=${encodeURIComponent(query)}&limit=6`);
                    const containsData = await containsResponse.json();
                    
                    if (containsData.data && containsData.data.length > 0) {
                        suggestions = containsData.data;
                        renderSuggestions(suggestions, query);
                    } else {
                        showNoResults();
                    }
                }
            } catch (error) {
                console.error('Error fetching suggestions:', error);
                showNoResults();
            }
        }
        
        // Render suggestions
        function renderSuggestions(items, query) {
            selectedIndex = -1;
            let html = '';
            
            items.slice(0, 6).forEach((item, index) => {
                const word = item.latin || item.word || item;
                const cyrillic = item.cyrillic || '';
                
                // Highlight matching part
                const highlightedWord = highlightMatch(word, query);
                
                html += `
                    <div class="suggestion-item" data-index="${index}">
                        <span class="suggestion-word">${highlightedWord}</span>
                        <span class="suggestion-cyrillic">${cyrillic}</span>
                    </div>
                `;
            });
            
            suggestionsDropdown.innerHTML = html;
            showSuggestions();
            
            // Add click handlers
            suggestionsDropdown.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    selectSuggestion(index);
                });
            });
        }
        
        // Highlight matching text
        function highlightMatch(text, query) {
            const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
            return text.replace(regex, '<strong>$1</strong>');
        }
        
        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
        
        // Show loading state
        function showLoading() {
            suggestionsDropdown.innerHTML = `
                <div class="suggestion-message">
                    <span class="loading-spinner"></span> ${i18n.loading}
                </div>
            `;
            showSuggestions();
        }
        
        // Show no results
        function showNoResults() {
            suggestionsDropdown.innerHTML = `
                <div class="suggestion-message">${i18n.noResults}</div>
            `;
            showSuggestions();
        }
        
        // Show/hide suggestions dropdown
        function showSuggestions() {
            suggestionsDropdown.classList.add('show');
        }
        
        function hideSuggestions() {
            suggestionsDropdown.classList.remove('show');
            selectedIndex = -1;
        }
        
        // Select a suggestion
        async function selectSuggestion(index) {
            if (index >= 0 && index < suggestions.length) {
                const item = suggestions[index];
                const word = item.latin || item.word || item;
                
                searchInput.value = word;
                hideSuggestions();
                
                // Fetch the word details and similar words
                await displayResult(item);
            }
        }
        
        // Display result card
        async function displayResult(item) {
            const latin = item.latin || item.word || '';
            const cyrillic = item.cyrillic || '';
            
            // Update result card
            document.getElementById('selectedWordLatin').textContent = latin;
            document.getElementById('selectedWordCyrillic').textContent = cyrillic;
            document.getElementById('resultLatin').textContent = latin;
            document.getElementById('resultCyrillic').textContent = cyrillic;
            
            // Hide examples, show result
            examplesSection.style.display = 'none';
            resultContainer.classList.add('show');
            
            // Fetch similar words (words that start with the same 2-3 letters)
            await fetchSimilarWords(latin);
        }
        
        // Fetch similar words
        async function fetchSimilarWords(word) {
            const similarList = document.getElementById('similarWordsList');
            
            if (word.length < 2) {
                similarList.innerHTML = '';
                return;
            }
            
            const prefix = word.substring(0, Math.min(3, word.length));
            
            try {
                const response = await fetch(`${API_BASE}/words?starts_with=${encodeURIComponent(prefix)}&limit=10`);
                const data = await response.json();
                
                if (data.data && data.data.length > 0) {
                    // Filter out the current word and limit to 5
                    const similar = data.data
                        .filter(w => (w.latin || w.word) !== word)
                        .slice(0, 5);
                    
                    let html = '';
                    similar.forEach(item => {
                        const lat = item.latin || item.word || '';
                        const cyr = item.cyrillic || '';
                        html += `
                            <div class="similar-word" data-word="${lat}" data-cyrillic="${cyr}">
                                <div class="similar-word-latin">${lat}</div>
                                <div class="similar-word-cyrillic">${cyr}</div>
                            </div>
                        `;
                    });
                    
                    similarList.innerHTML = html;
                    
                    // Add click handlers for similar words
                    similarList.querySelectorAll('.similar-word').forEach(el => {
                        el.addEventListener('click', function() {
                            const wordData = {
                                latin: this.dataset.word,
                                cyrillic: this.dataset.cyrillic
                            };
                            searchInput.value = wordData.latin;
                            displayResult(wordData);
                        });
                    });
                }
            } catch (error) {
                console.error('Error fetching similar words:', error);
            }
        }
        
        // Keyboard navigation
        function updateSelection(newIndex) {
            const items = suggestionsDropdown.querySelectorAll('.suggestion-item');
            
            // Remove previous selection
            items.forEach(item => item.classList.remove('selected'));
            
            if (newIndex >= 0 && newIndex < items.length) {
                selectedIndex = newIndex;
                items[selectedIndex].classList.add('selected');
                items[selectedIndex].scrollIntoView({ block: 'nearest' });
            } else {
                selectedIndex = -1;
            }
        }
        
        // Event listeners
        const debouncedFetch = debounce(fetchSuggestions, 250);
        
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                debouncedFetch(query);
            } else {
                hideSuggestions();
            }
        });
        
        searchInput.addEventListener('keydown', function(e) {
            const items = suggestionsDropdown.querySelectorAll('.suggestion-item');
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (items.length > 0) {
                        updateSelection(selectedIndex < items.length - 1 ? selectedIndex + 1 : 0);
                    }
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    if (items.length > 0) {
                        updateSelection(selectedIndex > 0 ? selectedIndex - 1 : items.length - 1);
                    }
                    break;
                    
                case 'Enter':
                    e.preventDefault();
                    if (selectedIndex >= 0) {
                        selectSuggestion(selectedIndex);
                    }
                    break;
                    
                case 'Escape':
                    hideSuggestions();
                    break;
            }
        });
        
        // Click outside to close suggestions
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsDropdown.contains(e.target)) {
                hideSuggestions();
            }
        });
        
        // Example words click
        document.querySelectorAll('.example-word').forEach(el => {
            el.addEventListener('click', function() {
                const word = this.dataset.word;
                searchInput.value = word;
                debouncedFetch(word);
            });
        });
        
        // Focus on input
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && suggestions.length > 0) {
                showSuggestions();
            }
        });
    });
    </script>
</body>
</html>
