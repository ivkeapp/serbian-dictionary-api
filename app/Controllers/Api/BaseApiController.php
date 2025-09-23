<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class BaseApiController extends ResourceController
{
    protected $format = 'json';
    
    /**
     * Return a paginated response
     */
    protected function paginatedResponse(array $data, int $page, int $limit, int $totalItems): ResponseInterface
    {
        $totalPages = ceil($totalItems / $limit);
        
        return $this->respond([
            'data' => $data,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total_items' => $totalItems,
                'total_pages' => $totalPages,
                'has_next_page' => $page < $totalPages,
                'has_prev_page' => $page > 1
            ]
        ]);
    }
    
    /**
     * Return a standard API response
     */
    protected function apiResponse($data, string $message = '', int $statusCode = 200): ResponseInterface
    {
        $response = [
            'success' => $statusCode >= 200 && $statusCode < 300,
            'data' => $data
        ];
        
        if (!empty($message)) {
            $response['message'] = $message;
        }
        
        return $this->respond($response, $statusCode);
    }
    
    /**
     * Return an error response
     */
    protected function errorResponse(string $message, int $statusCode = 400): ResponseInterface
    {
        return $this->respond([
            'success' => false,
            'error' => $message
        ], $statusCode);
    }
    
    /**
     * Validate pagination parameters
     */
    protected function validatePagination(): array
    {
        $request = service('request');
        $page = max(1, (int) ($request->getGet('page') ?? 1));
        $limit = max(1, min(100, (int) ($request->getGet('limit') ?? 50)));
        
        return [$page, $limit];
    }
    
    /**
     * Get random flag from request
     */
    protected function isRandomRequest(): bool
    {
        $request = service('request');
        $random = $request->getGet('random');
        return $random === 'true' || $random === '1';
    }
}