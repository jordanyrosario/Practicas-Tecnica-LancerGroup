<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthorCountryRelationship extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->forge->addColumn('authors', [
            'country_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
        ]);

        $this->forge->addForeignKey('country_id', 'countries', 'id');
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->forge->dropForeignKey('authors', 'country_id');
        $this->forge->dropColumn('authors', 'country_id');
    }
}
