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
    public function get_categorias(){
        
        if ($this->request->getPost('id') == 'MCO') {
            $data['categorias'] = json_decode($this->client->get( 'sites/'.$this->request->getPost('id').'/categories', ['haeders' => $this->haeders])->getBody());
            return $this->response->setJSON($data['categorias']);
        }else{
            // print_r($this->request->getPost('id'));
            $data['categorias'] = json_decode($this->client->get( 'categories/'.$this->request->getPost('id'), ['haeders' => $this->haeders])->getBody());
            if ($data['categorias']->children_categories) {
                return $this->response->setJSON($data['categorias']->children_categories);
            }else {
                $data['atributos'] = json_decode($this->client->get( 'categories/'.$this->request->getPost('id').'/technical_specs/input', ['haeders' => $this->haeders])->getBody());
                return $this->response->setJSON($data['atributos']);
            }
            
        }
        
    }
    // public function get_detalle()
    // {
    //     $data['detalle'] = json_decode($this->client->get( 'categories/'.$this->request->getPost('id'), ['haeders' => $this->haeders])->getBody());
    //     return $this->response->setJSON($data);
    // }
}
