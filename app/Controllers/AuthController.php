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
        $model    = new UserModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Check if email exists in database
        $user = $model->findByEmail($email);

        // Verify password hash — don't reveal which field is wrong
        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->with('error', 'Invalid credentials. Please try again.');
        }

        // Store user data in session
        session()->set([
            'isLoggedIn' => true,
            'userId'     => $user['id'],
            'userName'   => $user['name'],
        ]);

        return redirect()->to('/dashboard');
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

        // Validate inputs — repopulate form and show errors on failure
        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();

        // Hash password using PASSWORD_BCRYPT before storing
        $model->insert([
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash(
                                $this->request->getPost('password'),
                                PASSWORD_BCRYPT
                            ),
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
}