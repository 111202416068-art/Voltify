<?php

namespace App\Controllers;

use App\Models\DeviceModel;
use App\Models\UserModel;

class Energy extends BaseController
{
    protected $deviceModel;
    protected $userModel;
    protected $tariffPerKwh  = 1444.70;
    protected $monthlyBudget = 250000;

    public function __construct()
    {
        $this->deviceModel = new DeviceModel();
        $this->userModel   = new UserModel();
    }

    // 1. Landing Page Estetis (Mirip SaaS Modern)
    public function index()
    {
        return view('landing');
    }

    // 2. Dashboard Pribadi User
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
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
        $budgetPercent = min(round(($totalCost / $this->monthlyBudget) * 100), 100);

        $data = [
            'devices'          => $devices,
            'totalCost'        => $totalCost,
            'totalKwh'         => $totalMonthlyKwh,
            'budget'           => $this->monthlyBudget,
            'budgetPercent'    => $budgetPercent,
            'dangerousDevices' => $dangerousDevices
        ];

        return view('energy/dashboard', $data);
    }

    // 3. Dashboard Khusus Admin
    public function admin()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $allUsers = $this->userModel->findAll();
        $allDevices = $this->deviceModel->findAll();

        $totalGlobalKwh = 0;
        foreach ($allDevices as $d) {
            if ($d['is_turned_on'] == 1) {
                $totalGlobalKwh += (($d['watt'] * $d['daily_hours']) / 1000) * 30;
            }
        }

        $data = [
            'users'          => $allUsers,
            'totalUsers'     => count($allUsers),
            'totalDevices'   => count($allDevices),
            'totalGlobalKwh' => $totalGlobalKwh,
            'totalGlobalCost'=> $totalGlobalKwh * $this->tariffPerKwh
        ];

        return view('admin/index', $data);
    }

    public function add()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

        $this->deviceModel->insert([
            'user_id'      => session()->get('user_id'),
            'name'         => $this->request->getPost('name'),
            'watt'         => $this->request->getPost('watt'),
            'daily_hours'  => $this->request->getPost('daily_hours'),
            'is_turned_on' => 1
        ]);

        return redirect()->to('/dashboard');
    }

    public function toggle($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

        $device = $this->deviceModel->where('user_id', session()->get('user_id'))->find($id);
        if ($device) {
            $newStatus = ($device['is_turned_on'] == 1) ? 0 : 1;
            $this->deviceModel->update($id, ['is_turned_on' => $newStatus]);
        }
        return redirect()->to('/dashboard');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

        $this->deviceModel->where('user_id', session()->get('user_id'))->delete($id);
        return redirect()->to('/dashboard');
    }

    public function autoCutOff()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

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
            session()->setFlashdata('cutoff_success', "Auto Cut-Off berhasil! {$count} perangkat dimatikan. Hemat Rp" . number_format($savedRupiah, 0, ',', '.') . "/bln.");
        } else {
            session()->setFlashdata('cutoff_info', "Semua perangkat berdaya besar sudah mati.");
        }

        return redirect()->to('/dashboard');
    }
}