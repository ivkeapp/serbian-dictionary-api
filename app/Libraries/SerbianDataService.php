<?php

namespace App\Libraries;

use App\Libraries\Transliteration;

class SerbianDataService
{
    private static array $cache = [];
    
    /**
     * Load and cache JSON data from file
     */
    private static function loadJsonData(string $filename): array
    {
        if (!isset(self::$cache[$filename])) {
            $filePath = FCPATH . 'resources/' . $filename;
            
            if (!file_exists($filePath)) {
                throw new \Exception("Data file not found: {$filename}");
            }
            
            $content = file_get_contents($filePath);
            self::$cache[$filename] = json_decode($content, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON in file: {$filename}");
            }
        }
        
        return self::$cache[$filename];
    }
    
    /**
     * Get words from selected dataset using database
     */
    public static function getWords(array $filters = []): array
    {
        $dataset = $filters['dataset'] ?? 'small';
        $page = $filters['page'] ?? 1;
        $limit = $filters['limit'] ?? 50;
        $random = $filters['random'] ?? false;
        
        // Use appropriate model based on dataset
        if ($dataset === 'large') {
            $model = new \App\Models\WordLargeModel();
        } else {
            $model = new \App\Models\WordSmallModel();
        }
        
        $builder = $model->builder();
        
        // Apply filters
        if (!empty($filters['starts_with'])) {
            $startsWith = $filters['starts_with'];
            $builder->like('word', $startsWith, 'after');
        }
        
        if (!empty($filters['contains'])) {
            $contains = $filters['contains'];
            $builder->like('word', $contains);
        }
        
        if (!empty($filters['length'])) {
            $length = (int) $filters['length'];
            $builder->where('length', $length);
        }
        
        if (!empty($filters['min_length'])) {
            $minLength = (int) $filters['min_length'];
            $builder->where('length >=', $minLength);
        }
        
        if (!empty($filters['max_length'])) {
            $maxLength = (int) $filters['max_length'];
            $builder->where('length <=', $maxLength);
        }
        
        // Get total count for pagination
        $totalCount = $builder->countAllResults(false);
        
        if ($random) {
            $builder->orderBy('RAND()');
        } else {
            $builder->orderBy('word', 'ASC');
        }
        
        // Apply pagination
        $offset = ($page - 1) * $limit;
        $words = $builder->limit($limit, $offset)->get()->getResultArray();
        
        // Transform to API format
        $result = [];
        foreach ($words as $word) {
            $result[] = self::formatWordResponseFromDB($word);
        }
        
        return [
            'words' => $result,
            'total' => $totalCount
        ];
    }
    
    /**
     * Get single word details from database
     */
    public static function getWord(string $word): ?array
    {
        // Search in both small and large datasets
        $models = [
            new \App\Models\WordSmallModel(),
            new \App\Models\WordLargeModel()
        ];
        
        foreach ($models as $model) {
            $result = $model->where('word', $word)->first();
            if ($result) {
                return self::formatWordResponseFromDB($result);
            }
        }
        
        return null;
    }
    
    /**
     * Get names with filters
     */
    public static function getNames(array $filters = []): array
    {
        $data = self::loadJsonData('vocative.json');
        $names = $data;
        
        // Apply filters
        $names = self::filterNames($names, $filters);
        
        $totalCount = count($names);
        
        if ($filters['random'] ?? false) {
            shuffle($names);
        }
        
        // Apply pagination
        $page = $filters['page'] ?? 1;
        $limit = $filters['limit'] ?? 50;
        $offset = ($page - 1) * $limit;
        $paginatedNames = array_slice($names, $offset, $limit);
        
        // Transform to API format
        $result = [];
        foreach ($paginatedNames as $name) {
            $result[] = self::formatNameResponse($name);
        }
        
        return [
            'names' => $result,
            'total' => $totalCount
        ];
    }
    
    /**
     * Get single name details
     */
    public static function getName(string $name): ?array
    {
        $data = self::loadJsonData('vocative.json');
        
        foreach ($data as $nameData) {
            if (strtolower($nameData['name']) === strtolower($name)) {
                return self::formatNameResponse($nameData);
            }
        }
        
        return null;
    }
    
    /**
     * Get surnames with filters
     */
    public static function getSurnames(array $filters = []): array
    {
        $data = self::loadJsonData('surnames.json');
        $surnames = [];
        
        // Flatten the structure
        foreach ($data as $letter => $letterSurnames) {
            if (is_array($letterSurnames)) {
                $surnames = array_merge($surnames, $letterSurnames);
            }
        }
        
        // Apply filters
        $surnames = self::filterSurnames($surnames, $filters);
        
        $totalCount = count($surnames);
        
        if ($filters['random'] ?? false) {
            shuffle($surnames);
        }
        
        // Apply pagination
        $page = $filters['page'] ?? 1;
        $limit = $filters['limit'] ?? 50;
        $offset = ($page - 1) * $limit;
        $paginatedSurnames = array_slice($surnames, $offset, $limit);
        
        // Transform to API format
        $result = [];
        foreach ($paginatedSurnames as $surname) {
            $result[] = self::formatSurnameResponse($surname);
        }
        
        return [
            'surnames' => $result,
            'total' => $totalCount
        ];
    }
    
