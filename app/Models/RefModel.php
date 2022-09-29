<?php

namespace App\Models;
use CodeIgniter\Model;

class RefModel extends Model {
    // Jenis
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
                $db->query("UPDATE aset_jenis SET jenis = '$jenis', uraian = '$uraian', editor = '$uid', `status` = '$status' WHERE id = '$jid'");
                return $db->affectedRows();
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delJenis($d) {
        try {
            $jid = $d['jid'];
            $db = \Config\Database::connect();
            $db->query("DELETE FROM aset_jenis WHERE id = '$jid'");
            return $db->affectedRows();
        } catch (\Exception $e) {
            return 0;
        }
    }

    // Satuan
    public function allSatuan($d) {
        try {
            $db = \Config\Database::connect();
            $search = $d['data']['search'];
            $currentPage = $d['data']['currentPage'];
            $perPage = $d['data']['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            $sql0 = "SELECT id FROM aset_satuan";
            $sql1 = "SELECT id FROM aset_satuan";
            $sql2 = "SELECT 
                id, 
                satuan, 
                uraian,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM aset_satuan";

            if (!empty($search)) {
                $sql1 .= " WHERE satuan LIKE '%$search%'";
                $sql2 .= " WHERE satuan LIKE '%$search%'";
            }
            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY satuan ASC LIMIT $offset, $perPage";

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

    public function satuanById($d) {
        try {
            $sid = $d['sid'];
            $db = \Config\Database::connect();
            $sql = $db->query("SELECT 
                id, 
                satuan, 
                uraian,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM aset_satuan WHERE id = '$sid'")->getResultArray();
            return $sql;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveSatuan($d) {
        try {
            $mode = $d['mode'];
            $sid = $d['sid'];
            $satuan = $d['satuan'];
            $uraian = $d['uraian'];
            $status = $d['status'];
            $uid = $d['uid'];
            if ($mode == 'create') {
                $db = \Config\Database::connect();
                $db->query("INSERT INTO aset_satuan (satuan, uraian, creator, `status`) VALUES ('$satuan', '$uraian', '$uid', '$status')");
                return $db->affectedRows();
            }

            if ($mode == 'edit') {
                $db = \Config\Database::connect();
                $db->query("UPDATE aset_satuan SET satuan = '$satuan', uraian = '$uraian', editor = '$uid', `status` = '$status' WHERE id = '$sid'");
                return $db->affectedRows();
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delSatuan($d) {
        try {
            $sid = $d['sid'];
            $db = \Config\Database::connect();
            $db->query("DELETE FROM aset_satuan WHERE id = '$sid'");
            return $db->affectedRows();
        } catch (\Exception $e) {
            return 0;
        }
    }

    // kondisi
    public function allKondisi($d) {
        try {
            $db = \Config\Database::connect();
            $search = $d['data']['search'];
            $currentPage = $d['data']['currentPage'];
            $perPage = $d['data']['perPage'];
            $offset = ($currentPage - 1) * $perPage;

            $sql0 = "SELECT id FROM aset_kondisi";
            $sql1 = "SELECT id FROM aset_kondisi";
            $sql2 = "SELECT 
                id, 
                kondisi, 
                uraian,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM aset_kondisi";

            if (!empty($search)) {
                $sql1 .= " WHERE kondisi LIKE '%$search%'";
                $sql2 .= " WHERE kondisi LIKE '%$search%'";
            }
            $result = $db->query($sql1)->getNumRows();
            $total_rows = $result;
            $total_pages = ceil($total_rows / $perPage);

            $sql2 .= " ORDER BY kondisi ASC LIMIT $offset, $perPage";

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

    public function kondisiById($d) {
        try {
            $kid = $d['kid'];
            $db = \Config\Database::connect();
            $sql = $db->query("SELECT 
                id, 
                kondisi, 
                uraian,
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                DATE_FORMAT(edited_at, '%d/%m/%Y %H:%i:%s') edited_at, 
                status 
            FROM aset_kondisi WHERE id = '$kid'")->getResultArray();
            return $sql;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveKondisi($d) {
        try {
            $mode = $d['mode'];
            $kid = $d['kid'];
            $kondisi = $d['kondisi'];
            $uraian = $d['uraian'];
            $status = $d['status'];
            $uid = $d['uid'];
            if ($mode == 'create') {
                $db = \Config\Database::connect();
                $db->query("INSERT INTO aset_kondisi (kondisi, uraian, creator, `status`) VALUES ('$kondisi', '$uraian', '$uid', '$status')");
                return $db->affectedRows();
            }
            if ($mode == 'edit') {
                $db = \Config\Database::connect();
                $db->query("UPDATE aset_kondisi SET kondisi = '$kondisi', uraian = '$uraian', editor = '$uid', `status` = '$status' WHERE id = '$kid'");
                return $db->affectedRows();
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delKondisi($d) {
        try {
            $kid = $d['kid'];
            $db = \Config\Database::connect();
            $db->query("DELETE FROM aset_kondisi WHERE id = '$kid'");
            return $db->affectedRows();
        } catch (\Exception $e) {
            return 0;
        }
    }
}