<?php

/**
 * Route definition file
 */
$routes->group('authors', static function ($routes) {
    $routes->get('/', 'AuthorController::index', ['as' => 'authors.index']);
    $routes->get('create', 'AuthorController::create', ['as' => 'authors.create']);
    $routes->get('edit/(:num)', 'AuthorController::edit/$1', ['as' => 'authors.edit']);
    $routes->post('data', 'AuthorController::getAuthors',  ['as' => 'authors.ajax']);
    $routes->post('save', 'AuthorController::store', ['as' => 'authors.store']);
    $routes->post('delete/(:num)', 'AuthorController::delete/$1', ['as' => 'authors.destroy']);
    $routes->post('update/', 'AuthorController::update', ['as' => 'authors.update']);
    $routes->get('details/(:num)', 'AuthorController::getAuthor/$1', ['as' => 'authors.details']);

    $routes->get('(:num)', 'AuthorController::show/$1', ['as' => 'authors.show']);
});
