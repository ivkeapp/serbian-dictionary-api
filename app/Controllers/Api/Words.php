<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Libraries\SerbianDataService;

class Words extends BaseApiController
{
    /**
     * GET /api/words
     * Get paginated list of words with optional filters
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
            
            $result = SerbianDataService::getWords($filters);
            
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
     * GET /api/words/{word}
     * Get details for a specific word
     */
    public function show($word = null)
    {
        if (empty($word)) {
            return $this->errorResponse('Word parameter is required.');
        }
        
        try {
            $wordData = SerbianDataService::getWord($word);
            
            if ($wordData === null) {
                return $this->errorResponse('Word not found.', 404);
            }
            
            return $this->apiResponse($wordData);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving word: ' . $e->getMessage(), 500);
        }
    }
}