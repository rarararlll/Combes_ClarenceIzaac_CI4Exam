<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MyNewUsers extends Seeder
{
    public function run()
    {
        // Choose your own easy password here
        $password = password_hash('123456', PASSWORD_BCRYPT);

        $data = [
            [
                'name'     => 'Admin',
                'email'    => 'izaac@admin.com',
                'password' => $password,
                'role_id'  => 1, // Admin
            ],
            [
                'name'     => 'Prof Teacher',
                'email'    => 'prof@teacher.com',
                'password' => $password,
                'role_id'  => 2, // Teacher
            ],
            [
                'name'     => 'Lead Coordinator',
                'email'    => 'lead@coord.com',
                'password' => $password,
                'role_id'  => 4, // Coordinator
            ],
        ];

        // This inserts them into your table
        $this->db->table('users')->insertBatch($data);
    }
}
