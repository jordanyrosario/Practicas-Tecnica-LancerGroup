<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublicationDate extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->forge->addColumn('books', [
            'publication_date' => [
                'type' => 'DATETIME',
            ],
        ]);
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->forge->dropColumn('books', 'publication_date');
    }
}
