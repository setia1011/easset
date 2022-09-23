<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\Utils;
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

    public function userById() {
        $d = json_decode(file_get_contents("php://input"), true);
        $v = v::number()->validate($d['uid']);
        if ($v) {
            $model = new UserModel();
            echo json_encode(['message' => 'User info founded', 'userInfo' => $model->userById($d)]);
        } else {
            echo json_encode(['message' => 'Data tidak valid!']);
        }
    }

    public function createUser() {
        $d = json_decode(file_get_contents("php://input"), true);
        $model = new UserModel();
        $utils = new Utils();

        // actor (user) id from session
        $session = \Config\Services::session();
        $d['actor'] = $session->id;

        $mode = $d['mode'];
        $v1 = v::key('username', v::alnum())
                ->key('nama', v::alnum(' ', ',', '.'))
                ->key('email', v::email())
                ->key('level', v::alnum())
                ->key('jenis_id', v::alnum())
                ->key('nomor_id', v::alnum())
                ->key('status', v::alnum(' '))
                ->validate($d);
        $v2 = v::alnum($utils->passCharExs())->validate($d['password']);
        $v3 = v::number()->validate($d['uid']);

        // hash password
        if ($v2) { $d['password'] = password_hash($d['password'], PASSWORD_DEFAULT);}

        // Create
        if ($mode == 'create') {
            if ($v1 && $v2) {
                if ($model->createUser($d) < 1) { echo json_encode(['message' => 'Data tidak valid!']);
                } else { echo json_encode(['message' => 'User berhasil dibuat..']); }
            } else { echo json_encode(['message' => 'Data tidak valid!']); }
        }

        // Update
        if ($mode == 'update') {
            if ($v1 && $v3) {
                if ($model->createUser($d) < 1) { echo json_encode(['message' => 'Tidak ada perubahan data..']);
                } else { echo json_encode(['message' => 'User berhasil diupdate..']); }
            } else {
                echo json_encode(['message' => 'Data tidak valid!']);
            }
        }   
    }

    // profile
    public function profile() {
        $data['pagefile'] = 'user_profile';
        $data['pagename'] = 'Profile';
        return view('pages/user_profile', $data);
    }

    public function updateUser() {
        $d = json_decode(file_get_contents("php://input"), true);
        $model = new UserModel();

        // actor (user) id from session
        $session = \Config\Services::session();
        $d['actor'] = $session->id;
        $d['mode'] = 'update-profile';

        $v1 = v::key('nama', v::alnum(' ', ',', '.'))
                ->key('email', v::email())
                ->key('jenis_id', v::alnum())
                ->key('nomor_id', v::alnum())
                ->validate($d);
        $v3 = v::number()->validate($d['uid']);

        // Update
        if ($v1 && $v3) {
            if ($model->updateUser($d) < 1) { echo json_encode(['message' => 'Tidak ada perubahan data..']);
            } else { echo json_encode(['message' => 'Profile berhasil diupdate..']); }
        } else {
            echo json_encode(['message' => 'Data tidak valid!']);
        }
    }

    // password
    public function password() {
        $data['pagefile'] = 'user_password';
        $data['pagename'] = 'Password';
        return view('pages/user_password', $data);
    }
}
