<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Role;
class RolesSeeder extends Seeder
{
    protected $model;
    public function run()
    {
        // $model = new Role();
        $data = [
            'name' => 'ADMIN'
        ];
        $this->db->table('roles')->insert($data);
        $data = [
            'name' => 'USER'
        ];
        $this->db->table('roles')->insert($data);
        // $data = [
        //     'name' => 'COLABORADOR'
        // ];
        // $this->db->table('roles')->insert($data);
        $roles = [
            'user_id' => 1,
            'role_id' => 1
        ];
        $this->db->table('user_role')->insert($roles);
        $roles = [
            'user_id' => 2,
            'role_id' => 2
        ];
        $this->db->table('user_role')->insert($roles);
    }
}
