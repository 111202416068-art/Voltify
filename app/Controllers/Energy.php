<?php

namespace App\Controllers;

use App\Models\DeviceModel;
use App\Models\UserModel;

class Energy extends BaseController
{
    protected $deviceModel;
    protected $userModel;
    protected $tariffPerKwh = 1444.70;

    public function __construct()
    {
        $this->deviceModel = new DeviceModel();
        $this->userModel   = new UserModel();
    }

    public function index()
    {
        return view('landing');
    }

    // --- DASHBOARD USER ---
    public function dashboard()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        $budget = session()->get('budget') ?? 250000;

        $devices = $this->deviceModel->where('user_id', $userId)->findAll() ?? [];

        $totalMonthlyKwh = 0;
        $dangerousDevices = [];

        foreach ($devices as $d) {
            if ($d['is_turned_on'] == 1) {
                $dailyKwh = ($d['watt'] * $d['daily_hours']) / 1000;
                $monthlyKwh = $dailyKwh * 30;
                $totalMonthlyKwh += $monthlyKwh;

                if ($d['watt'] >= 150) {
                    $dangerousDevices[] = $d['name'];
                }
            }
        }

        $totalCost = $totalMonthlyKwh * $this->tariffPerKwh;
        $budgetPercent = ($budget > 0) ? min(round(($totalCost / $budget) * 100), 100) : 0;

   // Hitung berapa perangkat berat yang sedang mati (ter-cut off)
        $hasCutOffDevices = count(array_filter($devices, fn($d) => $d['watt'] >= 150 && $d['is_turned_on'] == 0)) > 0;

        $data = [
            'user'              => $user,
            'devices'           => $devices,
            'totalCost'         => $totalCost,
            'totalKwh'          => $totalMonthlyKwh,
            'budget'            => $budget,
            'budgetPercent'     => $budgetPercent,
            'dangerousDevices'  => $dangerousDevices,
            'hasCutOffDevices'  => $hasCutOffDevices
        ];

