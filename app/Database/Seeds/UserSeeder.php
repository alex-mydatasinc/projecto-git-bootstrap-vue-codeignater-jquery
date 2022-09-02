<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'alex admin',
            'email'    => 'admin@gmail.com',
            'password' => password_hash(12345678, PASSWORD_DEFAULT),
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (name, email, password) VALUES(:name:, :email:, :password:)', $data);

        // Using Query Builder
        $this->db->table('users')->insert($data);
        $data = [
            'name' => 'alex user',
            'email'    => 'user@gmail.com',
            'password' => password_hash(12345678, PASSWORD_DEFAULT),
        ];
        $this->db->table('users')->insert($data);

        $this->call('RolesSeeder');
    }
}
