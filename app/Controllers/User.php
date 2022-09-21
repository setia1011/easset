<?php

namespace App\Controllers;

class User extends BaseController {
    public function index() {
        $data['pagefile'] = 'user';
        return view('pages/user', $data);
    }

    // profile
    public function profile() {

    }

    // password
    public function password() {

    }
}
