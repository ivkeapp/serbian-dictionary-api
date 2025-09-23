<?php

namespace App\Controllers\ApiOld;

use App\Controllers\Api\BaseApiController;
use App\Libraries\Transliteration;

class Words extends BaseApiController
{
    private $transliteration;
    
    public function __construct()
    {
        $this->transliteration = new Transliteration();
    }
    
    /**
     * GET /api-old/words
     * Get paginated list of words with optional filters (JSON file based)
     */
    public function index()
    {
        try {
            $request = service('request');
            [$page, $limit] = $this->validatePagination();
            
            $filters = [
                'dataset' => $request->getGet('dataset') ?? 'small',
                'script' => $request->getGet('script') ?? 'latin',
                'starts_with' => $request->getGet('starts_with'),
                'contains' => $request->getGet('contains'),
                'length' => $request->getGet('length'),
                'min_length' => $request->getGet('min_length'),
                'max_length' => $request->getGet('max_length'),
                'random' => $this->isRandomRequest(),
                'page' => $page,
                'limit' => $limit
            ];
            
            // Validate dataset parameter
            if (!in_array($filters['dataset'], ['small', 'large'])) {
                return $this->errorResponse('Invalid dataset. Must be "small" or "large".');
            }
            
            // Validate script parameter
            if (!in_array($filters['script'], ['latin', 'cyrillic'])) {
                return $this->errorResponse('Invalid script. Must be "latin" or "cyrillic".');
            }
            
            $result = $this->getWordsFromJson($filters);
            
            return $this->paginatedResponse(
                $result['words'],
                $page,
                $limit,
                $result['total']
            );
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving words: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api-old/words/{word}
     * Get details for a specific word (JSON file based)
     */
    public function show($word = null)
    {
        if (empty($word)) {
            return $this->errorResponse('Word parameter is required.');
        }
        
        try {
            $wordData = $this->getWordFromJson($word);
            
            if ($wordData === null) {
                return $this->errorResponse('Word not found.', 404);
            }
            
            return $this->apiResponse($wordData);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving word: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Get words from JSON files
     */
    private function getWordsFromJson($filters)
    {
        $words = [];
        
        // Determine which file to use based on dataset
        if ($filters['dataset'] === 'small') {
            $filePath = ROOTPATH . 'public/resources/termsSelected.json';
        } else {
            $filePath = ROOTPATH . 'public/resources/serbian-words-lat.json';
        }
        
        if (!file_exists($filePath)) {
            throw new \Exception("Data file not found: {$filePath}");
        }
        
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding JSON: ' . json_last_error_msg());
        }
        
        if (empty($data)) {
            throw new \Exception('JSON file is empty or invalid');
        }
        
        // Process and filter words
        if ($filters['dataset'] === 'small') {
            // termsSelected.json is structured as an object with letters as keys
            foreach ($data as $letter => $letterWords) {
                if (is_array($letterWords)) {
                    foreach ($letterWords as $word) {
                        if (is_string($word) && !empty($word)) {
                            // Apply filters
                            if ($this->matchesFilters($word, $filters)) {
                                $words[] = $this->formatWordResponse($word, $filters['script']);
                            }
                        }
                    }
                }
            }
        } else {
            // serbian-words-lat.json is a simple array
            foreach ($data as $word) {
                if (is_string($word) && !empty($word)) {
                    // Apply filters
                    if ($this->matchesFilters($word, $filters)) {
                        $words[] = $this->formatWordResponse($word, $filters['script']);
                    }
                }
            }
        }
        
        $total = count($words);
        
        // Handle random selection
        if ($filters['random']) {
            shuffle($words);
        }
        
        // Apply pagination
        $offset = ($filters['page'] - 1) * $filters['limit'];
        $paginatedWords = array_slice($words, $offset, $filters['limit']);
        
        return [
            'words' => $paginatedWords,
            'total' => $total
        ];
    }
    
    /**
     * Get a specific word from JSON files
     */
    private function getWordFromJson($searchWord)
    {
        // Try both datasets
        $datasets = [
            'small' => ROOTPATH . 'public/resources/termsSelected.json',
            'large' => ROOTPATH . 'public/resources/serbian-words-lat.json'
        ];
        
        foreach ($datasets as $dataset => $filePath) {
            if (!file_exists($filePath)) {
                continue;
            }
            
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                continue;
            }
            
            if ($dataset === 'small') {
                // termsSelected.json is structured as an object with letters as keys
                foreach ($data as $letter => $letterWords) {
                    if (is_array($letterWords)) {
                        foreach ($letterWords as $word) {
                            if (is_string($word) && !empty($word)) {
                                // Check both Latin and Cyrillic versions
                                $cyrillic = $this->transliteration->toCyrillic($word);
                                
                                if (strcasecmp($word, $searchWord) === 0 || 
                                    strcasecmp($cyrillic, $searchWord) === 0) {
                                    return [
                                        'word' => $word,
                                        'cyrillic' => $cyrillic,
                                        'length' => mb_strlen($word),
                                        'dataset' => $dataset,
                                        'source' => 'json'
                                    ];
                                }
                            }
                        }
                    }
                }
            } else {
                // serbian-words-lat.json is a simple array
                foreach ($data as $word) {
                    if (is_string($word) && !empty($word)) {
                        // Check both Latin and Cyrillic versions
                        $cyrillic = $this->transliteration->toCyrillic($word);
                        
                        if (strcasecmp($word, $searchWord) === 0 || 
                            strcasecmp($cyrillic, $searchWord) === 0) {
                            return [
                                'word' => $word,
                                'cyrillic' => $cyrillic,
                                'length' => mb_strlen($word),
                                'dataset' => $dataset,
                                'source' => 'json'
                            ];
                        }
                    }
                }
            }
        }
        
        return null;
    }
    
    /**
     * Check if word matches the given filters
     */
    private function matchesFilters($word, $filters)
    {
        // Length filters
        $wordLength = mb_strlen($word);
        
        if ($filters['length'] && $wordLength != (int)$filters['length']) {
            return false;
        }
        
        if ($filters['min_length'] && $wordLength < (int)$filters['min_length']) {
            return false;
        }
        
        if ($filters['max_length'] && $wordLength > (int)$filters['max_length']) {
            return false;
        }
        
        // Text filters
        if ($filters['starts_with']) {
            $cyrillic = $this->transliteration->toCyrillic($word);
            $searchTerm = $filters['starts_with'];
            $searchTermCyrillic = $this->transliteration->toCyrillic($searchTerm);
            
            if (strpos(strtolower($word), strtolower($searchTerm)) !== 0 &&
                strpos(strtolower($cyrillic), strtolower($searchTermCyrillic)) !== 0) {
                return false;
            }
        }
        
        if ($filters['contains']) {
            $cyrillic = $this->transliteration->toCyrillic($word);
            $searchTerm = $filters['contains'];
            $searchTermCyrillic = $this->transliteration->toCyrillic($searchTerm);
            
            if (stripos($word, $searchTerm) === false &&
                stripos($cyrillic, $searchTermCyrillic) === false) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Format word response
     */
    private function formatWordResponse($word, $script = 'latin')
    {
        $cyrillic = $this->transliteration->toCyrillic($word);
        
        return [
            'word' => $script === 'cyrillic' ? $cyrillic : $word,
            'latin' => $word,
            'cyrillic' => $cyrillic,
            'length' => mb_strlen($word),
            'source' => 'json'
        ];
    }
}