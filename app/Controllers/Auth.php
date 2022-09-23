<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Libraries\Utils;
use Respect\Validation\Validator as v;

class Auth extends BaseController {
    
    public function index() {
        return view('login');
    }

    // Register, not used yet
    public function register() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $username = $d['username'];
        $n_password = $d['n_password'];
        $c_password = $d['c_password'];
        if ($n_password === $c_password) {
            $password = password_hash($n_password, PASSWORD_DEFAULT);
        }
    }

    public function validatePass() {
        $session = \Config\Services::session();
        $utils = new Utils();
        $model = new AuthModel();
        $d = json_decode(file_get_contents("php://input"), TRUE);
        
        if (v::alnum($utils->passCharExs())->validate($d['password'])) {
            if ($d['ref'] == 'o') {
                $userInfo = $model->userInfo($session->username);
                if (!password_verify($d['password'], $userInfo[0]['password'])) {
                    echo json_encode('not valid');
                } else {
                    echo json_encode('valid');
                }
            } else {
                echo json_encode('valid');
            }
        } else {
            echo json_encode('not valid');
        }
    }

    // confirm password but not used
    public function confirmPass() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if ($d['n_password'] == $d['c_password']) {
            echo json_encode('valid');
        } else { echo json_encode('not valid'); }
    }

    public function updatePass() {
        $session = \Config\Services::session();
        $model = new AuthModel();
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $d['uid'] = $session->id;
        $d['password'] = password_hash($d['n_password'], PASSWORD_DEFAULT);

        if ($d['n_password'] == $d['c_password']) {
            if ($model->updatePass($d) > 0) {
                echo json_encode('Berhasil update password');
            } else { echo json_encode('Gagal update password!'); }
        } else { echo json_encode('Password tidak sama'); }
    }

    public function authenticate() {
        // Initialize session
        $session = \Config\Services::session();

        // default superuser
        $super = [
            'id' => 1001,
            'username' => 'admin',
            'password' => 123456,
            'nama' => 'Administrator',
            'level' => 'admin',
            'email' => 'admin@easset.id',
            'jenis_id' => 'nik',
            'nomor_id' => '1001001001001',
            'status' => 'aktif'
        ];

        $d = json_decode(file_get_contents("php://input"), TRUE);

        if ($d['username'] == $super['username'] && $d['password'] == $super['password']) {
            unset($super['password']);
            $super['credential'] = true;
            $session->set($super);
            echo json_encode(['userInfo' => $super]);
            die();
        }

        $username = $d['username'];
        $password = $d['password'];
        $v_username = v::alnum()->validate($username);
        if ($v_username) {
            // get userinfo by username
            $model = new AuthModel();
            $userInfo = $model->userInfo($username);
            if (count($userInfo) > 0) {
                // verify password and username
                if (!isset($userInfo[0]['username']) || !password_verify($password, $userInfo[0]['password'])) {
                    // http_response_code(400);
                    echo json_encode(['error' => "Username dan/atau password tidak valid!"]);
                    exit();
                } else {
                    unset($userInfo[0]['password']);
                    $userInfo[0]['credential'] = true;
                    $session->set($userInfo[0]);
                    echo json_encode(['userInfo' => $userInfo[0]]);
                }
            } else {
                echo json_encode(['error' => "Username dan/atau password tidak valid!"]);
            }
        } else {
            echo json_encode(['error' => "Username dan/atau password tidak valid!"]);
        }
    }

    public function logout() {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('/');
    }
}
