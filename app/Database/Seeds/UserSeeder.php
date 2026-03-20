<?php

// app/Database/Seeds/UserSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * UserSeeder
 *
 * Inserts 4 demo user accounts — one per role — for testing RBAC.
 * All accounts use the password: Password1
 *
 * Run with:  php spark db:seed UserSeeder
 *
 * ┌─────────────────────────┬──────────────────────────┬────────────┐
 * │ Role                    │ Email                    │ Password   │
 * ├─────────────────────────┼──────────────────────────┼────────────┤
 * │ Administrator           │ admin@school.edu         │ Password1  │
 * │ Teacher                 │ teacher@school.edu       │ Password1  │
 * │ Student                 │ student@school.edu       │ Password1  │
 * │ Coordinator (challenge) │ coordinator@school.edu   │ Password1  │
 * └─────────────────────────┴──────────────────────────┴────────────┘
 *
 * IMPORTANT: Run RoleSeeder FIRST so role IDs exist before this seeder
 * tries to look them up. Use MainSeeder (which calls both in order) to
 * avoid errors.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        // Look up role IDs dynamically — avoids hard-coded IDs that
        // may differ if the seeder is run on a fresh vs. existing DB
        $getRoleId = function (string $slug): ?int {
            $row = $this->db->table('roles')->where('name', $slug)->get()->getRowArray();
            return $row ? (int) $row['id'] : null;
        };

        // BCrypt hash of "Password1"
        // Generated with: password_hash('Password1', PASSWORD_BCRYPT)
        $hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.';

        $users = [
            [
                'name'       => 'Admin User',
                'email'      => 'admin@school.edu',
                'password'   => $hash,
                'role_id'    => $getRoleId('admin'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Teacher Cruz',
                'email'      => 'teacher@school.edu',
                'password'   => $hash,
                'role_id'    => $getRoleId('teacher'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Student Reyes',
                'email'      => 'student@school.edu',
                'password'   => $hash,
                'role_id'    => $getRoleId('student'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Coordinator Bautista',
                'email'      => 'coordinator@school.edu',
                'password'   => $hash,
                'role_id'    => $getRoleId('coordinator'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
