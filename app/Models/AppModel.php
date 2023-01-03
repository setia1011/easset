<?php

namespace App\Models;
use CodeIgniter\Model;

class AppModel extends Model {
    public function fetchAnAsset($aid) {
        $db = \Config\Database::connect();
        $res = $db->query("SELECT 
            id, 
            jenis_id,
            jenis, 
            merk,
            nama,
            uraian,
            kondisi_id,
            kondisi,
            CONCAT('/uploads/aset/', foto) foto,
            jumlah,
            satuan_id,
            satuan,
            creator,
            DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
            editor,
            DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
            status 
        FROM v_aset WHERE id = '$aid'")->getResultArray();
        return $res;
    }

    public function bookAnAset($d) {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $aid = $d['aid'];
        $user = $session->id;
        $qty = $d['qty'];

        $cek = $db->query("SELECT * FROM aset_book WHERE aset_id = '$aid' AND user = '$user' AND `status` = 'book'")->getResultArray();
        if (count($cek) > 0) {
            if ($qty > 0) {
                $res = $db->query("UPDATE aset_book SET qty = '$qty' WHERE aset_id = '$aid' AND user = '$user' AND `status` = 'book'");
            } else {
                $res = $db->query("DELETE FROM aset_book WHERE aset_id = '$aid' AND user = '$user' AND `status` = 'book'");
            }
        } else {
            $res = $db->query("INSERT INTO aset_book (aset_id, user, qty, `status`) VALUES ('$aid', '$user', '$qty', 'book')");
        }
        return $db->affectedRows();
    }

    // public function fetchBook($aid) {
    //     $session = \Config\Services::session();
    //     $db = \Config\Database::connect();
    //     $user = $session->id;
    //     $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND user = '$user' AND `book_status` = 'book'")->getResultArray();
    //     return $cek;
    // }

    public function fetchBook($d) {
        $aid = $d['aid'];
        $bid = '';
        if (isset($d['bid'])) {
            $bid = $d['bid'];
        }
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $user = $session->id;
        if ($session->level == 'admin') {
            if (!empty($bid)) {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND book_id = '$bid'")->getResultArray();
            } else {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND `book_status` = 'book'")->getResultArray();
            }
        } else {
            if (!empty($bid)) {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND book_id = '$bid' AND user = '$user'")->getResultArray();
            } else {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND user = '$user' AND `book_status` = 'book'")->getResultArray();
            }
            
        }
        return $cek;
    }

    public function fetchBooks($d) {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $user = $session->id;
        $userlev = $d['userlev'];
        if ($userlev == 'admin') {
            $status = $d['status'];
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            if ($status == 'all') {
                $sql0 = "SELECT id FROM v_book WHERE 1 = 1";
                $sql1 = "SELECT id FROM v_book WHERE 1 = 1";
                $sql2 = "SELECT * FROM v_book WHERE 1 = 1";
            } else {
                $sql0 = "SELECT id FROM v_book WHERE book_status = '$status'";
                $sql1 = "SELECT id FROM v_book WHERE book_status = '$status'";
                $sql2 = "SELECT * FROM v_book WHERE book_status = '$status'";
            }
            
            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
            }

            if (isset($d['tstart'])) {
                $tstart = $d['tstart'];
                if ($tstart) {
                    $sql1 .= " AND booked_at >= '$tstart'";
                    $sql2 .= " AND booked_at >= '$tstart'";
                }
            }

            if (isset($d['tend'])) {
                $tend = $d['tend'];
                if ($tend) {
                    $sql1 .= " AND booked_at <= '$tend'";
                    $sql2 .= " AND booked_at <= '$tend'";
                }
            }

            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY booked_at DESC LIMIT $offset, $perPage";

            $q1 = $this->db->query($sql2)->getResultArray();
            $qx = $this->db->query($sql2)->getNumRows();

            $data['totalData'] = $db->query($sql0)->getNumRows();
            $data['totalRows'] = $qx;
            $data['items'] = $q1;
            $data['totalPage'] = $total_pages;
            $data['sql'] = $sql2;
        } 

        if ($userlev == 'user') {
            $status = $d['status'];
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            if ($status == 'all') {
                $sql0 = "SELECT id FROM v_book WHERE user = '$user'";
                $sql1 = "SELECT id FROM v_book WHERE user = '$user'";
                $sql2 = "SELECT * FROM v_book WHERE user = '$user'";
            } else {
                $sql0 = "SELECT id FROM v_book WHERE user = '$user' AND `book_status` = '$status'";
                $sql1 = "SELECT id FROM v_book WHERE user = '$user' AND `book_status` = '$status'";
                $sql2 = "SELECT * FROM v_book WHERE user = '$user' AND `book_status` = '$status'";
            }
            
            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
            }

            if (isset($d['tstart'])) {
                $tstart = $d['tstart'];
                if ($tstart) {
                    $sql1 .= " AND booked_at >= '$tstart'";
                    $sql2 .= " AND booked_at >= '$tstart'";
                }
            }

            if (isset($d['tend'])) {
                $tend = $d['tend'];
                if ($tend) {
                    $sql1 .= " AND booked_at <= '$tend'";
                    $sql2 .= " AND booked_at <= '$tend'";
                }
            }

            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY booked_at DESC LIMIT $offset, $perPage";

            $q1 = $this->db->query($sql2)->getResultArray();
            $qx = $this->db->query($sql2)->getNumRows();

            $data['totalData'] = $db->query($sql0)->getNumRows();
            $data['totalRows'] = $qx;
            $data['items'] = $q1;
            $data['totalPage'] = $total_pages;
            $data['sql'] = $sql2;
            // $data = $db->query("SELECT * FROM v_book WHERE user = '$user' AND book_status = 'book'")->getResultArray();
        }
        return $data;
    }

    public function booksToCsv($d) {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $user = $session->id;
        $userlev = $d['userlev'];
        if ($userlev == 'admin') {
            $status = $d['status'];
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            if ($status == 'all') {
                $sql0 = "SELECT id FROM v_book WHERE 1 = 1";
                $sql1 = "SELECT id FROM v_book WHERE 1 = 1";
                $sql2 = "SELECT * FROM v_book WHERE 1 = 1";
            } else {
                $sql0 = "SELECT id FROM v_book WHERE book_status = '$status'";
                $sql1 = "SELECT id FROM v_book WHERE book_status = '$status'";
                $sql2 = "SELECT * FROM v_book WHERE book_status = '$status'";
            }
            
            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
            }

            if (isset($d['tstart'])) {
                $tstart = $d['tstart'];
                if ($tstart) {
                    $sql1 .= " AND booked_at >= '$tstart'";
                    $sql2 .= " AND booked_at >= '$tstart'";
                }
            }

            if (isset($d['tend'])) {
                $tend = $d['tend'];
                if ($tend) {
                    $sql1 .= " AND booked_at <= '$tend'";
                    $sql2 .= " AND booked_at <= '$tend'";
                }
            }

            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY booked_at DESC LIMIT $offset, $perPage";

            $q1 = $this->db->query($sql2)->getResultArray();
            $qx = $this->db->query($sql2)->getNumRows();

            $data['totalData'] = $db->query($sql0)->getNumRows();
            $data['totalRows'] = $qx;
            $data['items'] = $q1;
            $data['totalPage'] = $total_pages;
            $data['sql'] = $sql2;
        } 
        if ($userlev == 'user') {
            $status = $d['status'];
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            if ($status == 'all') {
                $sql0 = "SELECT id FROM v_book WHERE user = '$user'";
                $sql1 = "SELECT id FROM v_book WHERE user = '$user'";
                $sql2 = "SELECT * FROM v_book WHERE user = '$user'";
            } else {
                $sql0 = "SELECT id FROM v_book WHERE user = '$user' AND `book_status` = '$status'";
                $sql1 = "SELECT id FROM v_book WHERE user = '$user' AND `book_status` = '$status'";
                $sql2 = "SELECT * FROM v_book WHERE user = '$user' AND `book_status` = '$status'";
            }
            
            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
            }

            if (isset($d['tstart'])) {
                $tstart = $d['tstart'];
                if ($tstart) {
                    $sql1 .= " AND booked_at >= '$tstart'";
                    $sql2 .= " AND booked_at >= '$tstart'";
                }
            }

            if (isset($d['tend'])) {
                $tend = $d['tend'];
                if ($tend) {
                    $sql1 .= " AND booked_at <= '$tend'";
                    $sql2 .= " AND booked_at <= '$tend'";
                }
            }
            
            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            // $sql2 .= " ORDER BY booked_at DESC LIMIT $offset, $perPage";

            $q1 = $this->db->query($sql2)->getResultArray();
            $qx = $this->db->query($sql2)->getNumRows();

            $data['totalData'] = $db->query($sql0)->getNumRows();
            $data['totalRows'] = $qx;
            $data['items'] = $q1;
            $data['totalPage'] = $total_pages;
            $data['sql'] = $sql2;
            // $data = $db->query("SELECT * FROM v_book WHERE user = '$user' AND book_status = 'book'")->getResultArray();
        }
        return $data;
    }

    public function countAset() {
        $db = \Config\Database::connect();
        $res = $db->query("SELECT COUNT(id) jum FROM aset")->getResultArray();
        return $res;
    }

    // kondisi
    public function fetchAset($d) {
        try {
            $session = \Config\Services::session();
            $user_level = $session->level;
            
            $db = \Config\Database::connect();
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            $sql0 = "SELECT id FROM v_aset";
            $sql1 = "SELECT id FROM v_aset";
            $sql2 = "SELECT 
                id, 
                jenis_id,
                jenis, 
                merk,
                nama,
                uraian,
                kondisi_id,
                kondisi,
                CONCAT('/app/update?id=', id) edit,
                CONCAT('/uploads/aset/', foto) foto,
                jumlah,
                satuan_id,
                satuan,
                creator,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                editor,
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM v_aset WHERE 1=1";

            if ($user_level == 'user') {
                $sql2 = "SELECT 
                    id, 
                    jenis_id,
                    jenis, 
                    merk,
                    nama,
                    uraian,
                    kondisi_id,
                    kondisi,
                    CONCAT('/app/update?id=', id) edit,
                    CONCAT('/uploads/aset/', foto) foto,
                    jumlah,
                    satuan_id,
                    satuan,
                    creator,
                    DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                    editor,
                    DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                    status 
                FROM v_aset WHERE status = 'available' AND jumlah > 0";
            }

            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
            }
            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY nama ASC LIMIT $offset, $perPage";

            $q1 = $this->db->query($sql2)->getResultArray();
            $qx = $this->db->query($sql2)->getNumRows();

            $data['totalData'] = $db->query($sql0)->getNumRows();
            $data['totalRows'] = $qx;
            $data['items'] = $q1;
            $data['totalPage'] = $total_pages;
            
            return $data;
        } catch (\Exception $e) {
            return array();
        }
    }

    public function fetchBook2($d) {
        $db = \Config\Database::connect();
        $aid = $d['aid'];
        $bid = $d['bid'];
        $r = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND book_id = '$bid'")->getResultArray();
        return $r;

    }

    public function fetchPemakaianLatest($d) {
        $db = \Config\Database::connect();
        $aid = $d['aid'];
        if (isset($d['bid'])) {
            $bid = $d['bid'];
            $r = $db->query("SELECT * FROM v_pemakaian WHERE aset_id = '$aid' AND book_id = '$bid' ORDER BY id DESC LIMIT 0, 1")->getResultArray();
        } else {
            $r = $db->query("SELECT * FROM v_pemakaian WHERE aset_id = '$aid' AND book_id = '0' ORDER BY id DESC LIMIT 0, 1")->getResultArray();
        }
        return $r;
    }

    public function fetchPemakaianAll($d) {
        $db = \Config\Database::connect();
        $aid = $d['aid'];
        if (isset($d['bid'])) {
            $bid = $d['bid'];
            $r = $db->query("SELECT * FROM v_pemakaian WHERE aset_id = '$aid' AND book_id = '$bid' ORDER BY id DESC")->getResultArray();
        } else {
            $r = $db->query("SELECT * FROM v_pemakaian WHERE aset_id = '$aid' AND book_id = '0' ORDER BY id DESC")->getResultArray();
        }
        return $r;
    }

    public function xhrPemakaian($d) {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $user_id = $session->id;
        $aid = $d['aid'];
        $bid = $d['bid'];
        $kondisi = $d['kondisi'];
        $status = $d['status'];
        $keterangan = $d['keterangan'];
        $exist = $d['exist'];
        $ended = $d['ended'];
        $db->query("INSERT INTO aset_pemakaian (kondisi_id, status, exist, ended, keterangan, user_id, aset_id, book_id) VALUES ('$kondisi', '$status', '$exist', '$ended', '$keterangan', '$user_id', '$aid', '$bid')");
        if ($db->affectedRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function returnAset() {

    }

    // alokasi
    public function allocation($d) {
        $db = \Config\Database::connect();
        $aid = $d['aid'];
        $bid = $d['bid'];
        $nqty = $d['nqty'];
        $oqty = $d['oqty'];
        if ($db->query("CALL proc_book($aid, $bid, $nqty)")) {
            return true;
        } else {
            return false;
        }
    }

    public function reject($d) {
        $db = \Config\Database::connect();
        $aid = $d['aid'];
        $bid = $d['bid'];
        $nqty = $d['nqty'];
        $oqty = $d['oqty'];
        $status = $d['status'];
        if ($status == 'book') {
            if ($db->query("UPDATE aset_book SET `status` = 'rejected' WHERE id = '$bid'")) {
                return true;
            }
        }
        if ($status == 'allocated') {
            if ($db->query("UPDATE aset SET jumlah = jumlah + '$oqty' WHERE id = '$aid'")) {
                if ($db->query("UPDATE aset_book SET `status` = 'rejected' WHERE id = '$bid'")) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        if ($status == 'returned' || $status == 'rejected') {
            return false;
        }
    }

    public function statsAsetBasic($d) {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT COUNT(id) jumlah, status FROM aset GROUP BY status")->getResultArray();
        return $result;
    }

    public function statsAsetKondisi($d) {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT COUNT(b.id) jumlah, a.kondisi FROM aset_kondisi a LEFT JOIN aset b ON a.id = b.kondisi GROUP BY a.kondisi")->getResultArray();
        return $result;
    }

    public function statsBookStats($d) {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT COUNT(id) jumlah, CONCAT(DATE_FORMAT(created_at, '%b'), '-', DATE_FORMAT(created_at, '%Y')) periode, YEAR(created_at) tahun FROM aset_book GROUP BY periode, tahun ORDER BY tahun ASC")->getResultArray();
        return $result;
    }

    public function statsBooksStatus($d) {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT COUNT(id) jumlah, status FROM aset_book GROUP BY status")->getResultArray();
        return $result;
    }
}