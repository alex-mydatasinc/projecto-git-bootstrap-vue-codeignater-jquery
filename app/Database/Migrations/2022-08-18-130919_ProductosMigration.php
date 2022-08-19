<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductosMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'producto_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'price' => [
                'type' => 'INT',
                'constraint'     => 5,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'start_time' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'stop_time' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'condition' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'permalink' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pictures' => [
                'type' => 'JSON'
            ],
            // 'descriptions' => [
            //     'type' => 'TEXT',
            //     'null' => true,
            // ],
            'thumbnail' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'marca' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('productos');
    }

    public function down()
    {
        $this->forge->dropTable('productos');
    }
}
