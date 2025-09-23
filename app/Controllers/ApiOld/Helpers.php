<?php

namespace App\Controllers\ApiOld;

use App\Controllers\Api\BaseApiController;
use App\Libraries\Transliteration;

class Helpers extends BaseApiController
{
    /**
     * GET /api-old/transliterate
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
            
            $transliteration = new Transliteration();
            
            $result = [
                'original' => $text,
                'transliterated' => $transliteration->transliterate($text, $to),
                'original_script' => $transliteration->isCyrillic($text) ? 'cyrillic' : 'latin',
                'source' => 'json'
            ];
            
            // Add both scripts
            $result['latin'] = $transliteration->toLatin($text);
            $result['cyrillic'] = $transliteration->toCyrillic($text);
            
            return $this->apiResponse($result);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error in transliteration: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api-old/random
     * Get a random entry from the specified dataset type (JSON file based)
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
            
            $randomEntry = $this->getRandomEntryFromJson($type);
            
            if ($randomEntry === null) {
                return $this->errorResponse('No random entry found for the specified type.', 404);
            }
            
            return $this->apiResponse($randomEntry);
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving random entry: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Get a random entry from JSON files
     */
    private function getRandomEntryFromJson($type)
    {
        $transliteration = new Transliteration();
        
        switch ($type) {
            case 'word':
                // Randomly choose between small and large dataset
                $useSmall = rand(0, 1);
                $filePath = $useSmall 
                    ? ROOTPATH . 'public/resources/termsSelected.json'
                    : ROOTPATH . 'public/resources/serbian-words-lat.json';
                
                if (!file_exists($filePath)) {
                    // Fallback to the other dataset
                    $filePath = $useSmall 
                        ? ROOTPATH . 'public/resources/serbian-words-lat.json'
                        : ROOTPATH . 'public/resources/termsSelected.json';
                }
                
                if (!file_exists($filePath)) {
                    return null;
                }
                
                $data = json_decode(file_get_contents($filePath), true);
                if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                    return null;
                }
                
                $randomWord = null;
                if ($useSmall && strpos($filePath, 'termsSelected.json') !== false) {
                    // termsSelected.json has nested structure
                    $allWords = [];
                    foreach ($data as $letter => $letterWords) {
                        if (is_array($letterWords)) {
                            $allWords = array_merge($allWords, $letterWords);
                        }
                    }
                    if (!empty($allWords)) {
                        $randomWord = $allWords[array_rand($allWords)];
                    }
                } else {
                    // serbian-words-lat.json is a simple array
                    $randomWord = $data[array_rand($data)];
                }
                
                if (!$randomWord) {
                    return null;
                }
                
                return [
                    'type' => 'word',
                    'word' => $randomWord,
                    'cyrillic' => $transliteration->toCyrillic($randomWord),
                    'length' => mb_strlen($randomWord),
                    'dataset' => $useSmall ? 'small' : 'large',
                    'source' => 'json'
                ];
                
            case 'name':
                $filePath = ROOTPATH . 'public/resources/vocative.json';
                if (!file_exists($filePath)) {
                    return null;
                }
                
                $data = json_decode(file_get_contents($filePath), true);
                if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                    return null;
                }
                
                $randomName = $data[array_rand($data)];
                return [
                    'type' => 'name',
                    'name' => $randomName['name'],
                    'cyrillic' => $transliteration->toCyrillic($randomName['name']),
                    'vocative' => $randomName['vocative'],
                    'vocative_cyrillic' => $transliteration->toCyrillic($randomName['vocative']),
                    'gender' => $randomName['sex'],
                    'source' => 'json'
                ];
                
            case 'surname':
                $filePath = ROOTPATH . 'public/resources/surnames.json';
                if (!file_exists($filePath)) {
                    return null;
                }
                
                $data = json_decode(file_get_contents($filePath), true);
                if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                    return null;
                }
                
                $randomSurname = $data[array_rand($data)];
                return [
                    'type' => 'surname',
                    'surname' => $randomSurname,
                    'cyrillic' => $transliteration->toCyrillic($randomSurname),
                    'source' => 'json'
                ];
                
            default:
                return null;
        }
    }
}