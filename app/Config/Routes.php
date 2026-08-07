<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Default Route (Landing Page -> Login)
$routes->get('/', 'Auth::index');

// 2. Authentication Routes
$routes->group('auth', function($routes) {
    $routes->get('/', 'Auth::index');           // Login Page
    $routes->post('login', 'Auth::login');      // Process Login
    $routes->get('register', 'Auth::register'); // Register Page
    $routes->post('store', 'Auth::store');      // Process Registration
    $routes->get('logout', 'Auth::logout');     // Logout
});

// 3. Dashboard Routes
$routes->group('dashboard', function($routes) {
    $routes->get('admin', 'Dashboard::admin');
    $routes->get('member', 'Dashboard::member');
});

// 4. Book Management Routes
$routes->group('books', function($routes) {
    $routes->get('/', 'Books::index');               // List all books
    $routes->get('add', 'Books::add');               // Show Add Form
    $routes->post('store', 'Books::store');          // Save New Book
    $routes->get('edit/(:num)', 'Books::edit/$1');   // Show Edit Form
    $routes->post('update', 'Books::update');        // Update Book
    $routes->get('delete/(:num)', 'Books::delete/$1');// Delete Book
});

// In your Routes.php file, update the members group:
$routes->group('members', function($routes) {
    $routes->get('/', 'Members::index');             // List Members (Admin)
    $routes->get('profile', 'Members::profile');     // View Profile (Member)
    $routes->get('view/(:num)', 'Members::view/$1'); // View Member Details (Admin)
    $routes->get('print', 'Members::print');
});

// 6. Transaction (Circulation) Routes
$routes->group('transactions', function($routes) {
    $routes->get('borrow', 'Transactions::borrow');             // Show Borrow Form
    $routes->post('saveBorrow', 'Transactions::saveBorrow');    // Process Borrow
    $routes->get('return', 'Transactions::returnItem');         // Show Return List
    $routes->get('processReturn/(:num)', 'Transactions::processReturn/$1'); // Process Return
    $routes->get('history', 'Transactions::history');           // View History
});

// 7. Report Routes
$routes->get('reports', 'Reports::index');
$routes->get('reports/print/(:segment)', 'Reports::print/$1'); 

// Profile Routes
$routes->group('profile', function($routes) {
    $routes->get('/', 'ProfileController::index');                      // Profile page
    $routes->post('updatePersonal', 'ProfileController::updatePersonal'); // Update personal info
    $routes->post('changePassword', 'ProfileController::changePassword'); // Change password
});