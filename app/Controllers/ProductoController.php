<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Producto;

class ProductoController extends BaseController
{
    protected $model;
    protected $client;
    protected $user;
    protected $token;
    protected $haeders;

    public function __construct()
    {
        $this->model = new Producto();
        $this->client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com',
        ]);
        $this->user = [
            'user' => 'TEST0DZEHY3B',
            'app_id' => '4332857485021545',
            'secret' => 'BXQbMgaylwbml72KGRrBtkdQCsATIkAm',
            'user_id' => '833930674'
        ];
        // $this->token = '';
        $this->haeders = [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer APP_USR-4332857485021545-082510-db84053bf7e22ee55f8771f1e7601b59-833930674',
            'Content-Type' => 'application/json',
        ];
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
        $token = 'Bearer APP_USR-4332857485021545-082510-db84053bf7e22ee55f8771f1e7601b59-833930674';
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
        $productos = $this->model->findAll();
        return $this->response->setJSON($productos);
    }
    public function store_producto()
    {
        $data_request = [
            "title" => $this->request->getPost('title'),
            "category_id" => $this->request->getPost('category_id'),
            "price" => $this->request->getPost('price'),
            "currency_id" => "COP",
            "available_quantity" => $this->request->getPost('available_quantity'),
            "condition" => $this->request->getPost('condition'),
            "listing_type_id" => "gold_special",
            "pictures" => $this->request->getPost('pictures')
        ];
        // return $this->response->setJSON($data_request);
        $resuls_producto = json_decode($this->client->post('items', ['json' => $data_request, 'headers' => $this->haeders, 'http_errors' => false])->getBody());
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
            $this->model->insert($data);
        }
        return $this->response->setJSON($resuls_producto);
    }
    public function update_productos()
    {
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
        $producto = $this->client->put('items/' . $this->request->getPost('producto_id'), ['json' => $data, 'headers' => $this->haeders])->getBody();
        $id = $this->request->getPost('id');
        if ($this->model->find($id)) {
            if ($this->model->update($id, $data)) {
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
        $this->client->put('items/'.$this->request->getPost('producto_id'), ['json' => ['status'=>'paused'], 'headers' => $this->haeders, 'http_errors' => false])->getBody();
        $producto = json_decode($this->client->put('items/'.$this->request->getPost('producto_id'), ['json' => ['status'=>'closed'], 'headers' => $this->haeders, 'http_errors' => false])->getBody());
        return $this->response->setJSON($producto);
        
    }
}
