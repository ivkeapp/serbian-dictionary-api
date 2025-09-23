<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWordsLargeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'word' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'cyrillic' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'length' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'      => 'DATETIME',
                'null'      => false,
                'default'   => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
                'on update' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('word');
        $this->forge->addKey('length');
        
        // Create table with UTF8MB4 charset and utf8mb4_0900_ai_ci collation
        $this->forge->createTable('words_large', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_0900_ai_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('words_large');
    }
}
