<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Author extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'last_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('authors');
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->forge->dropTable('authors');
    }
}
