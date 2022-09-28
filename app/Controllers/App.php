<?php

namespace App\Controllers;

class App extends BaseController {
    public function index() {
        $data['pagefile'] = 'home';
        $data['pagename'] = 'Home';
        return view('pages/home', $data);
    }

    // pemasukan
    public function pemasukan() {
        $data['pagefile'] = 'pemasukan';
        $data['pagename'] = 'Pemasukan';
        return view('pages/pemasukan', $data);
    }

    // permintaan
    public function permintaan() {
        $data['pagefile'] = 'pemasukan';
        $data['pagename'] = 'Pemasukan';
        return view('pages/pemasukan', $data);
    }

    // alokasi
    public function alokasi() {
        $data['pagefile'] = 'alokasi';
        $data['pagename'] = 'Alokasi';
        return view('pages/alokasi', $data);
    }

    // pemakaian
    public function pemakaian() {
        $data['pagefile'] = 'alokasi';
        $data['pagename'] = 'Alokasi';
        return view('pages/alokasi', $data);
    }

    // pengembalian
    public function pengembalian() {
        $data['pagefile'] = 'alokasi';
        $data['pagename'] = 'Alokasi';
        return view('pages/alokasi', $data);
    }

    // pengeluaran
    public function pengeluaran() {
        $data['pagefile'] = 'pengeluaran';
        $data['pagename'] = 'Pengeluaran';
        return view('pages/pengeluaran', $data);
    }

    // laporan
    public function laporan() {
        $data['pagefile'] = 'laporan';
        $data['pagename'] = 'Laporan';
        return view('pages/laporan', $data);
    }
}
