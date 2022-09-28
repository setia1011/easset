<?php

namespace App\Controllers;

class Ref extends BaseController {
    public function index() {
        $data['pagefile'] = 'home';
        $data['pagename'] = 'Home';
        return view('pages/home', $data);
    }

    // pemasukan
    public function setJenis() {
        $data['pagefile'] = 'pemasukan';
        $data['pagename'] = 'Pemasukan';
        return view('pages/pemasukan', $data);
    }

    // permintaan
    public function setSatuan() {
        $data['pagefile'] = 'pemasukan';
        $data['pagename'] = 'Pemasukan';
        return view('pages/pemasukan', $data);
    }
}
