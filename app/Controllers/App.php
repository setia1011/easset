<?php

namespace App\Controllers;

class App extends BaseController {
    public function index() {
        $session = \Config\Services::session();
        $data['pagefile'] = 'home';
        // print_r($_SESSION);
        return view('pages/home', $data);
    }
}
