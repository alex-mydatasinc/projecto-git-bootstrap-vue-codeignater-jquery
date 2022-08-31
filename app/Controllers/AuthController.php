<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function index()
    {
        return  view('auth/login');
    }
    public function indexregister()
    {
        return view('auth/register');
    }

    public function auth_login()
    {
        $session = session();
        $password = $this->request->getPost('password');
        $model = new UserModel();
        $data = $model->where('email', $this->request->getPost('email'))->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $session_data = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'login_in' => true
                ];
                $session->set($session_data);
                return $this->response->setJSON(['state' => 200]);
            }
            return $session->setFlashdata('msg', 'contraseña no valida');
            // return $this->response->setJSON(['statepassword' => 404]);

        } else {
            return $session->setFlashdata('msg', 'No hay registros de este correo');
            // return $this->response->setJSON(['stateuser' => 404]);

        }
    }

    public function register_save()
    {
        //include helper form
        // helper(['form']);
        //set rules validation form
        // return $this->response->setJSON(json_encode($this->request->getPost('username')));

        $rules = [
            'name'      => 'required',
            'email'         => 'required',
            'password'      => 'required'

        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);
            return $this->response->setJSON(['state' => 200]);
        } else {
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        // return $session->setFlashdata(['msg' => 'cession cerrada', 'status' => 200]);
        return redirect()->to('login_in');
    }
}
