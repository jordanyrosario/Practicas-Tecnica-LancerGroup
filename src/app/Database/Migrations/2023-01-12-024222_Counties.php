<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Counties extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],

        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('countries');
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->forge->dropTable('countries');
    }
}
