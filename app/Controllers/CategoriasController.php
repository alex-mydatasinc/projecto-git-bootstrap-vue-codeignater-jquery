<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CategoriasController extends BaseController
{
    public function index()
    {
        //
    }
    public function get_categorias(){
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $data['categorias'] = json_decode($client->get( 'sites/'.$this->request->getPost('id').'/categories')->getBody());
        return $this->response->setJSON($data);
    }
    public function get_detalle()
    {
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $data['detalle'] = json_decode($client->get( 'categories/'.$this->request->getPost('id'))->getBody());
        return $this->response->setJSON($data);
    }
}
