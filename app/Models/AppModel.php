<?php

namespace App\Models;
use CodeIgniter\Model;

class AppModel extends Model {
    // public function $routes->post('/app/fetch-aset', 'App::fetchAset');() {
    //     $db = \Config\Database::connect();
    //     $res = $db->query("SELECT * FROM aset")->getResultArray();
    //     return $res;
    // }

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