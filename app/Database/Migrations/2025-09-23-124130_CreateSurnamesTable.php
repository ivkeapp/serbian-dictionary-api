<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSurnamesTable extends Migration
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
            'surname' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'cyrillic' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey('surname');
        
        // Create table with UTF8MB4 charset and utf8mb4_0900_ai_ci collation
        $this->forge->createTable('surnames', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_0900_ai_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('surnames');
    }
}
