<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'ADMIN'
        ];
        $this->db->table('roles')->insert($data);
      

    }
}
