<?php

namespace App\Models;

use CodeIgniter\Entity;
use CodeIgniter\Model;

class AuthorModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'authors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\Author';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'last_name', 'country_id', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'       => 'required|max_length[50]',
        'last_name'  => 'required|max_length[50]',
        'country_id' => 'required|numeric',

    ];
    protected $validationMessages = [
        'name'       => [
            'required'   => 'Este campo es obligatorio.',
            'max_length' => 'Numero maximo de caracteres exedido.',
        ],
        'last_name'  => [
            'required'   => 'Este campo es obligatorio.',
            'max_length' => 'Numero maximo de caracteres exedido.',
        ],
        'country_id' => [
            'required' => 'Este campo es obligatorio.',
            'numeric'  => 'Este campo debe ser un valor numerico.',

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

    public function findAll(int $limit = 0, int $offset = 0)
    {
        return $this->select('authors.id, authors.name, authors.last_name, c.name as country')->join('countries c', 'authors.country_id = c.id', 'left')->limit($limit, $offset)->get()->getResult();
    }

    /**
     * @return array|null|Entity
     */
    public function getAuhtorWithDetails(int $id)
    {
        $author        = $this->select('authors.*, c.name as country')->join('countries c', 'authors.country_id = c.id', 'left')->where('authors.id', $id)->first();
        $builder       = $this->builder('books_authors_relationships br');
        $books         = $builder->where('author_id', $id)->countAllResults();
        $author->books = $books;

        return $author;
    }
}
