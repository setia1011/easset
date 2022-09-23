<?php

namespace App\Models;
use CodeIgniter\Model;

class AuthModel extends Model {
   public function userInfo($username) {
      $db = \Config\Database::connect();
      $data = $db->query("SELECT * FROM user WHERE username = '$username' AND status = 'aktif'")->getResultArray();
      return $data;
   }

   public function updatePass($d) {
      $password = $d['password'];
      $uid = $d['uid'];
      $db = \Config\Database::connect();
      $db->query("UPDATE user SET password = '$password' WHERE id = '$uid'");
      return $db->affectedRows();
   }
}