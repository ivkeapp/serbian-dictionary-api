<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Converter routes
$routes->get('converter', 'Converter::index');
$routes->post('converter/translate', 'Converter::translate');

// API Routes - Database-backed (new)
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    
    // Words endpoints
    $routes->get('words', 'Words::index');
    $routes->get('words/(:any)', 'Words::show/$1');
    
    // Names endpoints
    $routes->get('names', 'Names::index');
    $routes->get('names/(:any)', 'Names::show/$1');
    
    // Surnames endpoints
    $routes->get('surnames', 'Surnames::index');
    $routes->get('surnames/(:any)', 'Surnames::show/$1');
    
    // Helper endpoints
    $routes->get('transliterate', 'Helpers::transliterate');
    $routes->get('random', 'Helpers::random');
});

// API Routes - JSON file-based (legacy)
$routes->group('api-old', ['namespace' => 'App\Controllers\ApiOld'], function($routes) {
    
    // Words endpoints
    $routes->get('words', 'Words::index');
    $routes->get('words/(:any)', 'Words::show/$1');
    
    // Names endpoints
    $routes->get('names', 'Names::index');
    $routes->get('names/(:any)', 'Names::show/$1');
    
    // Surnames endpoints
    $routes->get('surnames', 'Surnames::index');
    $routes->get('surnames/(:any)', 'Surnames::show/$1');
    
    // Helper endpoints
    $routes->get('transliterate', 'Helpers::transliterate');
    $routes->get('random', 'Helpers::random');
});
