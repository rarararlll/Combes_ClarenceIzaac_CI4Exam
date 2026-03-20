<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RoleController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $roles = $this->db->query('
            SELECT roles.*, COUNT(users.id) as user_count
            FROM roles
            LEFT JOIN users ON users.role_id = roles.id
            GROUP BY roles.id
        ')->getResultArray();

        return view('admin/roles/index', ['roles' => $roles]);
    }

    public function create()
    {
        return view('admin/roles/create');
    }

    public function store()
    {
        $rules = [
            'name'  => 'required|min_length[2]|is_unique[roles.name]',
            'label' => 'required|min_length[2]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->db->table('roles')->insert([
            'name'        => $this->request->getPost('name'),
            'label'       => $this->request->getPost('label'),
            'description' => $this->request->getPost('description'),
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/roles')
            ->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->db->table('roles')->getWhere(['id' => $id])->getRowArray();
        if (! $role) {
            return redirect()->to('/admin/roles')->with('error', 'Role not found.');
        }
        return view('admin/roles/edit', ['role' => $role]);
    }

    public function update($id)
    {
        $role = $this->db->table('roles')->getWhere(['id' => $id])->getRowArray();

        $rules = [
            'label' => 'required|min_length[2]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'label'       => $this->request->getPost('label'),
            'description' => $this->request->getPost('description'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        // Only allow slug edit for non-core roles
        $coreRoles = ['admin', 'teacher', 'student'];
        if (! in_array($role['name'], $coreRoles)) {
            $data['name'] = $this->request->getPost('name');
        }

        $this->db->table('roles')->update($data, ['id' => $id]);

        return redirect()->to('/admin/roles')
            ->with('success', 'Role updated successfully.');
    }

    public function delete($id)
    {
        $role = $this->db->table('roles')->getWhere(['id' => $id])->getRowArray();

        if (! $role) {
            return redirect()->to('/admin/roles')->with('error', 'Role not found.');
        }

        if ($role['name'] === 'admin') {
            return redirect()->to('/admin/roles')
                ->with('error', 'Cannot delete the admin role.');
        }

        // Unassign users from this role before deleting
        $this->db->table('users')->update(['role_id' => null], ['role_id' => $id]);
        $this->db->table('roles')->delete(['id' => $id]);

        return redirect()->to('/admin/roles')
            ->with('success', 'Role deleted successfully.');
    }
}