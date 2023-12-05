<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePizza extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unisgned'  => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'id_pate' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
            'id_base' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],

            'active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
        ]);

        $this->forge->addForeignKey('id_pate', 'ingredient', 'id');
        $this->forge->addForeignKey('id_base', 'ingredient', 'id');
        $this->forge->addKey('id', true);
        $this->forge->createTable('pizza', true);
    }

    public function down()
    {
        $this->forge->dropTable('pizza', true);
    }
}
