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

    public function fetchBook($aid, $bid) {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $user = $session->id;
        if ($session->level == 'admin') {
            if (!empty($bid)) {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND book_id = '$bid' AND `book_status` = 'book'")->getResultArray();
            } else {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND `book_status` = 'book'")->getResultArray();
            }
        } else {
            if (!empty($bid)) {
                $cek = $db->query("SELECT * FROM v_book WHERE id = '$aid' AND book_id = '$bid' AND user = '$user' AND `book_status` = 'book'")->getResultArray();
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
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            $sql0 = "SELECT id FROM v_book WHERE book_status = 'book'";
            $sql1 = "SELECT id FROM v_book WHERE book_status = 'book'";
            $sql2 = "SELECT * FROM v_book WHERE book_status = 'book'";

            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
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
            $search = $d['search'];
            $currentPage = $d['currentPage'];
            $perPage = $d['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            $sql0 = "SELECT id FROM v_book WHERE user = '$user'";
            $sql1 = "SELECT id FROM v_book WHERE user = '$user'";
            $sql2 = "SELECT * FROM v_book WHERE user = '$user'";

            if (!empty($search)) {
                $sql1 .= " AND nama LIKE '%$search%'";
                $sql2 .= " AND nama LIKE '%$search%'";
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

    public function countAset() {
        $db = \Config\Database::connect();
        $res = $db->query("SELECT COUNT(id) jum FROM aset")->getResultArray();
        return $res;
    }

    // kondisi
    public function fetchAset($d) {
        try {
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
            FROM v_aset";

            if (!empty($search)) {
                $sql1 .= " WHERE nama LIKE '%$search%'";
                $sql2 .= " WHERE nama LIKE '%$search%'";
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
}