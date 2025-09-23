<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Libraries\Transliteration;

class SurnamesSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data to make seeder idempotent
        $this->db->table('surnames')->truncate();
        
        echo "Seeding surnames data...\n";
        
        $filePath = FCPATH . 'resources/surnames.json';
        
        if (!file_exists($filePath)) {
            echo "File not found: surnames.json\n";
            return;
        }
        
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON in surnames.json\n";
            return;
        }
        
        $batchData = [];
        $batchSize = 1000;
        $count = 0;
        
        // Process the structured data (organized by letters)
        foreach ($data as $letter => $surnames) {
            if (!is_array($surnames)) {
                continue;
            }
            
            foreach ($surnames as $surname) {
                if (empty($surname) || !is_string($surname)) {
                    continue;
                }
                
                // Detect if surname is in Cyrillic or Latin
                $isCurrentlyCyrillic = Transliteration::isCyrillic($surname);
                
                if ($isCurrentlyCyrillic) {
                    // If surname is in Cyrillic, convert to Latin
                    $latin = Transliteration::toLatin($surname);
                    $cyrillic = $surname;
                } else {
                    // If surname is in Latin, convert to Cyrillic
                    $latin = $surname;
                    $cyrillic = Transliteration::toCyrillic($surname);
                }
                
                $batchData[] = [
                    'surname'  => $latin, // Store Latin as primary
                    'cyrillic' => $cyrillic,
                ];
                
                $count++;
                
                // Insert in batches for better performance
                if (count($batchData) >= $batchSize) {
                    $this->insertBatch($batchData);
                    $batchData = [];
                    echo "Processed {$count} surnames...\n";
                }
            }
        }
        
        // Insert remaining data
        if (!empty($batchData)) {
            $this->insertBatch($batchData);
        }
        
        echo "Surnames seeding completed! Total: {$count} surnames\n";
    }
    
    private function insertBatch(array $data): void
    {
        try {
            $this->db->table('surnames')->insertBatch($data);
        } catch (\Exception $e) {
            echo "Error inserting batch: " . $e->getMessage() . "\n";
        }
    }
}
