<?php

namespace App\Models/UserModel;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $allowedFields    = ['name', 'email', 'password'];
}
