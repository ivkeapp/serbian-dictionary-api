<?php

/**
 * Transliterator Helper Functions
 * 
 * Provides helper functions for Serbian Latin ↔ Cyrillic transliteration
 */

if (!function_exists('transliterate_text')) {
    /**
     * Transliterate text between Latin and Cyrillic scripts
     * 
     * @param string $text Text to transliterate
     * @param string|null $to Target script ('latin', 'cyrillic', or null for auto-detect)
     * @return string Transliterated text
     */
    function transliterate_text(string $text, ?string $to = null): string
    {
        return \App\Libraries\Transliteration::transliterate($text, $to);
    }
}

if (!function_exists('to_cyrillic')) {
    /**
     * Convert Latin text to Cyrillic
     * 
     * @param string $text Latin text
     * @return string Cyrillic text
     */
    function to_cyrillic(string $text): string
    {
        return \App\Libraries\Transliteration::toCyrillic($text);
    }
}

if (!function_exists('to_latin')) {
    /**
     * Convert Cyrillic text to Latin
     * 
     * @param string $text Cyrillic text
     * @return string Latin text
     */
    function to_latin(string $text): string
    {
        return \App\Libraries\Transliteration::toLatin($text);
    }
}

if (!function_exists('is_cyrillic')) {
    /**
     * Check if text contains Cyrillic characters
     * 
     * @param string $text Text to check
     * @return bool True if text contains Cyrillic characters
     */
    function is_cyrillic(string $text): bool
    {
        return \App\Libraries\Transliteration::isCyrillic($text);
    }
}

if (!function_exists('is_latin')) {
    /**
     * Check if text contains Latin characters (Serbian specific)
     * 
     * @param string $text Text to check
     * @return bool True if text contains Serbian Latin characters
     */
    function is_latin(string $text): bool
    {
        return \App\Libraries\Transliteration::isLatin($text);
    }
}

if (!function_exists('get_both_scripts')) {
    /**
     * Get both Latin and Cyrillic versions of text
     * 
     * @param string $text Input text
     * @return array Array with 'latin' and 'cyrillic' keys
     */
    function get_both_scripts(string $text): array
    {
        return \App\Libraries\Transliteration::getBothScripts($text);
    }
}

if (!function_exists('detect_script')) {
    /**
     * Detect the script of the input text
     * 
     * @param string $text Text to analyze
     * @return string 'cyrillic', 'latin', or 'mixed'
     */
    function detect_script(string $text): string
    {
        $hasCyrillic = is_cyrillic($text);
        $hasLatin = is_latin($text);
        
        if ($hasCyrillic && $hasLatin) {
            return 'mixed';
        } elseif ($hasCyrillic) {
            return 'cyrillic';
        } elseif ($hasLatin) {
            return 'latin';
        }
        
        return 'unknown';
    }
}

if (!function_exists('clean_transliteration')) {
    /**
     * Clean and normalize text for better transliteration
     * 
     * @param string $text Input text
     * @return string Cleaned text
     */
    function clean_transliteration(string $text): string
    {
        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        
        // Trim
        $text = trim($text);
        
        return $text;
    }
}

if (!function_exists('transliterate_preserve_case')) {
    /**
     * Transliterate text while preserving original case patterns
     * 
     * @param string $text Input text
     * @param string|null $to Target script
     * @return string Transliterated text with preserved case
     */
    function transliterate_preserve_case(string $text, ?string $to = null): string
    {
        // This is handled by the main Transliteration class
        return transliterate_text($text, $to);
    }
}

if (!function_exists('batch_transliterate')) {
    /**
     * Transliterate an array of texts
     * 
     * @param array $texts Array of texts to transliterate
     * @param string|null $to Target script
     * @return array Array of transliterated texts
     */
    function batch_transliterate(array $texts, ?string $to = null): array
    {
        return array_map(function($text) use ($to) {
            return transliterate_text($text, $to);
        }, $texts);
    }
}