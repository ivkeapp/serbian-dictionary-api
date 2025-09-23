<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNamesTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'cyrillic' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'vocative' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['male', 'female'],
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
        $this->forge->addKey('name');
        $this->forge->addKey('gender');
        
        // Create table with UTF8MB4 charset and utf8mb4_0900_ai_ci collation
        $this->forge->createTable('names', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_0900_ai_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('names');
    }
}
