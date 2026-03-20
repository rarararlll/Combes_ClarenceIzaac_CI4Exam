<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Public routes (no filter) ─────────────────────────────────
$routes->get('/',         'AuthController::login');
$routes->get('/login',    'AuthController::login');
$routes->post('/login',   'AuthController::loginPost');
$routes->get('/register', 'AuthController::register');
$routes->post('/register','AuthController::registerPost');
$routes->get('/logout',   'AuthController::logout');
$routes->get('/unauthorized', 'AuthController::unauthorized');

// ── Student routes ────────────────────────────────────────────
$routes->group('', ['filter' => ['auth', 'student']], function($routes) {
    $routes->get('/student/dashboard', 'StudentController::dashboard');
    $routes->get('/profile',           'ProfileController::show');
    $routes->get('/profile/edit',      'ProfileController::edit');
    $routes->post('/profile/update',   'ProfileController::update');
});

// ── Teacher routes ────────────────────────────────────────────
$routes->group('', ['filter' => ['auth', 'teacher']], function($routes) {
    $routes->get('/dashboard',            'DashboardController::index');
    $routes->get('/students',             'StudentManagementController::index');
    $routes->get('/students/show/(:num)', 'StudentManagementController::show/$1');
    $routes->get('/records',                'RecordController::index');
    $routes->get('/records/new',            'RecordController::create');
    $routes->post('/records/store',         'RecordController::store');
    $routes->get('/records/(:num)',         'RecordController::show/$1');
    $routes->get('/records/edit/(:num)',    'RecordController::edit/$1');
    $routes->post('/records/update/(:num)', 'RecordController::update/$1');
    $routes->get('/records/delete/(:num)',  'RecordController::delete/$1');
});

// ── Admin routes ──────────────────────────────────────────────
$routes->group('admin', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->get('roles',                      'Admin\RoleController::index');
    $routes->get('roles/create',               'Admin\RoleController::create');
    $routes->post('roles/store',               'Admin\RoleController::store');
    $routes->get('roles/edit/(:num)',          'Admin\RoleController::edit/$1');
    $routes->post('roles/update/(:num)',       'Admin\RoleController::update/$1');
    $routes->get('roles/delete/(:num)',        'Admin\RoleController::delete/$1');
    $routes->get('users',                      'Admin\UserAdminController::index');
    $routes->post('users/assign-role/(:num)', 'Admin\UserAdminController::assignRole/$1');
});