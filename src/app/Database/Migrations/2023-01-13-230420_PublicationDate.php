<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublicationDate extends Migration
{
    public function up()
    {
        $this->forge->addColumn('books', [
            'publication_date' => [
                'type' => 'DATETIME',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('books', 'publication_date');
    }
}
