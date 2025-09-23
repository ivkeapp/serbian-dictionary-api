<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Libraries\SerbianDataService;

class Surnames extends BaseApiController
{
    /**
     * GET /api/surnames
     * Get paginated list of surnames with optional filters
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
            
            $result = SerbianDataService::getSurnames($filters);
            
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
     * GET /api/surnames/{surname}
     * Get details for a specific surname
     */
    public function show($surname = null)
    {
        if (empty($surname)) {
            return $this->errorResponse('Surname parameter is required.');
        }
        
        try {
            $surnameData = SerbianDataService::getSurname($surname);
            
            if ($surnameData === null) {
                return $this->errorResponse('Surname not found.', 404);
            }
            
            return $this->apiResponse($surnameData);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving surname: ' . $e->getMessage(), 500);
        }
    }
}