        return view('energy/dashboard', $data);
    }

    // --- PENGATURAN PROFIL USER ---
    public function profile()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        $budget = session()->get('budget') ?? 250000;

        return view('energy/profile', ['user' => $user, 'budget' => $budget]);
    }

    public function updateProfile()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $budget = (int) $this->request->getPost('budget');
        $newPassword = $this->request->getPost('new_password');

        $updateData = [
            'name'  => $name,
            'email' => $email
        ];

        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $this->userModel->update($userId, $updateData);
        session()->set([
            'name'   => $name,
            'email'  => $email,
            'budget' => $budget
        ]);

        session()->setFlashdata('success', 'Profil & preferensi berhasil diperbarui!');
        return redirect()->to('profile');
    }

    public function deleteAccount()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        // Hapus perangkat milik user terlebih dahulu
        $this->deviceModel->where('user_id', $userId)->delete();
        // Hapus user
        $this->userModel->delete($userId);

        session()->destroy();
        return redirect()->to('/')->with('success', 'Akun kamu telah berhasil dihapus permanen.');
    }

    // --- MANAJEMEN PERANGKAT USER ---
    public function add()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $this->deviceModel->insert([
            'user_id'      => session()->get('user_id'),
            'name'         => $this->request->getPost('name'),
            'watt'         => $this->request->getPost('watt'),
            'daily_hours'  => $this->request->getPost('daily_hours'),
            'is_turned_on' => 1
        ]);

        return redirect()->to('dashboard');
    }

    public function toggle($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        $device = $this->deviceModel->find($id);

        // Jika bukan admin dan bukan pemilik perangkat, tolak
        if (session()->get('role') !== 'admin' && $device['user_id'] != $userId) {
            return redirect()->to('dashboard');
        }

        if ($device) {
            $newStatus = ($device['is_turned_on'] == 1) ? 0 : 1;
            $this->deviceModel->update($id, ['is_turned_on' => $newStatus]);
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        $device = $this->deviceModel->find($id);

        if (session()->get('role') !== 'admin' && $device['user_id'] != $userId) {
            return redirect()->to('dashboard');
        }

        $this->deviceModel->delete($id);
        return redirect()->back();
    }

    public function autoCutOff()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');
        $heavyDevices = $this->deviceModel
            ->where('user_id', $userId)
            ->where('watt >=', 150)
            ->where('is_turned_on', 1)
            ->findAll();

        $count = count($heavyDevices);
        $savedKwh = 0;

        foreach ($heavyDevices as $d) {
            $savedKwh += (($d['watt'] * $d['daily_hours']) / 1000) * 30;
            $this->deviceModel->update($d['id'], ['is_turned_on' => 0]);
        }

        $savedRupiah = $savedKwh * $this->tariffPerKwh;

        if ($count > 0) {
            session()->setFlashdata('cutoff_success', "Auto Cut-Off berhasil! {$count} perangkat dimatikan. Potensi hemat Rp" . number_format($savedRupiah, 0, ',', '.') . "/bln.");
        } else {
            session()->setFlashdata('cutoff_info', "Semua perangkat berdaya tinggi sudah dalam kondisi non-aktif.");
        }

        return redirect()->to('dashboard');
    }

    // Fitur Menyalakan Kembali Perangkat (Mode Tiba di Rumah)
    public function restorePower()
    {
        if (!session()->get('logged_in')) return redirect()->to('login');

        $userId = session()->get('user_id');

        // Cari semua alat daya besar (>= 150W) milik user yang saat ini sedang MATI (0)
        $cutoffDevices = $this->deviceModel
            ->where('user_id', $userId)
            ->where('watt >=', 150)
            ->where('is_turned_on', 0)
            ->findAll();

        $count = count($cutoffDevices);

        foreach ($cutoffDevices as $d) {
            $this->deviceModel->update($d['id'], ['is_turned_on' => 1]);
        }

        if ($count > 0) {
            session()->setFlashdata('cutoff_success', "Daya dipulihkan! {$count} perangkat kembali menyala normal.");
        } else {
            session()->setFlashdata('cutoff_info', "Tidak ada perangkat terputus yang perlu dipulihkan.");
        }

        return redirect()->to('dashboard');
    }

    // --- DASHBOARD ADMIN ---
    public function admin()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('dashboard');
        }

        $allUsers = $this->userModel->findAll();
        $allDevices = $this->deviceModel
            ->select('devices.*, users.name as user_name, users.email as user_email')
            ->join('users', 'users.id = devices.user_id', 'left')
            ->findAll();

        $totalGlobalKwh = 0;
        foreach ($allDevices as $d) {
            if ($d['is_turned_on'] == 1) {
                $totalGlobalKwh += (($d['watt'] * $d['daily_hours']) / 1000) * 30;
            }
        }

        $data = [
            'users'           => $allUsers,
            'devices'         => $allDevices,
            'totalUsers'      => count($allUsers),
            'totalDevices'    => count($allDevices),
            'totalGlobalKwh'  => $totalGlobalKwh,
            'totalGlobalCost' => $totalGlobalKwh * $this->tariffPerKwh
        ];

        return view('admin/index', $data);
    }

    public function adminToggleRole($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') return redirect()->to('dashboard');

        $user = $this->userModel->find($id);
        if ($user) {
            $newRole = ($user['role'] === 'admin') ? 'user' : 'admin';
            $this->userModel->update($id, ['role' => $newRole]);
            session()->setFlashdata('success', "Role untuk {$user['name']} diubah menjadi " . strtoupper($newRole));
        }

        return redirect()->to('admin');
    }

    public function adminDeleteUser($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') return redirect()->to('dashboard');

        if ($id == session()->get('user_id')) {
            session()->setFlashdata('error', 'Tidak bisa menghapus akun admin yang sedang aktif!');
            return redirect()->to('admin');
        }

        $this->deviceModel->where('user_id', $id)->delete();
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'User dan semua datanya berhasil dihapus oleh Admin.');
        return redirect()->to('admin');
    }
}
