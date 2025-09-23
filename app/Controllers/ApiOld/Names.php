<?php

namespace App\Controllers\ApiOld;

use App\Controllers\Api\BaseApiController;
use App\Libraries\Transliteration;

class Names extends BaseApiController
{
    private $transliteration;
    
    public function __construct()
    {
        $this->transliteration = new Transliteration();
    }
    
    /**
     * GET /api-old/names
     * Get paginated list of names with optional filters (JSON file based)
     */
    public function index()
    {
        try {
            $request = service('request');
            [$page, $limit] = $this->validatePagination();
            
            $filters = [
                'gender' => $request->getGet('gender') ?? 'all',
                'starts_with' => $request->getGet('starts_with'),
                'random' => $this->isRandomRequest(),
                'with_vocative' => $request->getGet('with_vocative') === 'true',
                'page' => $page,
                'limit' => $limit
            ];
            
            // Validate gender parameter
            if (!in_array($filters['gender'], ['male', 'female', 'all'])) {
                return $this->errorResponse('Invalid gender. Must be "male", "female", or "all".');
            }
            
            $result = $this->getNamesFromJson($filters);
            
            return $this->paginatedResponse(
                $result['names'],
                $page,
                $limit,
                $result['total']
            );
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving names: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api-old/names/{name}
     * Get details for a specific name (JSON file based)
     */
    public function show($name = null)
    {
        if (empty($name)) {
            return $this->errorResponse('Name parameter is required.');
        }
        
        try {
            $nameData = $this->getNameFromJson($name);
            
            if ($nameData === null) {
                return $this->errorResponse('Name not found.', 404);
            }
            
            return $this->apiResponse($nameData);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving name: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Get names from JSON file
     */
    private function getNamesFromJson($filters)
    {
        $filePath = ROOTPATH . 'public/resources/vocative.json';
        
        if (!file_exists($filePath)) {
            throw new \Exception("Names data file not found: {$filePath}");
        }
        
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding names JSON: ' . json_last_error_msg());
        }
        
        $names = [];
        
        foreach ($data as $item) {
            if (isset($item['name']) && isset($item['vocative']) && isset($item['sex'])) {
                // Convert sex to gender for consistency
                $item['gender'] = $item['sex'];
                
                // Apply filters
                if ($this->matchesNameFilters($item, $filters)) {
                    $names[] = $this->formatNameResponse($item, $filters['with_vocative']);
                }
            }
        }
        
        $total = count($names);
        
        // Handle random selection
        if ($filters['random']) {
            shuffle($names);
        }
        
        // Apply pagination
        $offset = ($filters['page'] - 1) * $filters['limit'];
        $paginatedNames = array_slice($names, $offset, $filters['limit']);
        
        return [
            'names' => $paginatedNames,
            'total' => $total
        ];
    }
    
    /**
     * Get a specific name from JSON file
     */
    private function getNameFromJson($searchName)
    {
        $filePath = ROOTPATH . 'public/resources/vocative.json';
        
        if (!file_exists($filePath)) {
            throw new \Exception("Names data file not found: {$filePath}");
        }
        
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding names JSON: ' . json_last_error_msg());
        }
        
        foreach ($data as $item) {
            if (isset($item['name']) && isset($item['vocative']) && isset($item['sex'])) {
                $cyrillic = $this->transliteration->toCyrillic($item['name']);
                
                // Check both Latin and Cyrillic versions
                if (strcasecmp($item['name'], $searchName) === 0 || 
                    strcasecmp($cyrillic, $searchName) === 0) {
                    return [
                        'name' => $item['name'],
                        'cyrillic' => $cyrillic,
                        'vocative' => $item['vocative'],
                        'vocative_cyrillic' => $this->transliteration->toCyrillic($item['vocative']),
                        'gender' => $item['sex'],
                        'source' => 'json'
                    ];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Check if name matches the given filters
     */
    private function matchesNameFilters($item, $filters)
    {
        // Gender filter
        if ($filters['gender'] !== 'all' && $item['gender'] !== $filters['gender']) {
            return false;
        }
        
        // Starts with filter
        if ($filters['starts_with']) {
            $cyrillic = $this->transliteration->toCyrillic($item['name']);
            $searchTerm = $filters['starts_with'];
            $searchTermCyrillic = $this->transliteration->toCyrillic($searchTerm);
            
            if (strpos(strtolower($item['name']), strtolower($searchTerm)) !== 0 &&
                strpos(strtolower($cyrillic), strtolower($searchTermCyrillic)) !== 0) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Format name response
     */
    private function formatNameResponse($item, $withVocative = false)
    {
        $response = [
            'name' => $item['name'],
            'cyrillic' => $this->transliteration->toCyrillic($item['name']),
            'gender' => $item['gender'],
            'source' => 'json'
        ];
        
        if ($withVocative) {
            $response['vocative'] = $item['vocative'];
            $response['vocative_cyrillic'] = $this->transliteration->toCyrillic($item['vocative']);
        }
        
        return $response;
    }
}