<?php

namespace App\Controllers;

use App\Models\UserModel;
use Respect\Validation\Validator as v;

class User extends BaseController {
    public function index() {
        $data['pagefile'] = 'user';
        $data['pagename'] = 'User';
        return view('pages/user', $data);
    }

    public function allUsers() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $model = new UserModel();
        $result = $model->allUsers($d);
        echo json_encode($result);
    }

    public function createUser() {
        $d = json_decode(file_get_contents("php://input"), true);
        $v = v::key('username', v::alnum())
            ->key('password', v::alnum('@', '#', '&', '!'))
            ->key('nama', v::alnum(' ', ',', '.'))
            ->key('email', v::email())
            ->key('level', v::alnum())
            ->key('jenis_id', v::alnum())
            ->key('nomor_id', v::alnum())
            ->key('status', v::alnum(' '))
            ->validate($d);
        if ($v) {
            $model = new UserModel();
            if ($model->createUser($d) < 1) {
                echo json_encode(['message' => 'Data tidak valid!']);
            } else {
                echo json_encode(['message' => 'User berhasil dibuat..']);
            }
        } else {
            echo json_encode(['message' => 'Data tidak valid!']);
        }
    }

    // profile
    public function profile() {

    }

    // password
    public function password() {

    }
}
