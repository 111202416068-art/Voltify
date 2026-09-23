<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal — Voltify</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">

<?php
// Ensure view variables have safe defaults to prevent undefined variable errors
$totalUsers = $totalUsers ?? 0;
$totalDevices = $totalDevices ?? 0;
$totalGlobalKwh = $totalGlobalKwh ?? 0;
$totalGlobalCost = $totalGlobalCost ?? 0;
$users = $users ?? [];
?>

  <div class="max-w-6xl mx-auto p-6 space-y-8">
    
    <div class="flex justify-between items-center border-b border-slate-800 pb-6">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center font-bold text-white shadow-lg shadow-red-600/30">
          <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
          <h1 class="text-xl font-extrabold text-white">Voltify Super Admin</h1>
          <p class="text-xs text-slate-400">Master Monitoring & User Management</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?= base_url('/dashboard') ?>" class="text-xs px-3 py-2 rounded-xl bg-slate-800 text-slate-300 font-semibold hover:bg-slate-700">Preview User App</a>
        <a href="<?= base_url('/logout') ?>" class="text-xs px-3 py-2 rounded-xl bg-red-500/20 text-red-400 font-semibold hover:bg-red-500/30">Keluar</a>
      </div>
    </div>

    <!-- Admin Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pengguna</p>
        <h3 class="text-3xl font-extrabold mt-1 text-white"><?= $totalUsers ?></h3>
        <p class="text-[11px] text-emerald-400 mt-1"><i class="fa-solid fa-user-check"></i> Terdaftar aktif</p>
      </div>
      <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Perangkat</p>
        <h3 class="text-3xl font-extrabold mt-1 text-white"><?= $totalDevices ?></h3>
        <p class="text-[11px] text-slate-400 mt-1">Di seluruh database</p>
      </div>
      <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Konsumsi Global</p>
        <h3 class="text-3xl font-extrabold mt-1 text-emerald-400"><?= number_format($totalGlobalKwh, 1, ',', '.') ?></h3>
        <p class="text-[11px] text-slate-400 mt-1">kWh terpantau</p>
      </div>
      <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Beban Biaya</p>
        <h3 class="text-3xl font-extrabold mt-1 text-white">Rp<?= number_format($totalGlobalCost, 0, ',', '.') ?></h3>
        <p class="text-[11px] text-slate-400 mt-1">Estimasi agregat</p>
      </div>
    </div>

    <!-- Tabel User -->
    <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800">
      <h3 class="text-sm font-bold text-white mb-4">Daftar Akun Terdaftar</h3>
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
          <thead class="text-slate-400 uppercase tracking-wider border-b border-slate-800">
            <tr>
              <th class="py-3 px-4">Nama</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Role</th>
              <th class="py-3 px-4">Waktu Dibuat</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800 text-slate-300">
            <?php foreach ($users ?? [] as $u): ?>
              <tr>
                <td class="py-3 px-4 font-bold text-white"><?= esc($u['name']) ?></td>
                <td class="py-3 px-4 font-mono"><?= esc($u['email']) ?></td>
                <td class="py-3 px-4">
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $u['role'] === 'admin' ? 'bg-red-500/20 text-red-400' : 'bg-emerald-500/20 text-emerald-400' ?>">
                    <?= strtoupper($u['role']) ?>
                  </span>
                </td>
                <td class="py-3 px-4 text-slate-500"><?= $u['created_at'] ?? 'Baru saja' ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

</body>
</html>