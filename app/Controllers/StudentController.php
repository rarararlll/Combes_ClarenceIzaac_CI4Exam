<?php

namespace App\Controllers;

class StudentController extends BaseController
{
    public function dashboard()
    {
        $db   = \Config\Database::connect();
        $user = $db->table('users')
                   ->where('id', session('user')['id'])
                   ->get()
                   ->getRowArray();

        // Merge session role into user data
        $user['role'] = session('user')['role'];

        return view('student/dashboard', ['user' => $user]);
    }
}