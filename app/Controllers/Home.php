<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Serbian Dictionary API',
            'version' => '1.0.0',
            'github_url' => 'https://github.com/ivkeapp/serbian-dictionary-api',
            'base_url' => base_url(),
            'api_endpoints' => [
                [
                    'method' => 'GET',
                    'endpoint' => '/api/words',
                    'description' => 'Get paginated list of Serbian words with filtering options',
                    'params' => [
                        'dataset' => 'Choose between small (41K words) or large (2.8M words) dataset',
                        'script' => 'Return words in Latin or Cyrillic script',
                        'starts_with' => 'Filter words that start with specific letters',
                        'contains' => 'Filter words that contain specific text',
                        'length' => 'Filter words by exact character length',
                        'min_length' => 'Filter words with minimum character length',
                        'max_length' => 'Filter words with maximum character length',
                        'random' => 'Randomize the order of results',
                        'page' => 'Page number for pagination (default: 1)',
                        'limit' => 'Number of results per page (default: 50, max: 100)'
                    ],
                    'examples' => [
                        '/api/words?dataset=small&limit=10' => 'Get first 10 words from small dataset',
                        '/api/words?starts_with=pre&script=cyrillic' => 'Words starting with "pre" in Cyrillic',
                        '/api/words?length=5&random=true&limit=20' => '20 random 5-letter words',
                        '/api/words?contains=ov&min_length=6' => 'Words containing "ov" with 6+ characters',
                        '/api/words?dataset=large&max_length=4' => 'Short words (≤4 chars) from large dataset'
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/names',
                    'description' => 'Get Serbian names with gender information and vocative forms',
                    'params' => [
                        'gender' => 'Filter by male, female, or all genders',
                        'starts_with' => 'Filter names starting with specific letters',
                        'with_vocative' => 'Include vocative forms in response',
                        'random' => 'Randomize the order of results',
                        'page' => 'Page number for pagination',
                        'limit' => 'Number of results per page'
                    ],
                    'examples' => [
                        '/api/names?gender=male&limit=15' => 'Get 15 male names',
                        '/api/names?starts_with=M&with_vocative=true' => 'Names starting with "M" with vocative forms',
                        '/api/names?gender=female&random=true&limit=5' => '5 random female names',
                        '/api/names?with_vocative=true&page=2' => 'Second page of names with vocatives'
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/surnames',
                    'description' => 'Get Serbian surnames with Latin/Cyrillic variants',
                    'params' => [
                        'starts_with' => 'Filter surnames starting with specific letters',
                        'random' => 'Randomize the order of results',
                        'page' => 'Page number for pagination',
                        'limit' => 'Number of results per page'
                    ],
                    'examples' => [
                        '/api/surnames?starts_with=Pet&limit=10' => 'Surnames starting with "Pet"',
                        '/api/surnames?random=true&limit=20' => '20 random surnames',
                        '/api/surnames?starts_with=Ž' => 'All surnames starting with "Ž"'
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/transliterate',
                    'description' => 'Convert text between Latin and Cyrillic scripts',
                    'params' => [
                        'text' => 'Text to be transliterated (required)',
                        'to' => 'Target script: latin or cyrillic (auto-detected if omitted)'
                    ],
                    'examples' => [
                        '/api/transliterate?text=Zdravo' => 'Auto-detect and convert "Zdravo"',
                        '/api/transliterate?text=Добро jutro&to=latin' => 'Convert mixed text to Latin',
                        '/api/transliterate?text=Miloš Petrović&to=cyrillic' => 'Convert name to Cyrillic'
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/random',
                    'description' => 'Get random entry from any dataset type',
                    'params' => [
                        'type' => 'Entry type: word, name, or surname (required)'
                    ],
                    'examples' => [
                        '/api/random?type=word' => 'Get a random Serbian word',
                        '/api/random?type=name' => 'Get a random Serbian name with vocative',
                        '/api/random?type=surname' => 'Get a random Serbian surname'
                    ]
                ]
            ],
            'use_cases' => [
                [
                    'title' => 'Random Word Generator',
                    'description' => 'Generate random Serbian words for language learning apps',
                    'endpoint' => '/api/random?type=word'
                ],
                [
                    'title' => 'Name Validation',
                    'description' => 'Validate Serbian names and get their vocative forms',
                    'endpoint' => '/api/names/Miloš'
                ],
                [
                    'title' => 'Text Search',
                    'description' => 'Search words by prefix for autocomplete features',
                    'endpoint' => '/api/words?starts_with=pre&limit=10'
                ],
                [
                    'title' => 'Script Conversion',
                    'description' => 'Convert text between Latin and Cyrillic scripts',
                    'endpoint' => '/api/transliterate?text=Zdravo&to=cyrillic'
                ]
            ]
        ];

        return view('homepage', $data);
    }
}
