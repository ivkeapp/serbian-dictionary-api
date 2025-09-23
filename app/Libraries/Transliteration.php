<?php

namespace App\Libraries;

class Transliteration 
{
    // Latin to Cyrillic mapping
    private static array $latinToCyrillic = [
        'a' => 'а', 'b' => 'б', 'c' => 'ц', 'd' => 'д', 'e' => 'е', 'f' => 'ф',
        'g' => 'г', 'h' => 'х', 'i' => 'и', 'j' => 'ј', 'k' => 'к', 'l' => 'л',
        'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п', 'q' => 'к', 'r' => 'р',
        's' => 'с', 't' => 'т', 'u' => 'у', 'v' => 'в', 'w' => 'в', 'x' => 'кс',
        'y' => 'и', 'z' => 'з',
        // Special characters
        'č' => 'ч', 'ć' => 'ћ', 'đ' => 'ђ', 'š' => 'ш', 'ž' => 'ж',
        // Digraphs
        'dž' => 'џ', 'lj' => 'љ', 'nj' => 'њ',
        // Capital versions
        'A' => 'А', 'B' => 'Б', 'C' => 'Ц', 'D' => 'Д', 'E' => 'Е', 'F' => 'Ф',
        'G' => 'Г', 'H' => 'Х', 'I' => 'И', 'J' => 'Ј', 'K' => 'К', 'L' => 'Л',
        'M' => 'М', 'N' => 'Н', 'O' => 'О', 'P' => 'П', 'Q' => 'К', 'R' => 'Р',
        'S' => 'С', 'T' => 'Т', 'U' => 'У', 'V' => 'В', 'W' => 'В', 'X' => 'КС',
        'Y' => 'И', 'Z' => 'З',
        'Č' => 'Ч', 'Ć' => 'Ћ', 'Đ' => 'Ђ', 'Š' => 'Ш', 'Ž' => 'Ж',
        'Dž' => 'Џ', 'Lj' => 'Љ', 'Nj' => 'Њ', 'DŽ' => 'Џ', 'LJ' => 'Љ', 'NJ' => 'Њ'
    ];

    // Cyrillic to Latin mapping (reverse of above)
    private static array $cyrillicToLatin = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'ђ' => 'đ',
        'е' => 'e', 'ж' => 'ž', 'з' => 'z', 'и' => 'i', 'ј' => 'j', 'к' => 'k',
        'л' => 'l', 'љ' => 'lj', 'м' => 'm', 'н' => 'n', 'њ' => 'nj', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'ћ' => 'ć', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'č', 'џ' => 'dž', 'ш' => 'š',
        // Capital versions
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Ђ' => 'Đ',
        'Е' => 'E', 'Ж' => 'Ž', 'З' => 'Z', 'И' => 'I', 'Ј' => 'J', 'К' => 'K',
        'Л' => 'L', 'Љ' => 'Lj', 'М' => 'M', 'Н' => 'N', 'Њ' => 'Nj', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'Ћ' => 'Ć', 'У' => 'U',
        'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Č', 'Џ' => 'Dž', 'Ш' => 'Š'
    ];

    /**
     * Convert Latin text to Cyrillic
     */
    public static function toCyrillic(string $text): string
    {
        // Handle digraphs first (longer strings first)
        $text = str_ireplace(['dž', 'lj', 'nj', 'DŽ', 'LJ', 'NJ', 'Dž', 'Lj', 'Nj'], 
                           ['џ', 'љ', 'њ', 'Џ', 'Љ', 'Њ', 'Џ', 'Љ', 'Њ'], $text);
        
        // Then handle single characters
        return strtr($text, self::$latinToCyrillic);
    }

    /**
     * Convert Cyrillic text to Latin
     */
    public static function toLatin(string $text): string
    {
        return strtr($text, self::$cyrillicToLatin);
    }

    /**
     * Auto-detect script and convert to the other script
     */
    public static function transliterate(string $text, string $to = null): string
    {
        if ($to === 'cyrillic') {
            return self::toCyrillic($text);
        } elseif ($to === 'latin') {
            return self::toLatin($text);
        }

        // Auto-detect script and convert to the opposite
        if (self::isCyrillic($text)) {
            return self::toLatin($text);
        } else {
            return self::toCyrillic($text);
        }
    }

    /**
     * Check if text contains Cyrillic characters
     */
    public static function isCyrillic(string $text): bool
    {
        return preg_match('/[\x{0400}-\x{04FF}]/u', $text) > 0;
    }

    /**
     * Check if text contains Latin characters (Serbian specific)
     */
    public static function isLatin(string $text): bool
    {
        return preg_match('/[a-zA-ZčćđšžČĆĐŠŽ]/u', $text) > 0;
    }

    /**
     * Get both scripts for a given text
     */
    public static function getBothScripts(string $text): array
    {
        if (self::isCyrillic($text)) {
            return [
                'cyrillic' => $text,
                'latin' => self::toLatin($text)
            ];
        } else {
            return [
                'latin' => $text,
                'cyrillic' => self::toCyrillic($text)
            ];
        }
    }
}