<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('App');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'App::index');
$routes->get('/app/browse', 'App::browseAset');
$routes->get('/app/pemasukan', 'App::pemasukan');
$routes->get('/app/permintaan', 'App::permintaan');
$routes->get('/app/alokasi', 'App::alokasi');
$routes->get('/app/pemakaian', 'App::pemakaian');
$routes->get('/app/pengembalian', 'App::pengembalian');
$routes->get('/app/pengeluaran', 'App::pengeluaran');
$routes->get('/app/laporan', 'App::laporan');

$routes->post('/app/fetch-aset', 'App::fetchAset');
$routes->post('/app/fetch-an-aset', 'App::fetchAnAset');
$routes->post('/app/count-aset', 'App::countAset');
$routes->post('/app/rekam-aset', 'App::rekamAset');

// Auth
$routes->get('/auth/login', 'Auth::index');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->post('/auth/validate-pass', 'Auth::validatePass');
$routes->post('/auth/confirm-pass', 'Auth::confirmPass');
$routes->post('/auth/update-pass', 'Auth::updatePass');
$routes->get('/auth/logout', 'Auth::logout');

// User
$routes->get('/user', 'User::index');
$routes->post('/user/all-users', 'User::allUsers');
$routes->post('/user/a-user', 'User::userById');
$routes->post('/user/create-user', 'User::createUser');
$routes->post('/user/update-user', 'User::updateUser');
$routes->get('/user/profile', 'User::profile');
$routes->get('/user/password', 'User::password');

// Ref
$routes->get('/', 'Ref::index');
$routes->get('/ref/set-jenis', 'Ref::setJenis');
$routes->post('/ref/save-jenis-aset', 'Ref::saveJenis');
$routes->post('/ref/all-jenis-aset', 'Ref::allJenis');
$routes->post('/ref/a-jenis', 'Ref::jenisById');
$routes->post('/ref/delete-jenis', 'Ref::delJenis');
$routes->get('/ref/set-satuan', 'Ref::setSatuan');
$routes->post('/ref/save-satuan-aset', 'Ref::saveSatuan');
$routes->post('/ref/all-satuan-aset', 'Ref::allSatuan');
$routes->post('/ref/a-satuan', 'Ref::satuanById');
$routes->post('/ref/delete-satuan', 'Ref::delSatuan');
$routes->get('/ref/set-kondisi', 'Ref::setKondisi');
$routes->post('/ref/save-kondisi-aset', 'Ref::saveKondisi');
$routes->post('/ref/all-kondisi-aset', 'Ref::allKondisi');
$routes->post('/ref/a-kondisi', 'Ref::kondisiById');
$routes->post('/ref/delete-kondisi', 'Ref::delKondisi');

$routes->post('/ref/fetch-refs', 'Ref::fetchOptRefs');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