    /**
     * Get single surname details
     */
    public static function getSurname(string $surname): ?array
    {
        $data = self::loadJsonData('surnames.json');
        
        foreach ($data as $letter => $letterSurnames) {
            if (is_array($letterSurnames) && in_array($surname, $letterSurnames)) {
                return self::formatSurnameResponse($surname);
            }
        }
        
        return null;
    }
    
    /**
     * Filter words based on criteria
     */
    private static function filterWords(array $words, array $filters): array
    {
        $filtered = $words;
        
        if (!empty($filters['starts_with'])) {
            $startsWith = mb_strtolower($filters['starts_with']);
            $filtered = array_filter($filtered, function($word) use ($startsWith) {
                return mb_strpos(mb_strtolower($word), $startsWith) === 0;
            });
        }
        
        if (!empty($filters['contains'])) {
            $contains = mb_strtolower($filters['contains']);
            $filtered = array_filter($filtered, function($word) use ($contains) {
                return mb_strpos(mb_strtolower($word), $contains) !== false;
            });
        }
        
        if (!empty($filters['length'])) {
            $length = (int) $filters['length'];
            $filtered = array_filter($filtered, function($word) use ($length) {
                return mb_strlen($word) === $length;
            });
        }
        
        if (!empty($filters['min_length'])) {
            $minLength = (int) $filters['min_length'];
            $filtered = array_filter($filtered, function($word) use ($minLength) {
                return mb_strlen($word) >= $minLength;
            });
        }
        
        if (!empty($filters['max_length'])) {
            $maxLength = (int) $filters['max_length'];
            $filtered = array_filter($filtered, function($word) use ($maxLength) {
                return mb_strlen($word) <= $maxLength;
            });
        }
        
        return array_values($filtered);
    }
    
    /**
     * Filter names based on criteria
     */
    private static function filterNames(array $names, array $filters): array
    {
        $filtered = $names;
        
        if (!empty($filters['gender']) && $filters['gender'] !== 'all') {
            $filtered = array_filter($filtered, function($name) use ($filters) {
                return $name['sex'] === $filters['gender'] || $name['sex'] === 'both';
            });
        }
        
        if (!empty($filters['starts_with'])) {
            $startsWith = mb_strtolower($filters['starts_with']);
            $filtered = array_filter($filtered, function($name) use ($startsWith) {
                return mb_strpos(mb_strtolower($name['name']), $startsWith) === 0;
            });
        }
        
        return array_values($filtered);
    }
    
    /**
     * Filter surnames based on criteria
     */
    private static function filterSurnames(array $surnames, array $filters): array
    {
        $filtered = $surnames;
        
        if (!empty($filters['starts_with'])) {
            $startsWith = mb_strtolower($filters['starts_with']);
            $filtered = array_filter($filtered, function($surname) use ($startsWith) {
                return mb_strpos(mb_strtolower($surname), $startsWith) === 0;
            });
        }
        
        return array_values($filtered);
    }
    
    /**
     * Format word response from database
     */
    private static function formatWordResponseFromDB(array $word): array
    {
        return [
            'word' => $word['word'],
            'latin' => $word['word'], // Assuming stored word is in Latin
            'cyrillic' => $word['cyrillic'],
            'length' => $word['length']
        ];
    }
    
    /**
     * Format word response
     */
    private static function formatWordResponse(string $word): array
    {
        $scripts = Transliteration::getBothScripts($word);
        
        return [
            'word' => $word,
            'latin' => $scripts['latin'],
            'cyrillic' => $scripts['cyrillic'],
            'length' => mb_strlen($word)
        ];
    }
    
    /**
     * Format name response
     */
    private static function formatNameResponse(array $nameData): array
    {
        $scripts = Transliteration::getBothScripts($nameData['name']);
        $vocativeScripts = Transliteration::getBothScripts($nameData['vocative']);
        
        $response = [
            'name' => $nameData['name'],
            'gender' => $nameData['sex'],
            'latin' => $scripts['latin'],
            'cyrillic' => $scripts['cyrillic']
        ];
        
        if (!empty($nameData['vocative'])) {
            $response['vocative'] = $nameData['vocative'];
            $response['vocative_latin'] = $vocativeScripts['latin'];
            $response['vocative_cyrillic'] = $vocativeScripts['cyrillic'];
        }
        
        return $response;
    }
    
    /**
     * Format surname response
     */
    private static function formatSurnameResponse(string $surname): array
    {
        $scripts = Transliteration::getBothScripts($surname);
        
        return [
            'surname' => $surname,
            'latin' => $scripts['latin'],
            'cyrillic' => $scripts['cyrillic']
        ];
    }
    
    /**
     * Get random entry from specified type
     */
    public static function getRandomEntry(string $type): ?array
    {
        switch ($type) {
            case 'word':
                // Randomly choose between small and large dataset
                $dataset = rand(0, 1) ? 'small' : 'large';
                $result = self::getWords(['random' => true, 'limit' => 1, 'dataset' => $dataset]);
                return $result['words'][0] ?? null;
                
            case 'name':
                $result = self::getNames(['random' => true, 'limit' => 1]);
                return $result['names'][0] ?? null;
                
            case 'surname':
                $result = self::getSurnames(['random' => true, 'limit' => 1]);
                return $result['surnames'][0] ?? null;
                
            default:
                return null;
        }
    }
}