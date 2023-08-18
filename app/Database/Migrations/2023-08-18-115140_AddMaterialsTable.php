<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMaterialsTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '10'
            ],
            'material_type' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'supplier' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'price_buy' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ]
        ]);

        $this->forge->addKey('code', true);
        $this->forge->addForeignKey('material_type', 'material_types', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('supplier', 'suppliers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materials');
        
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('materials');
    }
}
