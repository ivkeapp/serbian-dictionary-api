<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WordsSeeder extends Seeder
{
    public function run()
    {
        echo "Starting words seeding process...\n";
        
        // Run small words seeder
        echo "Running small words seeder...\n";
        $this->call('WordsSmallSeeder');
        
        // Run large words seeder
        echo "Running large words seeder...\n";
        $this->call('WordsLargeSeeder');
        
        echo "All words seeding completed!\n";
    }
}
