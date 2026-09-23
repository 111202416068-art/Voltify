<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Energy::index');

// Auth
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('seed-demo', 'Auth::seed');

// User Dashboard & Profil
$routes->get('dashboard', 'Energy::dashboard');
$routes->get('profile', 'Energy::profile');
$routes->post('profile/update', 'Energy::updateProfile');
$routes->post('profile/delete-account', 'Energy::deleteAccount');

// Aksi Perangkat
$routes->post('energy/add', 'Energy::add');
$routes->get('energy/toggle/(:num)', 'Energy::toggle/$1');
$routes->get('energy/delete/(:num)', 'Energy::delete/$1');
$routes->get('energy/autocutoff', 'Energy::autoCutOff');

// Admin Portal & Aksi
$routes->get('admin', 'Energy::admin');
$routes->get('admin/toggle-role/(:num)', 'Energy::adminToggleRole/$1');
$routes->get('admin/delete-user/(:num)', 'Energy::adminDeleteUser/$1');