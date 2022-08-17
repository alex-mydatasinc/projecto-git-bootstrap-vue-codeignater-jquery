<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProductoController extends BaseController
{
    public function index()
    {
        return view('templates/header')
                .view('productos/index')
                .view('templates/footer');
    }
    public function productos_user() {
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $user = [
            'user' => 'TEST0DZEHY3B',
            'app_id' => '4332857485021545',
            'secret' => 'BXQbMgaylwbml72KGRrBtkdQCsATIkAm',
            'user_id' => '833930674'
        ];
        $token = 'Bearer APP_USR-4332857485021545-081716-c062f73f1d9e7e81745cb041350bc29b-833930674';
        $haeders = [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => $token,
            ],
        ];
        $productos = $client->get('users/'.$user['user_id'].'/items/search', $haeders )->getBody();
        if ($productos['results']) {
            foreach ($productos['results'] as $producto) {
                # code...
            }
        }
        return $this->response->setJSON($productos);
    }
}
