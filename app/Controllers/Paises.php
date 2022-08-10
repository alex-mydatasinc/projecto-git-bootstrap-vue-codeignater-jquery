<?php

namespace App\Controllers;

class Paises extends BaseController
{
    public function index()
    {
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://api.mercadolibre.com/',
        ]);
        $data['paises'] = json_decode($client->get('classified_locations/countries')->getBody());

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        return view('templates/header', $data)
            . view('paises/index')
            . view('templates/footer');
    }
}
