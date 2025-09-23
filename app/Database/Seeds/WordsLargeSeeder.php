<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Libraries\Transliteration;

class WordsLargeSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data to make seeder idempotent
        $this->db->table('words_large')->truncate();
        
        echo "Seeding large words data...\n";
        
        // Process large dataset (Latin) - only if file exists and is readable
        $largeFilePath = FCPATH . 'resources/serbian-words-lat.json';
        if (file_exists($largeFilePath)) {
            $fileSize = filesize($largeFilePath);
            echo "Large file size: " . round($fileSize / (1024 * 1024), 2) . " MB\n";
            
            // Increase memory limit for large files
            ini_set('memory_limit', '512M');
            
            if ($fileSize < 100 * 1024 * 1024) { // Less than 100MB
                $this->processWordFile('serbian-words-lat.json');
            } else {
                echo "File too large, using streaming approach...\n";
                $this->processLargeFile($largeFilePath);
            }
        } else {
            echo "Large dataset file not found: serbian-words-lat.json\n";
        }
        
        echo "Large words seeding completed!\n";
    }
    
    private function processWordFile(string $filename): void
    {
        $filePath = FCPATH . 'resources/' . $filename;
        
        if (!file_exists($filePath)) {
            echo "File not found: {$filename}\n";
            return;
        }
        
        echo "Processing {$filename} for large dataset...\n";
        
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON in file: {$filename}\n";
            return;
        }
        
        $transliteration = new Transliteration();
        $batchData = [];
        $batchSize = 1000;
        $count = 0;
        
        // Check if it's a simple array or structured data
        if (array_keys($data) === range(0, count($data) - 1)) {
            // It's a simple array of words
            foreach ($data as $word) {
                if (empty($word) || !is_string($word)) {
                    continue;
                }
                
                // Generate Cyrillic version using transliteration
                $cyrillic = $transliteration->toCyrillic($word);
                
                $batchData[] = [
                    'word'     => $word,
                    'cyrillic' => $cyrillic,
                    'length'   => mb_strlen($word),
                ];
                
                $count++;
                
                // Insert in batches for better performance
                if (count($batchData) >= $batchSize) {
                    $this->insertBatch($batchData);
                    $batchData = [];
                    echo "Processed {$count} large words...\n";
                }
            }
        } else {
            // Process the structured data (organized by letters)
            foreach ($data as $letter => $words) {
                if (!is_array($words)) {
                    continue;
                }
                
                foreach ($words as $word) {
                    if (empty($word) || !is_string($word)) {
                        continue;
                    }
                    
                    // Generate Cyrillic version using transliteration
                    $cyrillic = $transliteration->toCyrillic($word);
                    
                    $batchData[] = [
                        'word'     => $word,
                        'cyrillic' => $cyrillic,
                        'length'   => mb_strlen($word),
                    ];
                    
                    $count++;
                    
                    // Insert in batches for better performance
                    if (count($batchData) >= $batchSize) {
                        $this->insertBatch($batchData);
                        $batchData = [];
                        echo "Processed {$count} large words...\n";
                    }
                }
            }
        }
        
        // Insert remaining data
        if (!empty($batchData)) {
            $this->insertBatch($batchData);
        }
        
        echo "Completed {$filename}: {$count} words processed\n";
    }
    
    private function processLargeFile(string $filePath): void
    {
        echo "Processing very large file using streaming approach...\n";
        
        $transliteration = new Transliteration();
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            echo "Cannot open file for reading\n";
            return;
        }
        
        $buffer = '';
        $batchData = [];
        $batchSize = 1000;
        $count = 0;
        $inArray = false;
        
        while (($line = fgets($handle)) !== false) {
            $buffer .= $line;
            
            // Look for start of array
            if (!$inArray && strpos($buffer, '[') !== false) {
                $inArray = true;
                $buffer = substr($buffer, strpos($buffer, '[') + 1);
            }
            
            if ($inArray) {
                // Process complete JSON strings
                while (($pos = strpos($buffer, '"')) !== false) {
                    $endPos = strpos($buffer, '"', $pos + 1);
                    if ($endPos === false) break;
                    
                    $word = substr($buffer, $pos + 1, $endPos - $pos - 1);
                    $buffer = substr($buffer, $endPos + 1);
                    
                    if (!empty($word) && strlen($word) > 1) {
                        $cyrillic = $transliteration->toCyrillic($word);
                        
                        $batchData[] = [
                            'word' => $word,
                            'cyrillic' => $cyrillic,
                            'length' => mb_strlen($word),
                        ];
                        
                        $count++;
                        
                        if (count($batchData) >= $batchSize) {
                            $this->insertBatch($batchData);
                            $batchData = [];
                            echo "Processed {$count} large words...\n";
                        }
                    }
                }
            }
            
            // Keep only last part of buffer for next iteration
            if (strlen($buffer) > 1000) {
                $buffer = substr($buffer, -500);
            }
        }
        
        // Insert remaining batch
        if (!empty($batchData)) {
            $this->insertBatch($batchData);
        }
        
        fclose($handle);
        echo "Completed streaming: {$count} words processed\n";
    }
    
    private function insertBatch(array $data): void
    {
        try {
            $this->db->table('words_large')->insertBatch($data);
        } catch (\Exception $e) {
            echo "Error inserting batch: " . $e->getMessage() . "\n";
        }
    }
}
