<?php

namespace App\Models;

use CodeIgniter\Model;

class BooksModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'books';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\Book';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'edition', 'publication_date'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [

    ];
    protected $validationMessages = [
        'name'             => [
            'required'   => 'Este campo es obligatorio.',
            'max_length' => 'Numero maximo de caracteres exedido.',
        ],
        'edition'          => [
            'required'   => 'Este campo es obligatorio.',
            'max_length' => 'Numero maximo de caracteres exedido.',
        ],
        'publication_date' => [
            'required'   => 'Este campo es obligatorio.',
            'valid_date' => 'Esta fecha no es valida',
        ],
        'authors'          => [
            'required' => 'Este campo es obligatorio.',

        ],

    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function linkAuthors(int $bookId, array $data): false|int|array
    {
        $builder = $this->builder('books_authors_relationships');

        $builder->where('book_id', $bookId)->delete();
        $authors = [];

        foreach ($data as $author) {
            $authors[] = [
                'book_id'   => $bookId,
                'author_id' => $author,
            ];
        }

        return $builder->insertBatch($authors);
    }

    public function authorsSelected(int $id): array
    {
        $builder = $this->builder('books_authors_relationships');

        $result = $builder->where('book_id', $id)->get()->getResultObject();
        if ($result) {
            $selected = [];

            foreach ($result as $obj) {
                $selected[] = $obj->author_id;
            }

            return $selected;
        }

        return [];
    }

    public function getBookWithDetails(int $id)
    {
        $book = $this->find($id);

        $builder = $this->builder('books_authors_relationships br');

        $result = $builder->where('book_id', $id)->join('authors', 'br.author_id = authors.id')->select('authors.name')->get()->getResultObject();

        $book->authors = array_reduce($result, static function ($carry, $value) {
            if (null === $carry) {
                return $value->name;
            }

            return implode(', ', [$carry, $value->name]);
        });

        return $book;
    }
}
