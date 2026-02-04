<?php

return [
    // Site metadata
    'site.title' => 'Serbian Dictionary API',
    'site.version' => 'Version',
    'site.description' => 'A comprehensive CodeIgniter4 API serving Serbian words, names, and surnames with Latin/Cyrillic transliteration support.',
    
    // Navigation
    'nav.home' => 'Home',
    'nav.api_docs' => 'API Docs',
    'nav.converter' => 'Converter',
    'nav.use_cases' => 'Use Cases',
    'nav.examples' => 'Examples',
    'nav.github' => 'GitHub',
    
    // Hero section
    'hero.title' => 'Serbian Dictionary API',
    'hero.subtitle' => 'A comprehensive CodeIgniter4 API serving Serbian words, names, and surnames with Latin/Cyrillic transliteration support.',
    'hero.getStarted' => 'Get Started',
    'hero.viewDocs' => 'View Documentation',
    
    // Stats
    'stats.words' => 'Words',
    'stats.names' => 'Names',
    'stats.surnames' => 'Surnames',
    'stats.scripts' => 'Scripts',
    
    // API Documentation section
    'apiDocs.title' => 'API Documentation',
    'apiDocs.params' => 'Parameters',
    'apiDocs.examples' => 'Examples',
    
    // API Endpoints
    'api.words.description' => 'Get paginated list of Serbian words with filtering options',
    'api.words.param.dataset' => 'Choose between small (41K words) or large (2.8M words) dataset',
    'api.words.param.script' => 'Return words in Latin or Cyrillic script',
    'api.words.param.starts_with' => 'Filter words that start with specific letters',
    'api.words.param.contains' => 'Filter words that contain specific text',
    'api.words.param.length' => 'Filter words by exact character length',
    'api.words.param.min_length' => 'Filter words with minimum character length',
    'api.words.param.max_length' => 'Filter words with maximum character length',
    'api.words.param.random' => 'Randomize the order of results',
    'api.words.param.page' => 'Page number for pagination (default: 1)',
    'api.words.param.limit' => 'Number of results per page (default: 50, max: 100)',
    'api.words.example.1' => 'Get first 10 words from small dataset',
    'api.words.example.2' => 'Words starting with "pre" in Cyrillic',
    'api.words.example.3' => '20 random 5-letter words',
    'api.words.example.4' => 'Words containing "ov" with 6+ characters',
    'api.words.example.5' => 'Short words (≤4 chars) from large dataset',
    
    'api.names.description' => 'Get Serbian names with gender information and vocative forms',
    'api.names.param.gender' => 'Filter by male, female, or all genders',
    'api.names.param.starts_with' => 'Filter names starting with specific letters',
    'api.names.param.with_vocative' => 'Include vocative forms in response',
    'api.names.param.random' => 'Randomize the order of results',
    'api.names.param.page' => 'Page number for pagination',
    'api.names.param.limit' => 'Number of results per page',
    'api.names.example.1' => 'Get 15 male names',
    'api.names.example.2' => 'Names starting with "M" with vocative forms',
    'api.names.example.3' => '5 random female names',
    'api.names.example.4' => 'Second page of names with vocatives',
    
    'api.surnames.description' => 'Get Serbian surnames with Latin/Cyrillic variants',
    'api.surnames.param.starts_with' => 'Filter surnames starting with specific letters',
    'api.surnames.param.random' => 'Randomize the order of results',
    'api.surnames.param.page' => 'Page number for pagination',
    'api.surnames.param.limit' => 'Number of results per page',
    'api.surnames.example.1' => 'Surnames starting with "Pet"',
    'api.surnames.example.2' => '20 random surnames',
    'api.surnames.example.3' => 'All surnames starting with "Ž"',
    
    'api.transliterate.description' => 'Convert text between Latin and Cyrillic scripts',
    'api.transliterate.param.text' => 'Text to be transliterated (required)',
    'api.transliterate.param.to' => 'Target script: latin or cyrillic (auto-detected if omitted)',
    'api.transliterate.example.1' => 'Auto-detect and convert "Zdravo"',
    'api.transliterate.example.2' => 'Convert mixed text to Latin',
    'api.transliterate.example.3' => 'Convert name to Cyrillic',
    
    'api.random.description' => 'Get random entry from any dataset type',
    'api.random.param.type' => 'Entry type: word, name, or surname (required)',
    'api.random.example.1' => 'Get a random Serbian word',
    'api.random.example.2' => 'Get a random Serbian name with vocative',
    'api.random.example.3' => 'Get a random Serbian surname',
    
    // Use Cases section
    'useCases.title' => 'Use Cases',
    'useCase.language.title' => 'Language Learning Applications',
    'useCase.language.description' => 'Integrate Serbian vocabulary into language learning apps and flashcard systems with automatic transliteration between scripts.',
    'useCase.content.title' => 'Content Generation',
    'useCase.content.description' => 'Generate realistic Serbian names and text for testing, demo data, or creative writing projects.',
    'useCase.localization.title' => 'Localization Tools',
    'useCase.localization.description' => 'Build tools that help with Serbian language localization, supporting both Latin and Cyrillic scripts seamlessly.',
    'useCase.research.title' => 'Linguistic Research',
    'useCase.research.description' => 'Access comprehensive Serbian language datasets for linguistic analysis, NLP projects, and academic research.',
    
    // Code Examples section
    'codeExamples.title' => 'Code Examples',
    'codeExamples.subtitle' => 'Quick integration examples in popular programming languages',
    
    // Features section
    'features.comprehensive.title' => 'Comprehensive Database',
    'features.comprehensive.description' => 'Access to extensive collections of Serbian words, names, and surnames.',
    'features.bilingual.title' => 'Bilingual Support',
    'features.bilingual.description' => 'Full support for both Latin and Cyrillic scripts with automatic conversion.',
    'features.flexible.title' => 'Flexible Filtering',
    'features.flexible.description' => 'Advanced filtering options including starts with, contains, length, and more.',
    'features.modern.title' => 'Modern API',
    'features.modern.description' => 'RESTful API with JSON responses, pagination, and comprehensive documentation.',
    
    // Footer
    'footer.builtWith' => 'Built with',
    'footer.openSource' => 'Open Source',
    'footer.license' => 'Licensed under MIT',
    'footer.viewOnGithub' => 'View on GitHub',
    
    // Converter page
    'converter.title' => 'Serbian Text Converter',
    'converter.description' => 'Convert Serbian text between Latin and Cyrillic scripts',
    'converter.direction.auto' => 'Auto Detect',
    'converter.direction.latinToCyrillic' => 'Latin → Cyrillic',
    'converter.direction.cyrillicToLatin' => 'Cyrillic → Latin',
    'converter.input.label' => 'Input Text',
    'converter.input.placeholder' => 'Type or paste your Serbian text here...',
    'converter.output.label' => 'Output',
    'converter.output.placeholder' => 'Converted text will appear here...',
    'converter.button.copy' => 'Copy Text',
    'converter.button.clear' => 'Clear',
    'converter.button.swap' => 'Swap input and output',
    'converter.message.copied' => 'Copied to clipboard!',
    'converter.message.cleared' => 'Text cleared!',
    'converter.feature.instant.title' => 'Instant Conversion',
    'converter.feature.instant.description' => 'Real-time transliteration as you type',
    'converter.feature.bidirectional.title' => 'Bidirectional',
    'converter.feature.bidirectional.description' => 'Convert between Latin and Cyrillic seamlessly',
    'converter.feature.accurate.title' => 'Accurate',
    'converter.feature.accurate.description' => 'Preserves special characters and diacritics',
    'converter.feature.free.title' => 'Free to Use',
    'converter.feature.free.description' => 'No registration or API key required',
    
    // Language switcher
    'lang.english' => 'English',
    'lang.serbian_latin' => 'Srpski (latinica)',
    'lang.serbian_cyrillic' => 'Српски (ćirilica)',
    
    // Search page
    'search.title' => 'Serbian Dictionary Search',
    'search.tagline' => 'Search and explore Serbian words easily.',
    'search.placeholder' => 'Type a word to search...',
    'search.no_results' => 'No results found',
    'search.min_chars' => 'Type at least 2 characters',
    'search.loading' => 'Searching...',
    'search.result_title' => 'Search Result',
    'search.similar_words' => 'Similar Words',
    'search.latin' => 'Latin',
    'search.cyrillic' => 'Cyrillic',
    'search.try_examples' => 'Try searching for:',
];
