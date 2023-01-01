<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use App\Models\AppModel;
use App\Libraries\Utils;
use Error;
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
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $model = new AppModel();
        $asetData = $model->fetchAset($d);
        foreach ($asetData['items'] as $k => $a) {
            // print_r($k);
            if (!file_exists(FCPATH . $a['foto'])) {
                $asetData['items'][$k]['foto'] = "images/add-image.png";
            } 
        }
        echo json_encode($asetData);
        // echo json_encode($model->fetchAset($d));
    }

    public function fetchAnAset() {
        $session = \Config\Services::session();
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if (isset($d['bid'])) {
            $bid = $d['bid'];
        } else {
            $bid = '';
        }
        $model = new AppModel();
        $asetData = $model->fetchAnAsset($d['aid']);
        $asetBook = $model->fetchBook($d);
        foreach ($asetData as $k => $a) {
            if (count($asetBook) > 0) {
                if ($session->level == 'admin' & $bid == '') {
                    $asetData[$k]['book_id'] = null;
                    $asetData[$k]['book_qty'] = 0;
                } else {
                    $asetData[$k]['book_id'] = $asetBook[0]['book_id'];
                    $asetData[$k]['book_qty'] = $asetBook[0]['book_qty'];
                }
            } else {
                $asetData[$k]['book_id'] = null;
                $asetData[$k]['book_qty'] = 0;
            }
            if (!file_exists(FCPATH . $a['foto'])) {
                $asetData[$k]['foto'] = "images/add-image.png";
            } 
        }
        echo json_encode($asetData);
    }

    public function bookAnAset() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if (isset($d['bid'])) {
            $bid = $d['bid'];
        } else {
            $bid = '';
        }
        $model = new AppModel();
        $asetData = $model->bookAnAset($d);
        if ($asetData) {
            $asetBook = $model->fetchBook($d);
            echo json_encode($asetBook);
        } else {
            $asetBook = $model->fetchBook($d);
            echo json_encode($asetBook);
        }
    }

    public function allocation() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if ($d['nqty'] < 1) {
            echo json_encode("Jumlah booking minimal 1 unit");
            die();
        }
        $model = new AppModel();
        $book = $model->fetchBook2($d);
        if (count($book) > 0) {
            if ($book[0]['book_status'] == 'book') {
                $aset = $model->fetchAnAsset($d['aid']);
                if (count($aset) > 0) {
                    if (intval($aset[0]['jumlah']) >= $d['nqty']) {
                        if ($model->allocation($d)) {
                            echo json_encode("Alokasi aset berhasil");
                        } else {
                            echo json_encode("Alokasi aset gagal");
                        }
                    } else {
                        echo json_encode("Stok aset sudah habis");
                    }
                } else {
                    echo json_encode("Aset tidak ditemukan");
                }
            } else {
                echo json_encode("Status aset sudah/tidak bisa dialokasikan");
            }
        } else {
            echo json_encode("Aset tidak ditemukan");
        }
    }

    public function reject() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $model = new AppModel();
        $book = $model->fetchBook2($d);
        if (count($book) > 0) {
            
            if ($book[0]['book_status'] == 'returned' || $book[0]['book_status'] == 'rejected') {
                echo json_encode("Status aset tidak bisa direject");
            } else {
                if ($book[0]['book_status'] == 'book') {
                    // update status
                    $d['status'] = 'book';
                    if ($model->reject($d)) {
                        echo json_encode("Aset berhasil direject ~ 1");
                    } else {
                        echo json_encode("Aset gagal direject");
                    }
                }
                if ($book[0]['book_status'] == 'allocated') {
                    $d['status'] = 'allocated';
                    // kembalikan stok
                    // update status
                    if ($model->reject($d)) {
                        echo json_encode("Aset berhasil direject ~ 2");
                    } else {
                        echo json_encode("Aset gagal direject");
                    }
                }
            }
        } else {
            echo json_encode("Aset tidak ditemukan");
        }
    }

    public function countAset() {
        $model = new AppModel();
        echo json_encode($model->countAset());
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
                $fx = \Config\Services::image('gd')
                    ->withFile($f)
                    ->resize(550, 640, false, 'height')
                    ->save(FCPATH . '/uploads/aset/' . $fotox);
                if ($fx) {
                    // access database
                    $database = \Config\Database::connect();
                    $db = $database->table('aset');
                    if ($db->insert($d)) {  
                        return "Berhasil menyimpan data aset";
                    } else {
                        unlink(FCPATH . '/uploads/aset/' . $fotox);
                        return "Gagal menyimpan data aset";
                    }
                }     
            }
        } else { return "Data tidak valid!"; }
    }

    public function update() {
        $id = $_GET['id'];
        if (v::intVal()->validate($id)) {
            $data['aid'] = $id;
            $data['pagefile'] = 'update';
            $data['pagename'] = 'Update';
            return view('pages/update', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function updateAset() {
        $session = \Config\Services::session();
        $foto = $_FILES;
        $d = $_POST;
        $d['creator'] = $session->id;

        $v = v::key('nama', v::alnum(' ', ',', '.', '#'))
            ->key('uraian', v::alnum(' ', ',', '.', '#', '%', '$', '&'))
            ->key('id', v::intVal())
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
                        // . '|max_size[foto,2048]'
                        // . '|max_dims[foto,1024,768]',
                ],
            ];
            if (!$this->validate($vfoto)) {
                $data = ['errors' => $this->validator->getErrors()];
                return $data['errors']['foto'];
            } else {
                $f = $this->request->getFile('foto');
                $fotox = $f->getRandomName();
                $d['foto'] = $fotox;
                $fx = \Config\Services::image('gd')
                    ->withFile($f)
                    ->resize(550, 640, true, 'height')
                    ->save(FCPATH . '/uploads/aset/' . $fotox);
                if ($fx) {
                    // access database
                    $database = \Config\Database::connect();

                    // get current foto from database
                    $cb = $database->table('aset');
                    $cb->where('id', $d['id']);
                    $cx = $cb->get()->getResultArray();
                    foreach ($cx as $r) {
                        if (file_exists(FCPATH . '/uploads/aset/' . $r['foto'])) {
                            // remove current foto
                            unlink(FCPATH . '/uploads/aset/' . $r['foto']);
                        }
                    }

                    $db = $database->table('aset');
                    $db->where('id', $d['id']);
                    if ($db->update($d)) {  
                        return "Berhasil menyimpan data aset";
                    } else {
                        unlink(FCPATH . '/uploads' . $fotox);
                        return "Gagal menyimpan data aset";
                    }
                }     
            }
        } elseif ($v & !isset($foto['foto'])) {
            $database = \Config\Database::connect();
            $db = $database->table('aset');
            $db->where('id', $d['id']);
            unset($d['foto']);
            if ($db->update($d)) {  
                return "Berhasil menyimpan data aset";
            } else {
                return "Gagal menyimpan data aset";
            }
        } else {
            return "Data tidak valid!";
        }
    }

    public function fetchBooks() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $model = new AppModel();
        $asetBook = $model->fetchBooks($d);
        return json_encode($asetBook);
    }

    public function browseAset() {
        $data['pagefile'] = 'browse';
        $data['pagename'] = 'Browse';
        return view('pages/browse', $data);
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

    // my aset
    public function myAset() {
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
