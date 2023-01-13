<?php

/**
 * Route definition file
 */
$routes->group('authors', static function ($routes) {
    $routes->get('/', 'AuthorController::index', ['as' => 'authors.index']);
    $routes->get('create', 'AuthorController::create', ['as' => 'authors.create']);
    $routes->post('data', 'AuthorController::getAuthors',  ['as' => 'author.ajax']);
    $routes->post('save', 'AuthorController::store', ['as' => 'author.store']);
    // $routes->get('/', 'Author::delete');
    $routes->get('(:num)', 'AuthorController::show/$1', ['as' => 'authors.show']);
});
