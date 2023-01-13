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
            'recordsTotal' => $authorsModel->pager->getTotal(),
            'recordsFiltered'=> $authorsModel->pager->getTotal()

        ];

        return $this->respond($data, 200);
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
}
