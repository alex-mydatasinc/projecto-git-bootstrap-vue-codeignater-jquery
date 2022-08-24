<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Producto;

class ProductoController extends BaseController
{
    public function __contrunct()
    {
    }
    public function index()
    {
        return view('templates/header')
            . view('productos/index')
            . view('templates/footer');
    }
    public function productos_user()
    {
        $model = new Producto();
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $user = [
            'user' => 'TEST0DZEHY3B',
            'app_id' => '4332857485021545',
            'secret' => 'BXQbMgaylwbml72KGRrBtkdQCsATIkAm',
            'user_id' => '833930674'
        ];
        $token = 'Bearer APP_USR-4332857485021545-082416-b0112bedcdbf325984cd89c71127dff8-833930674';
        $haeders = [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => $token,
                'Content-Type' => 'application/json',
            ],
        ];
        $model->emptyTable('productos');
        $results_user = json_decode($client->get('users/' . $user['user_id'] . '/items/search?limit=1000', $haeders)->getBody());
        $productos = [];
        if ($results_user->results) {
            foreach ($results_user->results as $producto) {
                $resuls_producto = json_decode($client->get('items/' . $producto, $haeders)->getBody());
                $data = [
                    'producto_id' => $resuls_producto->id,
                    'title' => $resuls_producto->title,
                    'price' => $resuls_producto->price,
                    'status' => $resuls_producto->status,
                    'start_time' => $resuls_producto->start_time,
                    'stop_time' => $resuls_producto->stop_time,
                    'condition' => $resuls_producto->condition,
                    'permalink' => $resuls_producto->permalink,
                    'thumbnail' => $resuls_producto->thumbnail,
                    'city' => $resuls_producto->seller_address->city->name . ', ' . $resuls_producto->seller_address->state->name,
                    'marca' => $resuls_producto->attributes[0]->value_name,
                ];
                $pictures = [];
                foreach ($resuls_producto->pictures as $img) {
                    $pictures[] = $img->url;
                }
                $data['pictures'] = json_encode($pictures);
                $productos[] = $data;
                if ($data) {
                    $model->insert($data);
                }
            }
            return $this->response->setJSON($productos);
        }
    }

    public function get_productos()
    {
        $model = new Producto();
        $productos = $model->where('status', 'active')->findAll();
        return $this->response->setJSON($productos);
    }
    public function store_producto()
    {
        $model = new Producto();
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com/',
        ]);
        $token = 'Bearer APP_USR-4332857485021545-081914-411d81cda3998a3353c350e86cd8a845-833930674';
        $haeders = [
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ];
        $data_request = [
            "title" => $this->request->getPost('title'),
            "category_id" => "MCO420356",
            "price" => $this->request->getPost('price'),
            "currency_id" => "COP",
            "available_quantity" => $this->request->getPost('available_quantity'),
            "condition" => $this->request->getPost('condition'),
            "listing_type_id" => "gold_special",
            "pictures" => [
                [
                    "source"=>"http://mla-s2-p.mlstatic.com/968521-MLA20805195516_072016-O.jpg"
                ]
            ]
        ];
        // return $this->response->setJSON($data);
        $resuls_producto = json_decode($client->post('items', ['json' => $data_request, 'headers' => $haeders, 'http_errors' => false])->getBody());
        $data = [
            'producto_id' => $resuls_producto->id,
            'title' => $resuls_producto->title,
            'price' => $resuls_producto->price,
            'status' => $resuls_producto->status,
            'start_time' => $resuls_producto->start_time,
            'stop_time' => $resuls_producto->stop_time,
            'condition' => $resuls_producto->condition,
            'permalink' => $resuls_producto->permalink,
            'thumbnail' => $resuls_producto->thumbnail
        ];
        $pictures = [];
        foreach ($resuls_producto->pictures as $img) {
            $pictures[] = $img->url;
        }
        $data['pictures'] = json_encode($pictures);
        $productos[] = $data;
        if ($data) {
            $model->insert($data);
        }
        return $this->response->setJSON($resuls_producto);
    }
    public function update_productos()
    {
        $model = new Producto();
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $token = 'Bearer APP_USR-4332857485021545-081914-411d81cda3998a3353c350e86cd8a845-833930674';
        $haeders = [
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ];
        $data = [
            'title' => $this->request->getPost('title'),
            'price' => $this->request->getPost('price'),
            'status' => $this->request->getPost('status'),
            // 'start_time' => $this->request->getPost('start_time'),            
            // 'stop_time' => $this->request->getPost('stop_time'),            
            'condition' => $this->request->getPost('condition'),
            // 'permalink' => $this->request->getPost('permalink'),            
            // 'pictures' => json_decode($this->request->getPost('pictures')),
            // 'thumbnail' => $this->request->getPost('thumbnail'),
            // 'city' => $this->request->getPost('city'),            
            // 'marca' => $this->request->getPost('marca'),         
        ];
        // return $this->response->setJSON($data);
        $producto = $client->put('items/' . $this->request->getPost('producto_id'), ['json' => $data, 'headers' => $haeders])->getBody();
        $id = $this->request->getPost('id');
        if ($model->find($id)) {
            if ($model->update($id, $data)) {
                $state = 200;
            } else {
                $state = 400;
            }
        } else {
            $state = 400;
        }
        return $this->response->setJSON($producto);
    }
    public function delete_producto()
    {
        $model = new Producto();
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $token = 'Bearer APP_USR-4332857485021545-082408-4c6a6f028a814c48030539ef292a7a0b-833930674';
        $haeders = [
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ];
            $client->put('items/'.$this->request->getPost('producto_id'), ['json' => ['status'=>'paused'], 'headers' => $haeders, 'http_errors' => false])->getBody();
            $producto = json_decode($client->put('items/'.$this->request->getPost('producto_id'), ['json' => ['status'=>'closed'], 'headers' => $haeders, 'http_errors' => false])->getBody());
            return $this->response->setJSON($producto);
        
    }
}
