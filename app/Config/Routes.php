<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');

$routes->get('/login',    'AuthController::login');
$routes->post('/login',   'AuthController::loginPost');
$routes->get('/register', 'AuthController::register');
$routes->post('/register','AuthController::registerPost');
$routes->get('/logout',   'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/dashboard', 'DashboardController::index');

    // Records — CRUD
    $routes->get('/records',                  'RecordController::index');
    $routes->get('/records/new',              'RecordController::create');
    $routes->post('/records/store',           'RecordController::store');
    $routes->get('/records/(:num)',           'RecordController::show/$1');
    $routes->get('/records/edit/(:num)',      'RecordController::edit/$1');
    $routes->post('/records/update/(:num)',   'RecordController::update/$1');
    $routes->get('/records/delete/(:num)',    'RecordController::delete/$1');

    $routes->get('/profile',         'ProfileController::show');
    $routes->get('/profile/edit',    'ProfileController::edit');
    $routes->post('/profile/update', 'ProfileController::update');

});
