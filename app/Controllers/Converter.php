<?php

namespace App\Controllers;

use App\Libraries\Transliteration;

class Converter extends BaseController
{
    public function __construct()
    {
        helper('transliterator');
    }

    /**
     * Display the converter page
     */
    public function index(): string
    {
        $data = [
            'title' => 'Serbian Text Converter',
            'description' => 'Convert Serbian text between Latin and Cyrillic scripts'
        ];

        return view('converter', $data);
    }

    /**
     * AJAX endpoint for transliteration
     */
    public function translate()
    {
        // Set JSON response header
        $this->response->setContentType('application/json');

        try {
            // Get POST data
            $input = $this->request->getJSON(true);
            $text = $input['text'] ?? '';
            $direction = $input['direction'] ?? 'auto';

            // Validate input
            if (empty($text)) {
                return $this->response->setJSON([
                    'success' => false,
                    'error' => 'Text is required'
                ]);
            }

            // Perform transliteration based on direction
            $result = '';
            switch ($direction) {
                case 'latin-to-cyrillic':
                    $result = Transliteration::toCyrillic($text);
                    break;
                case 'cyrillic-to-latin':
                    $result = Transliteration::toLatin($text);
                    break;
                case 'auto':
                default:
                    $result = Transliteration::transliterate($text);
                    break;
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'original' => $text,
                    'transliterated' => $result,
                    'direction' => $direction,
                    'detected_script' => Transliteration::isCyrillic($text) ? 'cyrillic' : 'latin'
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Transliteration failed: ' . $e->getMessage()
            ]);
        }
    }
}