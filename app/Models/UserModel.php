<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    // get all users with pagination format
    public function allUsers($d) {
        $db = \Config\Database::connect();
        $search = $d['data']['search'];
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT id FROM user";
        $sql2 = "SELECT 
            id, 
            username, 
            level, 
            nama, 
            email, 
            jenis_id, 
            nomor_id, 
            DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
            status 
        FROM user";

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

        $data['totalUser'] = $result;
        $data['totalRows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;
        
        return $data;
    }

    // single user by id
    public function userById($d) {
        try {
            $uid = $d['uid'];
            $db = \Config\Database::connect();
            $sql = $db->query("SELECT 
                id, 
                username, 
                level, 
                nama, 
                email, 
                jenis_id, 
                nomor_id, 
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') created_at, 
                status 
            FROM user WHERE id = '$uid'")->getResultArray();
            return $sql;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // create user
    public function createUser($d) {
        try {
            $mode = $d['mode'];
            $uid = $d['uid'];
            $actor = $d['actor'];
            $username = $d['username'];
            $password = $d['password'];
            $level = $d['level'];
            $nama = $d['nama'];
            $email = $d['email'];
            $jenis_id = $d['jenis_id'];
            $nomor_id = $d['nomor_id'];
            $status = $d['status'];

            // Create
            if ($mode == 'create') {
                $db = \Config\Database::connect();
                $sql = $db->query("INSERT INTO user (
                    username, 
                    password, 
                    level, 
                    nama,
                    email, 
                    jenis_id, 
                    nomor_id,
                    created_by,
                    status) 
                VALUES (
                    '$username',
                    '$password',
                    '$level',
                    '$nama',
                    '$email',
                    '$jenis_id',
                    '$nomor_id',
                    '$actor',
                    '$status')");
                return $db->affectedRows();
            }

            // Update
            if ($mode == 'update') {
                if (!empty($password)) {
                    $db = \Config\Database::connect();
                    $db->query("UPDATE user SET 
                        username = '$username', 
                        password = '$password', 
                        level = '$level', 
                        nama = '$nama', 
                        email = '$email', 
                        jenis_id = '$jenis_id', 
                        nomor_id = '$nomor_id', 
                        updated_by = '$actor',
                        status = '$status' WHERE id = '$uid'");
                    return $db->affectedRows();
                } else {
                    $db = \Config\Database::connect();
                    $db->query("UPDATE user SET 
                        username = '$username',
                        level = '$level', 
                        nama = '$nama', 
                        email = '$email', 
                        jenis_id = '$jenis_id', 
                        nomor_id = '$nomor_id', 
                        updated_by = '$actor',
                        status = '$status' WHERE id = '$uid'");
                    return $db->affectedRows();
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // create user
    public function updateUser($d) {
        try {
            $uid = $d['uid'];
            $actor = $d['actor'];
            $nama = $d['nama'];
            $email = $d['email'];
            $jenis_id = $d['jenis_id'];
            $nomor_id = $d['nomor_id'];

            $db = \Config\Database::connect();
            $db->query("UPDATE user SET
                nama = '$nama', 
                email = '$email', 
                jenis_id = '$jenis_id', 
                nomor_id = '$nomor_id', 
                updated_by = '$actor' WHERE id = '$uid'");
            return $db->affectedRows();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}