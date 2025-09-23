<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="A comprehensive CodeIgniter4 API serving Serbian words, names, and surnames with Latin/Cyrillic transliteration support.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Prism.js for syntax highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    
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

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-color) 0%, #c0392b 100%);
            color: white;
            border: none;
            padding: 15px 35px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            padding: 15px 35px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .api-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .api-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .api-examples {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            border-left: 4px solid var(--primary-color);
        }

        .example-link {
            color: var(--primary-color);
            text-decoration: none;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 8px;
            padding: 5px 8px;
            background: white;
            border-radius: 4px;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .example-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        .example-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .api-method {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .api-endpoint {
            color: var(--accent-color);
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .use-case-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .use-case-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .use-case-icon {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .code-container {
            background: #2d3748;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .code-header {
            background: #4a5568;
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            border-bottom: 1px solid #718096;
        }

        .code-content {
            padding: 0;
        }

        pre[class*="language-"] {
            margin: 0;
            border-radius: 0;
        }

        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 3rem 0 2rem;
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

        .stats-section {
            background: var(--light-bg);
            padding: 4rem 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--secondary-color);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }

            .github-link {
                position: static;
                display: inline-flex;
                margin-top: 1rem;
                background: var(--primary-color);
                border: 1px solid var(--primary-color);
            }
        }

        .api-examples {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 0.375rem;
            margin-top: 1rem;
        }

        .example-description {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .example-link {
            display: block;
            font-family: 'Consolas', 'Monaco', monospace;
            background: #e9ecef;
            padding: 0.5rem;
            border-radius: 0.25rem;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            word-break: break-all;
            transition: all 0.3s ease;
        }

        .example-link:hover {
            background: var(--primary-color);
            color: white;
            text-decoration: none;
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
            <a class="navbar-brand" href="#home">
                <i class="fas fa-book-open me-2"></i>
                <?= esc($title) ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#documentation">Documentation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#use-cases">Use Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#examples">Examples</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('converter') ?>">
                            <i class="fas fa-exchange-alt me-1"></i>Text Converter
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="<?= esc($github_url) ?>" target="_blank" class="github-link">
                        <i class="fab fa-github"></i>
                        <span class="d-none d-lg-inline">GitHub</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <img src="serbian_flag.jpg" alt="Serbian flag" width="120" class="mb-3">
                    <h1 class="hero-title"><?= esc($title) ?></h1>
                    <p class="hero-subtitle">
                        A comprehensive CodeIgniter4 API serving Serbian words, names, and surnames with Latin/Cyrillic transliteration support
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#documentation" class="btn btn-primary-custom">
                            <i class="fas fa-book"></i>
                            <span>View Documentation</span>
                        </a>
                        <a href="<?= base_url('converter') ?>" class="btn btn-outline-custom">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Text Converter</span>
                        </a>
                        <a href="<?= esc($github_url) ?>" target="_blank" class="btn btn-outline-custom">
                            <i class="fab fa-github"></i>
                            <span>View on GitHub</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">2.8M+</div>
                        <div class="stat-label">Words</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">1.8K+</div>
                        <div class="stat-label">Names</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">8K+</div>
                        <div class="stat-label">Surnames</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">2</div>
                        <div class="stat-label">Scripts</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Documentation Section -->
    <section id="documentation" class="py-5">
        <div class="container">
            <h2 class="section-title">API Documentation</h2>
            <div class="row">
                <?php foreach ($api_endpoints as $endpoint): ?>
                <div class="col-12 mb-5">
                    <div class="card api-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="api-method me-3"><?= esc($endpoint['method']) ?></span>
                                <code class="api-endpoint"><?= esc($endpoint['endpoint']) ?></code>
                            </div>
                            <p class="card-text mb-4"><?= esc($endpoint['description']) ?></p>
                            
                            <h6 class="mb-3"><i class="fas fa-cogs me-2"></i>Parameters:</h6>
                            <div class="row mb-4">
                                <?php foreach ($endpoint['params'] as $param => $description): ?>
                                <div class="col-md-6 mb-2">
                                    <strong class="text-primary"><?= esc($param) ?>:</strong>
                                    <small class="text-muted d-block"><?= esc($description) ?></small>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <?php if (isset($endpoint['examples'])): ?>
                            <div class="api-examples">
                                <h6 class="mb-3"><i class="fas fa-code me-2"></i>Live Examples:</h6>
                                <?php foreach ($endpoint['examples'] as $example => $desc): ?>
                                <div class="example-description"><?= esc($desc) ?></div>
                                <a href="<?= esc($base_url . ltrim($example, '/')) ?>" target="_blank" class="example-link">
                                    <?= esc($base_url . ltrim($example, '/')) ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Use Cases Section -->
    <section id="use-cases" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Use Cases</h2>
            <div class="row">
                <?php foreach ($use_cases as $index => $case): ?>
                <div class="col-lg-6 mb-4">
                    <div class="use-case-card">
                        <div class="use-case-icon">
                            <?php 
                            $icons = ['fas fa-random', 'fas fa-check-circle', 'fas fa-search', 'fas fa-exchange-alt'];
                            echo '<i class="' . $icons[$index] . '"></i>';
                            ?>
                        </div>
                        <h4 class="mb-3"><?= esc($case['title']) ?></h4>
                        <p class="mb-3"><?= esc($case['description']) ?></p>
                        <code class="api-endpoint"><?= esc($case['endpoint']) ?></code>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Code Examples Section -->
    <section id="examples" class="py-5">
        <div class="container">
            <h2 class="section-title">Code Examples</h2>
            
            <!-- JavaScript Example -->
            <div class="code-container">
                <div class="code-header">
                    <i class="fab fa-js-square me-2"></i>JavaScript Example
                </div>
                <div class="code-content">
                    <pre><code class="language-javascript">// Fetch random Serbian word
async function getRandomWord() {
    try {
        const response = await fetch('<?= esc($base_url) ?>api/random?type=word');
        const data = await response.json();
        
        console.log('Random word:', data.data.word);
        console.log('Cyrillic:', data.data.cyrillic);
        console.log('Length:', data.data.length);
    } catch (error) {
        console.error('Error:', error);
    }
}

// Search words by prefix
async function searchWords(prefix, limit = 10) {
    const url = `<?= esc($base_url) ?>api/words?starts_with=${prefix}&limit=${limit}`;
    const response = await fetch(url);
    const data = await response.json();
    
    return data.data; // Array of words
}</code></pre>
                </div>
            </div>

            <!-- Python Example -->
            <div class="code-container">
                <div class="code-header">
                    <i class="fab fa-python me-2"></i>Python Example
                </div>
                <div class="code-content">
                    <pre><code class="language-python">import requests
import json

class SerbianDictionaryAPI:
    def __init__(self, base_url='<?= esc($base_url) ?>'):
        self.base_url = base_url.rstrip('/')
    
    def get_random_word(self, word_type='word'):
        """Get random Serbian word or name"""
        url = f"{self.base_url}/api/random"
        params = {'type': word_type}
        
        response = requests.get(url, params=params)
        response.raise_for_status()
        
        return response.json()['data']
    
    def search_words(self, starts_with=None, contains=None, limit=50):
        """Search words with various filters"""
        url = f"{self.base_url}/api/words"
        params = {'limit': limit}
        
        if starts_with:
            params['starts_with'] = starts_with
        if contains:
            params['contains'] = contains
            
        response = requests.get(url, params=params)
        response.raise_for_status()
        
        return response.json()['data']
    
    def transliterate(self, text, to_script='cyrillic'):
        """Transliterate text between Latin and Cyrillic"""
        url = f"{self.base_url}/api/transliterate"
        params = {'text': text, 'to': to_script}
        
        response = requests.get(url, params=params)
        response.raise_for_status()
        
        return response.json()['data']['transliterated']

# Example usage
api = SerbianDictionaryAPI()

# Get random word
random_word = api.get_random_word()
print(f"Random word: {random_word['word']} ({random_word['cyrillic']})")

# Search words starting with 'pre'
words = api.search_words(starts_with='pre', limit=5)
for word in words:
    print(f"{word['word']} -> {word['cyrillic']}")

# Transliterate text
cyrillic_text = api.transliterate("Zdravo, svete!", "cyrillic")
print(f"Cyrillic: {cyrillic_text}")</code></pre>
                </div>
            </div>

            <!-- PHP Example -->
            <div class="code-container">
                <div class="code-header">
                    <i class="fab fa-php me-2"></i>PHP Example
                </div>
                <div class="code-content">
                    <pre><code class="language-php">&lt;?php
class SerbianDictionaryAPI {
    private $baseUrl;
    
    public function __construct($baseUrl = '<?= esc($base_url) ?>') {
        $this->baseUrl = rtrim($baseUrl, '/');
    }
    
    public function getSerbianNames($gender = 'all', $withVocative = true, $limit = 100) {
        $url = $this->baseUrl . '/api/names';
        $params = [
            'gender' => $gender,
            'with_vocative' => $withVocative ? 'true' : 'false',
            'limit' => $limit
        ];
        
        $response = $this->makeRequest($url, $params);
        return $response['data'];
    }
    
    public function searchSurnames($startsWith = null, $limit = 100) {
        $url = $this->baseUrl . '/api/surnames';
        $params = ['limit' => $limit];
        
        if ($startsWith) {
            $params['starts_with'] = $startsWith;
        }
        
        $response = $this->makeRequest($url, $params);
        return $response['data'];
    }
    
    private function makeRequest($url, $params = []) {
        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("API request failed with status $httpCode");
        }
        
        return json_decode($response, true);
    }
}

// Example usage
$api = new SerbianDictionaryAPI();

try {
    $maleNames = $api->getSerbianNames('male', true, 10);
    foreach ($maleNames as $name) {
        echo "{$name['name']} ({$name['cyrillic']})\n";
        echo "Vocative: {$name['vocative']}\n\n";
    }
    
    $surnames = $api->searchSurnames('P', 5);
    echo "Surnames starting with 'P':\n";
    foreach ($surnames as $surname) {
        echo "- {$surname['surname']} ({$surname['cyrillic']})\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?&gt;</code></pre>
                </div>
            </div>

            <!-- Ruby Example -->
            <div class="code-container">
                <div class="code-header">
                    <i class="fas fa-gem me-2"></i>Ruby Example
                </div>
                <div class="code-content">
                    <pre><code class="language-ruby">require 'net/http'
require 'json'
require 'uri'

class SerbianDictionaryAPI
  def initialize(base_url = '<?= esc($base_url) ?>')
    @base_url = base_url.chomp('/')
  end
  
  def random_word(type: 'word')
    params = { type: type }
    response = make_request('/api/random', params)
    response['data']
  end
  
  def search_words(starts_with: nil, contains: nil, length: nil, limit: 50)
    params = { limit: limit }
    params[:starts_with] = starts_with if starts_with
    params[:contains] = contains if contains
    params[:length] = length if length
    
    response = make_request('/api/words', params)
    response['data']
  end
  
  def transliterate(text, to: 'cyrillic')
    params = { text: text, to: to }
    response = make_request('/api/transliterate', params)
    response['data']['transliterated']
  end
  
  def names(gender: 'all', with_vocative: true, limit: 100)
    params = {
      gender: gender,
      with_vocative: with_vocative,
      limit: limit
    }
    response = make_request('/api/names', params)
    response['data']
  end
  
  private
  
  def make_request(endpoint, params = {})
    uri = URI("#{@base_url}#{endpoint}")
    uri.query = URI.encode_www_form(params) unless params.empty?
    
    response = Net::HTTP.get_response(uri)
    
    unless response.is_a?(Net::HTTPSuccess)
      raise "API request failed: #{response.code} #{response.message}"
    end
    
    JSON.parse(response.body)
  end
end

# Example usage
api = SerbianDictionaryAPI.new

# Get random word
random_word = api.random_word
puts "Random word: #{random_word['word']} (#{random_word['cyrillic']})"
puts "Length: #{random_word['length']} characters"

# Search for words containing 'grad'
words = api.search_words(contains: 'grad', limit: 5)
puts "\nWords containing 'grad':"
words.each do |word|
  puts "- #{word['word']} -> #{word['cyrillic']}"
end

# Get female names with vocative forms
names = api.names(gender: 'female', with_vocative: true, limit: 3)
puts "\nFemale names with vocative:"
names.each do |name|
  puts "#{name['name']} (#{name['cyrillic']}) -> Vocative: #{name['vocative']}"
end</code></pre>
                </div>
            </div>

            <!-- Go Example -->
            <div class="code-container">
                <div class="code-header">
                    <i class="fas fa-code me-2"></i>Go Example
                </div>
                <div class="code-content">
                    <pre><code class="language-go">package main

import (
    "encoding/json"
    "fmt"
    "io"
    "net/http"
    "net/url"
    "strconv"
)

type SerbianDictionaryAPI struct {
    BaseURL string
}

type APIResponse struct {
    Success bool        `json:"success"`
    Data    interface{} `json:"data"`
    Message string      `json:"message,omitempty"`
}

type Word struct {
    Word     string `json:"word"`
    Cyrillic string `json:"cyrillic"`
    Length   int    `json:"length"`
}

type Name struct {
    Name     string `json:"name"`
    Cyrillic string `json:"cyrillic"`
    Vocative string `json:"vocative"`
    Gender   string `json:"gender"`
}

func NewSerbianDictionaryAPI() *SerbianDictionaryAPI {
    return &SerbianDictionaryAPI{
        BaseURL: "<?= esc($base_url) ?>",
    }
}

func (api *SerbianDictionaryAPI) GetRandomWord(wordType string) (*Word, error) {
    params := url.Values{}
    params.Add("type", wordType)
    
    var response APIResponse
    err := api.makeRequest("/api/random", params, &response)
    if err != nil {
        return nil, err
    }
    
    wordData, _ := json.Marshal(response.Data)
    var word Word
    json.Unmarshal(wordData, &word)
    
    return &word, nil
}

func (api *SerbianDictionaryAPI) SearchWords(startsWith string, limit int) ([]Word, error) {
    params := url.Values{}
    if startsWith != "" {
        params.Add("starts_with", startsWith)
    }
    params.Add("limit", strconv.Itoa(limit))
    
    var response APIResponse
    err := api.makeRequest("/api/words", params, &response)
    if err != nil {
        return nil, err
    }
    
    wordsData, _ := json.Marshal(response.Data)
    var words []Word
    json.Unmarshal(wordsData, &words)
    
    return words, nil
}

func (api *SerbianDictionaryAPI) GetNames(gender string, withVocative bool, limit int) ([]Name, error) {
    params := url.Values{}
    params.Add("gender", gender)
    params.Add("with_vocative", strconv.FormatBool(withVocative))
    params.Add("limit", strconv.Itoa(limit))
    
    var response APIResponse
    err := api.makeRequest("/api/names", params, &response)
    if err != nil {
        return nil, err
    }
    
    namesData, _ := json.Marshal(response.Data)
    var names []Name
    json.Unmarshal(namesData, &names)
    
    return names, nil
}

func (api *SerbianDictionaryAPI) makeRequest(endpoint string, params url.Values, result interface{}) error {
    fullURL := api.BaseURL + endpoint
    if len(params) > 0 {
        fullURL += "?" + params.Encode()
    }
    
    resp, err := http.Get(fullURL)
    if err != nil {
        return err
    }
    defer resp.Body.Close()
    
    body, err := io.ReadAll(resp.Body)
    if err != nil {
        return err
    }
    
    return json.Unmarshal(body, result)
}

func main() {
    api := NewSerbianDictionaryAPI()
    
    // Get random word
    word, err := api.GetRandomWord("word")
    if err != nil {
        fmt.Printf("Error: %v\n", err)
        return
    }
    fmt.Printf("Random word: %s (%s) - Length: %d\n", 
        word.Word, word.Cyrillic, word.Length)
    
    // Search words
    words, err := api.SearchWords("pre", 5)
    if err != nil {
        fmt.Printf("Error: %v\n", err)
        return
    }
    
    fmt.Println("\nWords starting with 'pre':")
    for _, w := range words {
        fmt.Printf("- %s -> %s\n", w.Word, w.Cyrillic)
    }
    
    // Get names
    names, err := api.GetNames("male", true, 3)
    if err != nil {
        fmt.Printf("Error: %v\n", err)
        return
    }
    
    fmt.Println("\nMale names with vocative:")
    for _, name := range names {
        fmt.Printf("%s (%s) -> Vocative: %s\n", 
            name.Name, name.Cyrillic, name.Vocative)
    }
}</code></pre>
                </div>
            </div>

            <!-- cURL Example -->
            <div class="code-container">
                <div class="code-header">
                    <i class="fas fa-terminal me-2"></i>cURL Examples
                </div>
                <div class="code-content">
                    <pre><code class="language-bash"># Get random word
curl "<?= esc($base_url) ?>api/random?type=word"

# Search words starting with 'pre'
curl "<?= esc($base_url) ?>api/words?starts_with=pre&limit=5"

# Get male names with vocative forms
curl "<?= esc($base_url) ?>api/names?gender=male&with_vocative=true&limit=10"

# Transliterate text to Cyrillic
curl "<?= esc($base_url) ?>api/transliterate?text=Zdravo%20svete&to=cyrillic"

# Get specific word details
curl "<?= esc($base_url) ?>api/words/čovek"

# Search words by length
curl "<?= esc($base_url) ?>api/words?length=5&limit=10"

# Get surnames starting with specific letter
curl "<?= esc($base_url) ?>api/surnames?starts_with=M&limit=15"

# Get statistics
curl "<?= esc($base_url) ?>api/stats"</code></pre>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?= esc($title) ?></h5>
                    <p class="mb-0">A comprehensive Serbian language API with transliteration support.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mb-2">
                        <a href="<?= esc($github_url) ?>" target="_blank" class="text-light text-decoration-none">
                            <i class="fab fa-github me-2"></i>View on GitHub
                        </a>
                    </div>
                    <div>
                        <small>Version <?= esc($version) ?> &copy; <?= date('Y') ?></small>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Prism.js for syntax highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add active class to navbar on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // API Demo functionality
        async function testAPI() {
            try {
                const response = await fetch('<?= esc($base_url) ?>api/random?type=word');
                const data = await response.json();
                
                if (data.success) {
                    alert(`Random word: ${data.data.word} (${data.data.cyrillic})`);
                } else {
                    alert('API test failed');
                }
            } catch (error) {
                alert('API connection error');
            }
        }
    </script>
</body>
</html>