<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePriceHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'lot_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'old_price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0.00,
            ],
            'new_price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0.00,
            ],
            'months_elapsed' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0,
            ],
            'applied_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('lot_id');
        $this->forge->createTable('price_history', true);
    }

    public function down()
    {
        $this->forge->dropTable('price_history', true);
    }
}
