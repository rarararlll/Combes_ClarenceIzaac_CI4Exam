<?php

// app/Database/Migrations/2024-01-01-000002_AddRoleIdToUsers.php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: AddRoleIdToUsers
 *
 * Adds a role_id foreign key column to the existing 'users' table.
 * Defaults to NULL so any existing user rows are not broken.
 * The FK references roles(id) with ON DELETE SET NULL — if a role
 * is deleted, affected users are unassigned (role_id becomes NULL)
 * rather than being deleted themselves.
 *
 * Run with:  php spark migrate
 * Rollback:  php spark migrate:rollback
 */
class AddRoleIdToUsers extends Migration
{
    public function up(): void
    {
        // Add the role_id column
        $this->forge->addColumn('users', [
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,       // NULL = no role assigned yet
                'default'    => null,
                'after'      => 'email',    // places column after 'email'
            ],
        ]);

        // Add the foreign key constraint separately
        // ON DELETE SET NULL: deleting a role unassigns users, doesn't delete them
        $this->db->query('
            ALTER TABLE users
            ADD CONSTRAINT fk_users_role_id
            FOREIGN KEY (role_id)
            REFERENCES roles(id)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ');
    }

    public function down(): void
    {
        // Must drop FK constraint before dropping the column
        $this->db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_role_id');
        $this->forge->dropColumn('users', 'role_id');
    }
}
