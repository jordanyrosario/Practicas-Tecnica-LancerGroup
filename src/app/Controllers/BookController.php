<?php

namespace App\Controllers;

use App\Entities\Book;
use App\Models\AuthorModel;
use App\Models\BooksModel;
use CodeIgniter\API\ResponseTrait;

class BookController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $title = 'Libros';

        return view('books/index', compact('title'));
    }

    public function getBooks()
    {
        $booksModel = model(BooksModel::class);

        $data        = $this->request->getPost();
        $search      = $data['search']['value'];
        $start       = $data['start'];
        $end         = $data['length'];
        $results     = $booksModel->like('books.name', $search)->orLike('books.edition', $search)->orLike('books.publication_date', $search)->findAll($start, $end);
        $resutlCount = $booksModel->like('books.name', $search)->orLike('books.edition', $search)->orLike('books.publication_date', $search)->countAllResults();
        $recordCount = $booksModel->countAllResults();

        $data = [
            'data'            => $results,
            'draw'            => $data['draw'],
            'token'           => csrf_hash(),
            'recordsTotal'    => $recordCount,
            'recordsFiltered' => $resutlCount,

        ];

        return $this->respond($data, 200);
    }

    public function getBook($id)
    {
        $booksModel = model(BooksModel::class);

        $record = $booksModel->getBookWithDetails($id);
        if (empty($record)) {
            return $this->failNotFound();
        }

        $record->created_at = $record->created_at->humanize();

        return $this->respond(
            [
                'Nombre'               => $record->name,
                'Edition'              => $record->edition,
                'Fecha de publication' => $record->publication_date,
                'autores'              => $record->authors,

            ],
            200
        );
    }

    public function create()
    {
        $authorModel = model(AuthorModel::class);
        helper('form');
        $authors = $authorModel->findAll();

        return view('books/create', compact('authors'));
    }

    public function store()
    {
        $bookModel = model(BooksModel::class);
        $data      = $this->request->getPost();
        $book      = new Book();

        $isValid = $this->validate(
            [
                'name'             => 'required|max_length[50]',
                'edition'          => 'required|max_length[50]',
                'publication_date' => 'required|valid_date[Y-m-d]',
                'authors[]'        => 'required',
            ],
            [
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
                'authors[]'        => [
                    'required' => 'Este campo es obligatorio.',

                ],

            ]
        );

        if (! $isValid) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // this should be done in another way, but I'm running out of time
        $authors = $data['authors'];
        unset($data['authors']);
        $book->fill($data);

        $bookModel->skipValidation(true);
        if ($bookModel->insert($data) === false) {
            throw new \CodeIgniter\Exceptions\ModelException('No se pudo guardar el libro');
        }
        $bookModel->linkAuthors($bookModel->getInsertID(), $authors);

        return $this->response->redirect(route_to('books.index'));
    }

    public function update()
    {
        $bookModel = model(BooksModel::class);
        $data      = $this->request->getPost();

        $book = $bookModel->find($data['id']);

        if (empty($book)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Libro no encontrado');
        }

        $book->fill($data);

        if ($bookModel->insert($book) === false) {
            return redirect()->back()->withInput()->with('errors', $bookModel->errors());
        }

        return $this->response->redirect(route_to('books.index'));
    }

    public function edit($id)
    {
        $bookModel = model(BooksModel::class);
        helper('form');
        $record      = $bookModel->find($id);
        $authorModel = model(AuthorModel::class);
        if (empty($record)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Autor no encontrado');
        }
        $authorsSelected = $bookModel->authorsSelected($id);

        $authors = $authorModel->findAll();

        return view('books/edit', compact('authors', 'record', 'authorsSelected'));
    }

    public function delete($id)
    {
        $bookModel = model(BooksModel::class);

        $record = $bookModel->find($id);
        if (empty($record)) {
            return $this->failNotFound();
        }

        if ($bookModel->delete($record->id) === false) {
            return $this->failServerError();
        }

        return $this->respondDeleted(['token' => csrf_hash()], 'Eliminado correctamente');
    }
}
