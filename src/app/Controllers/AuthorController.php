<?php

namespace App\Controllers;

use App\Entities\Author;
use App\Models\AuthorModel;
use App\Models\CountryModel;
use CodeIgniter\API\ResponseTrait;

class AuthorController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
       
        return view('authors/index');
    }

    public function getAuthors()
    {

        $authorsModel = model(AuthorModel::class);

        $data = [
            'data' => $authorsModel->paginate(10),  
            'draw' => 1,
            'token' =>  csrf_hash(),
            'recordsTotal' => $authorsModel->pager->getTotal(),
            'recordsFiltered'=> $authorsModel->pager->getTotal()

        ];

        return $this->respond($data, 200);
    }
    public function getAuthor($id)
    {
        $authorsModel = model(AuthorModel::class);

        $record = $authorsModel->getAuhtorWithDetails($id);
        if(empty($record))
            return $this->failNotFound();

            $record->created_at = $record->created_at->humanize();

        return $this->respond(
                [
                    'Nombre' => $record->name,
                    'Apellidos' => $record->last_name,
                    'Pais' => $record->country,
                    'Fecha de registro' => $record->created_at?  $record->created_at->humanize(): "",


                ]

            , 200);
    }

    public function create()
    {
        $countryModel = model(CountryModel::class);

        $countries = $countryModel->findAll();

        return view('authors/create', compact('countries'));
    }

    public function store()
    {
        $authorsModel = model(AuthorModel::class);
        $data         = $this->request->getPost();
        $author       = new Author();
        $author->fill($data);
        if ($authorsModel->save($author) === false) {
            return redirect()->back()->withInput()->with('errors', $authorsModel->errors());
        }

        return $this->response->redirect(route_to('authors.index'));
    }
    public function update()
    {
        $authorsModel = model(AuthorModel::class);
        $data         = $this->request->getPost();
        $author       = new Author();

        $author = $authorsModel->find($data['id']);

        if (empty($author)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Autor no encontrado');
        }

        $author->fill($data);

        if ($authorsModel->save($author) === false) {
            return redirect()->back()->withInput()->with('errors', $authorsModel->errors());
        }

        return $this->response->redirect(route_to('authors.index'));
    }
    public function edit($id)
    {
        $authorsModel = model(AuthorModel::class);
       
        $record = $authorsModel->find($id);
        $countryModel = model(CountryModel::class);
        if (empty($record)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Autor no encontrado');
        }

        $countries = $countryModel->findAll();

        return view('authors/edit', compact('countries', 'record'));
    }


    public function delete($id)
    {
        $authorsModel = model(AuthorModel::class);

        $record = $authorsModel->find($id);
        if(empty($record))
            return $this->failNotFound();

          if ($authorsModel->delete($record->id) == false)
           return $this->failServerError();

        return $this->respondDeleted([ 'token' => csrf_hash(),], 'Eliminado correctamente');

    }
}
