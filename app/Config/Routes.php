<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Energy::index');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');

// User Dashboard & Actions
$routes->get('dashboard', 'Energy::dashboard');
$routes->post('energy/add', 'Energy::add');
$routes->get('energy/toggle/(:num)', 'Energy::toggle/$1');
$routes->get('energy/delete/(:num)', 'Energy::delete/$1');
$routes->get('energy/autocutoff', 'Energy::autoCutOff');

// Admin Route
$routes->get('admin', 'Energy::admin');