<?php

namespace App\Models;
use CodeIgniter\Model;

class AppModel extends Model {
    public function fetchAset() {
        $db = \Config\Database::connect();
        $res = $db->query("SELECT * FROM aset")->getResultArray();
        return $res;
    }
}