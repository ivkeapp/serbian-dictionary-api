<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Libraries\Transliteration;

class NamesSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data to make seeder idempotent
        $this->db->table('names')->truncate();
        
        echo "Seeding names data...\n";
        
        $filePath = FCPATH . 'resources/vocative.json';
        
        if (!file_exists($filePath)) {
            echo "File not found: vocative.json\n";
            return;
        }
        
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON in vocative.json\n";
            return;
        }
        
        $batchData = [];
        $batchSize = 1000;
        $count = 0;
        
        foreach ($data as $nameData) {
            if (!isset($nameData['name']) || !isset($nameData['sex'])) {
                continue;
            }
            
            // Skip 'both' gender entries or map them to a specific gender
            $gender = $nameData['sex'];
            if ($gender === 'both') {
                // For 'both' gender, we'll create two entries - one for each gender
                $this->addNameToABatch($batchData, $nameData, 'male');
                $this->addNameToABatch($batchData, $nameData, 'female');
                $count += 2;
            } elseif (in_array($gender, ['male', 'female'])) {
                $this->addNameToABatch($batchData, $nameData, $gender);
                $count++;
            }
            
            // Insert in batches for better performance
            if (count($batchData) >= $batchSize) {
                $this->insertBatch($batchData);
                $batchData = [];
                echo "Processed {$count} names...\n";
            }
        }
        
        // Insert remaining data
        if (!empty($batchData)) {
            $this->insertBatch($batchData);
        }
        
        echo "Names seeding completed! Total: {$count} names\n";
    }
    
    private function addNameToABatch(array &$batchData, array $nameData, string $gender): void
    {
        $name = $nameData['name'];
        $cyrillic = Transliteration::toCyrillic($name);
        $vocative = $nameData['vocative'] ?? null;
        
        $batchData[] = [
            'name'     => $name,
            'cyrillic' => $cyrillic,
            'vocative' => $vocative,
            'gender'   => $gender,
        ];
    }
    
    private function insertBatch(array $data): void
    {
        try {
            $this->db->table('names')->insertBatch($data);
        } catch (\Exception $e) {
            echo "Error inserting batch: " . $e->getMessage() . "\n";
        }
    }
}
