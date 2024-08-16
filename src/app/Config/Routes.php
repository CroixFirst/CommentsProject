<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Comments::index');
$routes->post('/comments/add', 'Comments::add');
$routes->post('/comments/delete/(:num)', 'Comments::delete/$1');
$routes->get('/comments/sort/(:segment)/(:segment)', 'Comments::sort/$1/$2');