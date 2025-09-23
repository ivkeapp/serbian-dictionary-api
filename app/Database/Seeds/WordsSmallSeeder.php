<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Libraries\Transliteration;

class WordsSmallSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data to make seeder idempotent
        $this->db->table('words_small')->truncate();
        
        echo "Seeding small words data...\n";
        
        // Process small dataset (Latin)
        $this->processWordFile('termsSelected.json');
        
        echo "Small words seeding completed!\n";
    }
    
    private function processWordFile(string $filename): void
    {
        $filePath = FCPATH . 'resources/' . $filename;
        
        if (!file_exists($filePath)) {
            echo "File not found: {$filename}\n";
            return;
        }
        
        echo "Processing {$filename} for small dataset...\n";
        
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON in file: {$filename}\n";
            return;
        }
        
        $batchData = [];
        $batchSize = 1000;
        $count = 0;
        
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
                $cyrillic = Transliteration::toCyrillic($word);
                
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
                    echo "Processed {$count} small words...\n";
                }
            }
        }
        
        // Insert remaining data
        if (!empty($batchData)) {
            $this->insertBatch($batchData);
        }
        
        echo "Completed {$filename}: {$count} words processed\n";
    }
    
    private function insertBatch(array $data): void
    {
        try {
            $this->db->table('words_small')->insertBatch($data);
        } catch (\Exception $e) {
            echo "Error inserting batch: " . $e->getMessage() . "\n";
        }
    }
}
