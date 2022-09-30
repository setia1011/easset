<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use App\Models\AppModel;
use App\Libraries\Utils;
use Respect\Validation\Validator as v;

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

    public function fetchAset() {
        $model = new AppModel();
        echo json_encode($model->fetchAset());
    }

    public function rekamAset() {
        $session = \Config\Services::session();
        $foto = $_FILES;
        $d = $_POST;
        $d['creator'] = $session->id;

        $v = v::key('nama', v::alnum(' ', ',', '.', '#'))
            ->key('uraian', v::alnum(' ', ',', '.', '#', '%', '$', '&'))
            ->key('merk', v::alnum('-'))
            ->key('jenis', v::number())
            ->key('jumlah', v::number())
            ->key('satuan', v::number())
            ->key('status', v::alnum(' '))
            ->key('kondisi', v::number())->validate($d);
        if ($v & isset($foto['foto']) & !empty($foto['foto'])) {
            $vfoto = [
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[foto]'
                        . '|is_image[foto]'
                        . '|mime_in[foto,image/jpg,image/jpeg,image/png]'
                        . '|max_size[foto,2048]'
                        . '|max_dims[foto,1024,768]',
                ],
            ];
            if (!$this->validate($vfoto)) {
                $data = ['errors' => $this->validator->getErrors()];
                return $data['errors']['foto'];
            } else {
                $f = $this->request->getFile('foto');
                $fotox = $f->getRandomName();
                $d['foto'] = $fotox;
                $fx = \Config\Services::image()
                    ->withFile($f)
                    ->resize(550, 640, true, 'height')
                    ->save(WRITEPATH . '/uploads/aset/' . $fotox);
                if ($fx) {
                    // access database
                    $database = \Config\Database::connect();
                    $db = $database->table('aset');
                    if ($db->insert($d)) {  
                        return "Berhasil menyimpan data aset";
                    } else {
                        unlink(WRITEPATH . '/uploads/aset/' . $fotox);
                        return "Gagal menyimpan data aset";
                    }
                }     
            }
        } else { return "Data tidak valid!"; }
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
