<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => lang('App.site.title'),
            'version' => '1.0.0',
            'github_url' => 'https://github.com/ivkeapp/serbian-dictionary-api',
            'base_url' => base_url(),
            'api_endpoints' => [
                [
                    'method' => 'GET',
                    'endpoint' => '/api/words',
                    'description' => lang('App.api.words.description'),
                    'params' => [
                        'dataset' => lang('App.api.words.param.dataset'),
                        'script' => lang('App.api.words.param.script'),
                        'starts_with' => lang('App.api.words.param.starts_with'),
                        'contains' => lang('App.api.words.param.contains'),
                        'length' => lang('App.api.words.param.length'),
                        'min_length' => lang('App.api.words.param.min_length'),
                        'max_length' => lang('App.api.words.param.max_length'),
                        'random' => lang('App.api.words.param.random'),
                        'page' => lang('App.api.words.param.page'),
                        'limit' => lang('App.api.words.param.limit')
                    ],
                    'examples' => [
                        '/api/words?dataset=small&limit=10' => lang('App.api.words.example.1'),
                        '/api/words?starts_with=pre&script=cyrillic' => lang('App.api.words.example.2'),
                        '/api/words?length=5&random=true&limit=20' => lang('App.api.words.example.3'),
                        '/api/words?contains=ov&min_length=6' => lang('App.api.words.example.4'),
                        '/api/words?dataset=large&max_length=4' => lang('App.api.words.example.5')
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/names',
                    'description' => lang('App.api.names.description'),
                    'params' => [
                        'gender' => lang('App.api.names.param.gender'),
                        'starts_with' => lang('App.api.names.param.starts_with'),
                        'with_vocative' => lang('App.api.names.param.with_vocative'),
                        'random' => lang('App.api.names.param.random'),
                        'page' => lang('App.api.names.param.page'),
                        'limit' => lang('App.api.names.param.limit')
                    ],
                    'examples' => [
                        '/api/names?gender=male&limit=15' => lang('App.api.names.example.1'),
                        '/api/names?starts_with=M&with_vocative=true' => lang('App.api.names.example.2'),
                        '/api/names?gender=female&random=true&limit=5' => lang('App.api.names.example.3'),
                        '/api/names?with_vocative=true&page=2' => lang('App.api.names.example.4')
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/surnames',
                    'description' => lang('App.api.surnames.description'),
                    'params' => [
                        'starts_with' => lang('App.api.surnames.param.starts_with'),
                        'random' => lang('App.api.surnames.param.random'),
                        'page' => lang('App.api.surnames.param.page'),
                        'limit' => lang('App.api.surnames.param.limit')
                    ],
                    'examples' => [
                        '/api/surnames?starts_with=Pet&limit=10' => lang('App.api.surnames.example.1'),
                        '/api/surnames?random=true&limit=20' => lang('App.api.surnames.example.2'),
                        '/api/surnames?starts_with=Ž' => lang('App.api.surnames.example.3')
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/transliterate',
                    'description' => lang('App.api.transliterate.description'),
                    'params' => [
                        'text' => lang('App.api.transliterate.param.text'),
                        'to' => lang('App.api.transliterate.param.to')
                    ],
                    'examples' => [
                        '/api/transliterate?text=Zdravo' => lang('App.api.transliterate.example.1'),
                        '/api/transliterate?text=Добро jutro&to=latin' => lang('App.api.transliterate.example.2'),
                        '/api/transliterate?text=Miloš Petrović&to=cyrillic' => lang('App.api.transliterate.example.3')
                    ]
                ],
                [
                    'method' => 'GET',
                    'endpoint' => '/api/random',
                    'description' => lang('App.api.random.description'),
                    'params' => [
                        'type' => lang('App.api.random.param.type')
                    ],
                    'examples' => [
                        '/api/random?type=word' => lang('App.api.random.example.1'),
                        '/api/random?type=name' => lang('App.api.random.example.2'),
                        '/api/random?type=surname' => lang('App.api.random.example.3')
                    ]
                ]
            ],
            'use_cases' => [
                [
                    'title' => lang('App.useCase.language.title'),
                    'description' => lang('App.useCase.language.description'),
                    'endpoint' => '/api/random?type=word'
                ],
                [
                    'title' => lang('App.useCase.content.title'),
                    'description' => lang('App.useCase.content.description'),
                    'endpoint' => '/api/names/Miloš'
                ],
                [
                    'title' => lang('App.useCase.localization.title'),
                    'description' => lang('App.useCase.localization.description'),
                    'endpoint' => '/api/words?starts_with=pre&limit=10'
                ],
                [
                    'title' => lang('App.useCase.research.title'),
                    'description' => lang('App.useCase.research.description'),
                    'endpoint' => '/api/transliterate?text=Zdravo&to=cyrillic'
                ]
            ]
        ];

        return view('homepage', $data);
    }
    
    /**
     * Change language
     */
    public function setLanguage($locale = 'en')
    {
        $session = session();
        $supportedLocales = ['en', 'sr-Lat', 'sr-Cyrl'];
        
        if (in_array($locale, $supportedLocales)) {
            $session->set('locale', $locale);
        }
        
        return redirect()->back();
    }
}
