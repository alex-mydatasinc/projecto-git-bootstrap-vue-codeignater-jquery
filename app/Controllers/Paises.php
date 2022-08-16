<?php

namespace App\Controllers;

class Paises extends BaseController
{
    public function index()
    {
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        return view('templates/header')
            . view('paises/index')
            . view('templates/footer');
    }
    public function list() {
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $data['paises'] = json_decode($client->get('sites')->getBody());
        return $this->response->setJSON($data);
    }
}
