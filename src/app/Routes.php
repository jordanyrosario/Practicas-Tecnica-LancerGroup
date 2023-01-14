<?php

$routes->group('/authors', static function ($routes) {
    $routes->get('/', 'AuthorController::index', ['as' => 'authors.index']);
    $routes->get('create', 'AuthorController::create', ['as' => 'authors.create']);
    $routes->get('edit/(:num)', 'AuthorController::edit/$1', ['as' => 'authors.edit']);
    $routes->post('data', 'AuthorController::getAuthors', ['as' => 'authors.ajax']);
    $routes->post('save', 'AuthorController::store', ['as' => 'authors.store']);
    $routes->post('delete/(:num)', 'AuthorController::delete/$1', ['as' => 'authors.destroy']);
    $routes->post('update/', 'AuthorController::update', ['as' => 'authors.update']);
    $routes->get('details/(:num)', 'AuthorController::getAuthor/$1', ['as' => 'authors.details']);
    $routes->get('(:num)', 'AuthorController::show/$1', ['as' => 'authors.show']);
});

$routes->group('/books', static function ($routes) {
    $routes->get('/', 'BookController::index', ['as' => 'books.index']);
    $routes->get('create', 'BookController::create', ['as' => 'books.create']);
    $routes->get('edit/(:num)', 'BookController::edit/$1', ['as' => 'books.edit']);
    $routes->post('data', 'BookController::getBooks', ['as' => 'books.ajax']);
    $routes->post('save', 'BookController::store', ['as' => 'books.store']);
    $routes->post('delete/(:num)', 'BookController::delete/$1', ['as' => 'books.destroy']);
    $routes->post('update/', 'BookController::update', ['as' => 'books.update']);
    $routes->get('details/(:num)', 'BookController::getBook/$1', ['as' => 'books.details']);
});
