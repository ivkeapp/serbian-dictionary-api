<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Libraries\SerbianDataService;

class Names extends BaseApiController
{
    /**
     * GET /api/names
     * Get paginated list of names with optional filters
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
            
            $result = SerbianDataService::getNames($filters);
            
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
     * GET /api/names/{name}
     * Get details for a specific name
     */
    public function show($name = null)
    {
        if (empty($name)) {
            return $this->errorResponse('Name parameter is required.');
        }
        
        try {
            $nameData = SerbianDataService::getName($name);
            
            if ($nameData === null) {
                return $this->errorResponse('Name not found.', 404);
            }
            
            return $this->apiResponse($nameData);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving name: ' . $e->getMessage(), 500);
        }
    }
}