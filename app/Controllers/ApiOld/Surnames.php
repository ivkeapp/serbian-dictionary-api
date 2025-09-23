<?php

namespace App\Controllers\ApiOld;

use App\Controllers\Api\BaseApiController;
use App\Libraries\Transliteration;

class Surnames extends BaseApiController
{
    private $transliteration;
    
    public function __construct()
    {
        $this->transliteration = new Transliteration();
    }
    
    /**
     * GET /api-old/surnames
     * Get paginated list of surnames with optional filters (JSON file based)
     */
    public function index()
    {
        try {
            $request = service('request');
            [$page, $limit] = $this->validatePagination();
            
            $filters = [
                'starts_with' => $request->getGet('starts_with'),
                'random' => $this->isRandomRequest(),
                'page' => $page,
                'limit' => $limit
            ];
            
            $result = $this->getSurnamesFromJson($filters);
            
            return $this->paginatedResponse(
                $result['surnames'],
                $page,
                $limit,
                $result['total']
            );
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving surnames: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api-old/surnames/{surname}
     * Get details for a specific surname (JSON file based)
     */
    public function show($surname = null)
    {
        if (empty($surname)) {
            return $this->errorResponse('Surname parameter is required.');
        }
        
        try {
            $surnameData = $this->getSurnameFromJson($surname);
            
            if ($surnameData === null) {
                return $this->errorResponse('Surname not found.', 404);
            }
            
            return $this->apiResponse($surnameData);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving surname: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Get surnames from JSON file
     */
    private function getSurnamesFromJson($filters)
    {
        $filePath = ROOTPATH . 'public/resources/surnames.json';
        
        if (!file_exists($filePath)) {
            throw new \Exception("Surnames data file not found: {$filePath}");
        }
        
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding surnames JSON: ' . json_last_error_msg());
        }
        
        $surnames = [];
        
        foreach ($data as $surname) {
            if (is_string($surname) && !empty($surname)) {
                // Apply filters
                if ($this->matchesSurnameFilters($surname, $filters)) {
                    $surnames[] = $this->formatSurnameResponse($surname);
                }
            }
        }
        
        $total = count($surnames);
        
        // Handle random selection
        if ($filters['random']) {
            shuffle($surnames);
        }
        
        // Apply pagination
        $offset = ($filters['page'] - 1) * $filters['limit'];
        $paginatedSurnames = array_slice($surnames, $offset, $filters['limit']);
        
        return [
            'surnames' => $paginatedSurnames,
            'total' => $total
        ];
    }
    
    /**
     * Get a specific surname from JSON file
     */
    private function getSurnameFromJson($searchSurname)
    {
        $filePath = ROOTPATH . 'public/resources/surnames.json';
        
        if (!file_exists($filePath)) {
            throw new \Exception("Surnames data file not found: {$filePath}");
        }
        
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding surnames JSON: ' . json_last_error_msg());
        }
        
        foreach ($data as $surname) {
            if (is_string($surname) && !empty($surname)) {
                $cyrillic = $this->transliteration->toCyrillic($surname);
                
                // Check both Latin and Cyrillic versions
                if (strcasecmp($surname, $searchSurname) === 0 || 
                    strcasecmp($cyrillic, $searchSurname) === 0) {
                    return [
                        'surname' => $surname,
                        'cyrillic' => $cyrillic,
                        'source' => 'json'
                    ];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Check if surname matches the given filters
     */
    private function matchesSurnameFilters($surname, $filters)
    {
        // Starts with filter
        if ($filters['starts_with']) {
            $cyrillic = $this->transliteration->toCyrillic($surname);
            $searchTerm = $filters['starts_with'];
            $searchTermCyrillic = $this->transliteration->toCyrillic($searchTerm);
            
            if (strpos(strtolower($surname), strtolower($searchTerm)) !== 0 &&
                strpos(strtolower($cyrillic), strtolower($searchTermCyrillic)) !== 0) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Format surname response
     */
    private function formatSurnameResponse($surname)
    {
        return [
            'surname' => $surname,
            'cyrillic' => $this->transliteration->toCyrillic($surname),
            'source' => 'json'
        ];
    }
}