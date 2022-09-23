<?php

namespace App\Models;
use CodeIgniter\Model;

class AuthModel extends Model {
   public function userInfo($username) {
      $db = \Config\Database::connect();
      $data = $db->query("SELECT * FROM user WHERE username = '$username' AND status = 'aktif'")->getResultArray();
      return $data;
   }
}