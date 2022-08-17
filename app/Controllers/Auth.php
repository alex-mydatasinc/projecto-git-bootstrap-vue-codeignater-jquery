<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        $session = session();
        $model = new UserModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();
        if ($user) {
            $verify_pass = password_verify($user['password'], $this->request->getPost('password'));
            if ($verify_pass) {
                $session_data = [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'login_in' => true
                ];
                $session->set($session_data);
                return $this->response->setJSON(['state' => 200]);
            }
            return $session->setFlashdata('msg', 'contraseña no valida');
        }else {
            return $session->setFlashdata('msg', 'No hay registros de este correo');
        }
    }
}
