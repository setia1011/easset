<?php

namespace App\Models;
use CodeIgniter\Model;

class RefModel extends Model {
    public function allJenis($d) {
        try {
            $db = \Config\Database::connect();
            $search = $d['data']['search'];
            $currentPage = $d['data']['currentPage'];
            $perPage = $d['data']['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            $sql0 = "SELECT id FROM aset_jenis";
            $sql1 = "SELECT id FROM aset_jenis";
            $sql2 = "SELECT 
                id, 
                jenis, 
                uraian,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM aset_jenis";

            if (!empty($search)) {
                $sql1 .= " WHERE jenis LIKE '%$search%'";
                $sql2 .= " WHERE jenis LIKE '%$search%'";
            }
            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY jenis ASC LIMIT $offset, $perPage";

            $q1 = $this->db->query($sql2)->getResultArray();
            $qx = $this->db->query($sql2)->getNumRows();

            $data['totalUser'] = $db->query($sql0)->getNumRows();
            $data['totalRows'] = $qx;
            $data['items'] = $q1;
            $data['totalPage'] = $total_pages;
            
            return $data;
        } catch (\Exception $e) {
            return array();
        }
    }

    public function jenisById($d) {
        try {
            $jid = $d['jid'];
            $db = \Config\Database::connect();
            $sql = $db->query("SELECT 
                id, 
                jenis, 
                uraian,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM aset_jenis WHERE id = '$jid'")->getResultArray();
            return $sql;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveJenis($d) {
        try {
            $mode = $d['mode'];
            $jid = $d['jid'];
            $jenis = $d['jenis'];
            $uraian = $d['uraian'];
            $status = $d['status'];
            $uid = $d['uid'];
            if ($mode == 'create') {
                $db = \Config\Database::connect();
                $db->query("INSERT INTO aset_jenis (jenis, uraian, creator, `status`) VALUES ('$jenis', '$uraian', '$uid', '$status')");
                return $db->affectedRows();
            }

            if ($mode == 'edit') {
                $db = \Config\Database::connect();
                $db->query("UPDATE aset_jenis SET jenis = '$jenis', uraian = '$uraian', `status` = '$status' WHERE id = '$jid'");
                return $db->affectedRows();
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
}