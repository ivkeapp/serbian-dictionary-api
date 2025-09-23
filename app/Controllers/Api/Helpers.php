<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Libraries\Transliteration;
use App\Libraries\SerbianDataService;

class Helpers extends BaseApiController
{
    /**
     * GET /api/transliterate
     * Convert text between Latin and Cyrillic scripts
     */
    public function transliterate()
    {
        try {
            $request = service('request');
            $text = $request->getGet('text');
            $to = $request->getGet('to');
            
            if (empty($text)) {
                return $this->errorResponse('Text parameter is required.');
            }
            
            // Validate 'to' parameter if provided
            if (!empty($to) && !in_array($to, ['latin', 'cyrillic'])) {
                return $this->errorResponse('Invalid "to" parameter. Must be "latin" or "cyrillic".');
            }
            
            $result = [
                'original' => $text,
                'transliterated' => Transliteration::transliterate($text, $to),
                'original_script' => Transliteration::isCyrillic($text) ? 'cyrillic' : 'latin'
            ];
            
            // Add both scripts
            $bothScripts = Transliteration::getBothScripts($text);
            $result['latin'] = $bothScripts['latin'];
            $result['cyrillic'] = $bothScripts['cyrillic'];
            
            return $this->apiResponse($result);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error in transliteration: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api/random
     * Get a random entry from the specified dataset type
     */
    public function random()
    {
        try {
            $request = service('request');
            $type = $request->getGet('type');
            
            if (empty($type)) {
                return $this->errorResponse('Type parameter is required.');
            }
            
            if (!in_array($type, ['word', 'name', 'surname'])) {
                return $this->errorResponse('Invalid type. Must be "word", "name", or "surname".');
            }
            
            $randomEntry = SerbianDataService::getRandomEntry($type);
            
            if ($randomEntry === null) {
                return $this->errorResponse('No random entry found for the specified type.', 404);
            }
            
            return $this->apiResponse($randomEntry);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving random entry: ' . $e->getMessage(), 500);
        }
    }
}