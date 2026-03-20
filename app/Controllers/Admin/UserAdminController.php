<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UserAdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $users = $this->db->query('
            SELECT users.*, roles.label as role_label
            FROM users
            LEFT JOIN roles ON roles.id = users.role_id
            ORDER BY users.name ASC
        ')->getResultArray();

        $rolesRaw = $this->db->table('roles')->get()->getResultArray();
        $roles = [];
            foreach ($rolesRaw as $r) {
        $roles[$r['id']] = $r['label'];
}

        return view('admin/users/index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function assignRole($id)
    {
        // Block admin from changing their own role
        if ($id == session('user')['id']) {
            return redirect()->to('/admin/users')
                ->with('error', 'You cannot change your own role.');
        }

        $this->db->table('users')->update(
            ['role_id' => $this->request->getPost('role_id')],
            ['id'      => $id]
        );

        return redirect()->to('/admin/users')
            ->with('success', 'Role assigned successfully.');
    }
}