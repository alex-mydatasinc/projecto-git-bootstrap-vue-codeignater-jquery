<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CategoriasController extends BaseController
{
    protected $client;
    protected $token;
    protected $haeders;
    public function __construct()
    {
        $this->client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $this->token = 'APP_USR-4332857485021545-082408-4c6a6f028a814c48030539ef292a7a0b-833930674';
        $this->haeders = [
            'Accept'        => 'application/json',
            'Authorization' => $this->token,
            'Content-Type' => 'application/json',
        ];
    }
    public function index()
    {
        //
    }
    public function get_categorias(){
        if ($this->request->getPost('id') == 'MCO') {
            $data['categorias'] = json_decode($this->client->get( 'sites/'.$this->request->getPost('id').'/categories', ['haeders' => $this->haeders])->getBody());
        }else{
            $data['categorias'] = json_decode($this->client->get( 'categories/'.$this->request->getPost('id'), ['haeders' => $this->haeders])->getBody());
        }
        return $this->response->setJSON($data);
    }
    // public function get_detalle()
    // {
    //     $data['detalle'] = json_decode($this->client->get( 'categories/'.$this->request->getPost('id'), ['haeders' => $this->haeders])->getBody());
    //     return $this->response->setJSON($data);
    // }
    // public function get_atributos($id= null)
    // {
    //     $data['atributos'] = json_decode($this->client->get( 'categories/'.$id.'/technical_specs/input', ['haeders' => $this->haeders])->getBody());
    //     return $this->response->setJSON($data);
    // }
}
