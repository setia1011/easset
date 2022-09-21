<?php

namespace App\Controllers;

class App extends BaseController {
    public function index() {
        $session = \Config\Services::session();
        $data['pagefile'] = 'home';
        return view('pages/home', $data);
    }

    // pemasukan
    public function pemasukan() {

    }

    // alokasi
    public function alokasi() {

    }

    // pengeluaran
    public function pengeluaran() {

    }

    // laporan
    public function laporan() {

    }
}
