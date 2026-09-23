<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(session()->get('role') === 'admin' ? 'admin' : 'dashboard');
        }
        return view('auth/login');
    }

    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id'   => $user['id'],
                'name'      => $user['name'],
                'email'     => $user['email'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);

            return redirect()->to($user['role'] === 'admin' ? 'admin' : 'dashboard');
        }

        session()->setFlashdata('error', 'Email atau password salah!');
        return redirect()->to('login')->withInput();
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('dashboard');
        }
        return view('auth/register');
    }

    public function processRegister()
    {
        $email = $this->request->getPost('email');

        if ($this->userModel->where('email', $email)->first()) {
            session()->setFlashdata('error', 'Email sudah terdaftar!');
            return redirect()->to('register')->withInput();
        }

        $this->userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $email,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => 'user'
        ]);

        session()->setFlashdata('success', 'Pendaftaran berhasil! Silakan masuk.');
        return redirect()->to('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function seed()
    {
        $passwordHash = password_hash('admin123', PASSWORD_BCRYPT);

        // 1. Reset / Daftarkan Admin
        $admin = $this->userModel->where('email', 'admin@voltify.com')->first();
        if ($admin) {
            $this->userModel->update($admin['id'], [
                'password' => $passwordHash,
                'role'     => 'admin'
            ]);
        } else {
            $this->userModel->insert([
                'name'     => 'Super Admin',
                'email'    => 'admin@voltify.com',
                'password' => $passwordHash,
                'role'     => 'admin'
            ]);
        }

        // 2. Reset / Daftarkan User Demo
        $user = $this->userModel->where('email', 'user@voltify.com')->first();
        if ($user) {
            $this->userModel->update($user['id'], [
                'password' => $passwordHash,
                'role'     => 'user'
            ]);
        } else {
            $this->userModel->insert([
                'name'     => 'User Demo',
                'email'    => 'user@voltify.com',
                'password' => $passwordHash,
                'role'     => 'user'
            ]);
        }

        session()->setFlashdata('success', 'Akun Demo BERHASIL di-reset! Silakan login dengan password: admin123');
        return redirect()->to('login');
    }
}