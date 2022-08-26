<?php

namespace App\Models;

use CodeIgniter\Model;

class Producto extends Model
{
    protected $table            = 'productos';
    protected $allowedFields    = ['producto_id', 'category_id', 'title', 'price', 'status', 'start_time', 'stop_time', 'condition', 'permalink', 'pictures', 'thumbnail', 'city', 'marca', 'available_quantity', 'attributes'];
}
