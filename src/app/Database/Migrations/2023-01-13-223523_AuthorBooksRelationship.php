<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthorBooksRelationship extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'author_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'book_id'   => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('books_authors_relationships');

        $this->forge->addForeignKey('book_id', 'books', 'id');
        $this->forge->addForeignKey('author_id', 'authors', 'id');
    }

    public function down()
    {
        $this->forge->dropTable('books_authors_relationships');
    }
}
