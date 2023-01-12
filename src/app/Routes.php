<?php

/**
 * Route definition file
 */
$routes->group('authors', static function ($routes) {
    $routes->get('/', 'Author::index');
    $routes->get('/', 'Author::create');
    $routes->put('/', 'Author::edit');
    $routes->post('/', 'Author::save');
    $routes->get('/', 'Author::delete');
    $routes->get('(:num)', 'Author::show/$1', ['as' => 'show_author']);
});
