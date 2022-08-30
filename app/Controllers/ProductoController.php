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
            'Authorization' => 'Bearer APP_USR-4332857485021545-083008-bd43d5031b5e9cb12f70a4b21f7dfc83-833930674',
            'Content-Type' => 'application/json',
        ];
    }
    public function index()
    {
        return view('productos/index');
    }
    public function list(){
        return view('productos/list');
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
        $token = 'Bearer APP_USR-4332857485021545-083008-bd43d5031b5e9cb12f70a4b21f7dfc83-833930674';
        $haeders = [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => $token,
                'Content-Type' => 'application/json',
            ],
        ];
        $model->emptyTable('productos');
        $results_user = json_decode($client->get('users/' . $user['user_id'] . '/items/search?limit=200&offset=100', $haeders)->getBody());
        $productos = [];
        if ($results_user->results) {
            foreach ($results_user->results as $producto) {
                $resuls_producto = json_decode($client->get('items/' . $producto, $haeders)->getBody());
                $data = [
                    'category_id' => $resuls_producto->category_id,
                    'producto_id' => $resuls_producto->id,
                    'title' => $resuls_producto->title,
                    'price' => $resuls_producto->price,
                    'status' => $resuls_producto->status,
                    'start_time' => $resuls_producto->start_time,
                    'stop_time' => $resuls_producto->stop_time,
                    'condition' => $resuls_producto->condition,
                    'permalink' => $resuls_producto->permalink,
                    'available_quantity' => $resuls_producto->available_quantity,
                    'attributes' => json_encode($resuls_producto->attributes),
                    'pictures' => json_encode($resuls_producto->pictures),
                    'thumbnail' => $resuls_producto->thumbnail,
                    'city' => $resuls_producto->seller_address->city->name . ', ' . $resuls_producto->seller_address->state->name,
                    'marca' => $resuls_producto->attributes[0]->value_name,
                ];
                // $pictures = [];
                // foreach ($resuls_producto->pictures as $img) {
                //     $pictures[] = $img->url;
                // }
                // $attributes = [];
                // foreach ($resuls_producto->attributes as $attr) {
                //     // $attributes[] = $attr->url;
                // }
                // $data['pictures'] = json_encode($pictures);
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
        $productos = $this->model->where('status', 'active')->orWhere('status', 'paused')->findAll();
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
            "pictures" => $this->request->getPost('pictures'),
            "attributes" => $this->request->getPost('attributes')
        ];
        // return $this->response->setJSON($data_request);
        $resuls_producto = json_decode($this->client->post('items', ['json' => $data_request, 'headers' => $this->haeders, 'http_errors' => false])->getBody());
        print_r($resuls_producto);
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
            'category_id' => $resuls_producto->category_id,
            'available_quantity' => $resuls_producto->available_quantity,
            'attributes' => json_encode($resuls_producto->attributes),
        ];
        $pictures = [];
        foreach ($resuls_producto->pictures as $img) {
            $pictures[] = $img->url;
        }
        $data['pictures'] = json_encode($pictures);
        $productos[] = $data;
        if ($data) {
            return $this->model->insert($data);
        }
        return $this->response->setJSON($resuls_producto);
    }

    public function update_productos()
    {
        $data = [
            "title" => $this->request->getPost('title'),
            "category_id" => $this->request->getPost('category_id'),
            "price" => $this->request->getPost('price'),
            "available_quantity" => $this->request->getPost('available_quantity'),
            "condition" => $this->request->getPost('condition'),
            "pictures" => $this->request->getPost('pictures'),
            "attributes" => $this->request->getPost('attributes'),
            // 'producto_id' => $this->request->getPost('producto_id'),
            // 'id' => $this->request->getPost('id'),
        ];
        // return $this->response->setJSON($data);
        $producto = $this->client->put('items/' . $this->request->getPost('producto_id'), ['json' => $data, 'headers' => $this->haeders])->getBody();
        // return $this->response->setJSON(json_decode($producto)->pictures);
        // $pictures = [];
        // foreach ($producto->pictures as $img) {
        //     $pictures[] = $img->url;
        // }
        // $data['pictures'] = json_encode($pictures);
        $data['pictures'] = json_encode(json_decode($producto)->pictures);
        $data['attributes'] = json_encode($this->request->getPost('attributes'));
        $id = $this->request->getPost('id');
        if ($this->model->find($id)) {
            if ($this->model->update($id, $data)) {
                // return $this->response->setJSON($this->model->find($id));
                $state = 200;
            } else {
                $state = 400;
            }
        } else {
            $state = 400;
        }
        return $this->response->setJSON(json_decode($producto));
    }
    public function delete_producto()
    {
        $this->client->put('items/'.$this->request->getPost('producto_id'), ['json' => ['status'=>'paused'], 'headers' => $this->haeders, 'http_errors' => false])->getBody();
        $producto = json_decode($this->client->put('items/'.$this->request->getPost('producto_id'), ['json' => ['status'=>'closed'], 'headers' => $this->haeders, 'http_errors' => false])->getBody());
        $this->model->delete($this->request->getPost('producto_id'));
        return $this->response->setJSON([$producto, 'status'=> 'eliminado']);
        
    }
}
