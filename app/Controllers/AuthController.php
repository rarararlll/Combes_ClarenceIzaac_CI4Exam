<?php
namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController
{
    // Show login page — redirect to dashboard if already logged in
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login');
    }

    // Handle login form submission
    public function loginPost()
{
    $db       = \Config\Database::connect();
    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // JOIN roles table to get role name alongside user data
    $user = $db->table('users')
               ->select('users.*, roles.name AS role_name')
               ->join('roles', 'roles.id = users.role_id', 'left')
               ->where('users.email', $email)
               ->get()
               ->getRowArray();

    // Verify password hash — don't reveal which field is wrong
    if (! $user || ! password_verify($password, $user['password'])) {
        return redirect()->back()
            ->with('error', 'Invalid credentials. Please try again.');
    }

    // Store user data in session including role
    session()->set([
        'isLoggedIn' => true,
        'userId'     => $user['id'],
        'userName'   => $user['name'],
        'user'       => [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role_name'], // 'admin', 'teacher', 'student'
        ],
    ]);

    // Redirect each role to the correct starting page
    $role = $user['role_name'];
    return match($role) {
    'admin'   => redirect()->to(base_url('dashboard')),
    'teacher' => redirect()->to(base_url('dashboard')),
    'student' => redirect()->to(base_url('student/dashboard')),
    default   => redirect()->to(base_url('dashboard')),
};
}

    // Show registration page — redirect to dashboard if already logged in
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register');
    }

    // Handle registration form submission
    public function registerPost()
{
    $rules = [
        'name'             => 'required|min_length[3]',
        'email'            => 'required|valid_email|is_unique[users.email]',
        'password'         => 'required|min_length[6]',
        'confirm_password' => 'required|matches[password]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $db     = \Config\Database::connect();
    $model  = new \App\Models\UserModel();

    // Get the student role ID automatically
    $studentRole = $db->table('roles')->where('name', 'student')->get()->getRowArray();
    $roleId      = $studentRole ? $studentRole['id'] : null;

    $model->insert([
        'name'       => $this->request->getPost('name'),
        'email'      => $this->request->getPost('email'),
        'password'   => password_hash(
                            $this->request->getPost('password'),
                            PASSWORD_BCRYPT
                        ),
        'role_id'    => $roleId,
        'created_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to(base_url('login'))
         ->with('success', 'Registration successful! Please log in.');
}

    // Logout — destroy session and redirect to login
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')
            ->with('success', 'You have been logged out.');
    }

    // Show 403 unauthorized page
public function unauthorized()
{
    return view('errors/unauthorized');
}
}