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
        $name     = trim($this->request->getPost('name'));
        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        // Validasi input kosong
        if (empty($name) || empty($email) || empty($password)) {
            session()->setFlashdata('error', 'Semua kolom formulir wajib diisi!');
            return redirect()->to('register')->withInput();
        }

        // Cek apakah email sudah terdaftar
        $existing = $this->userModel->where('email', $email)->first();
        if ($existing) {
            session()->setFlashdata('error', 'Email sudah terdaftar! Silakan gunakan email lain atau langsung login.');
            return redirect()->to('register')->withInput();
        }

        // Enkripsi password & simpan
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->userModel->insert([
                'name'     => $name,
                'email'    => $email,
                'password' => $hashedPassword,
                'role'     => 'user'
            ]);

            session()->setFlashdata('success', 'Pendaftaran akun berhasil! Silakan masuk.');
            return redirect()->to('login');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal mendaftar: ' . $e->getMessage());
            return redirect()->to('register')->withInput();
        }
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
