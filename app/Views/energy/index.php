<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voltify - Energy Tracker CI4</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen pb-12">
<?php
// Ensure view variables have safe defaults to avoid undefined variable errors
$devices = isset($devices) ? $devices : [];
$dangerousDevices = isset($dangerousDevices) ? $dangerousDevices : [];
$totalCost = isset($totalCost) ? $totalCost : 0;
$totalKwh = isset($totalKwh) ? $totalKwh : 0;
$budget = isset($budget) ? $budget : 0;
$budgetPercent = isset($budgetPercent) ? $budgetPercent : 0;
?>

  <!-- Header -->
  <header class="bg-emerald-600 text-white py-4 px-6 shadow-md sticky top-0 z-50 flex justify-between items-center">
    <div>
      <h1 class="text-xl font-bold flex items-center gap-2">
        <i class="fa-solid fa-bolt text-amber-300"></i> Voltify (CI4)
      </h1>
      <p class="text-xs text-emerald-100">Smart Energy & Cost Monitor</p>
    </div>
    
    <!-- Tombol Cepat Keluar Rumah -->
    <a href="<?= base_url('energy/autocutoff') ?>" onclick="return confirm('Aktifkan Mode Keluar Rumah? Seluruh perangkat berdaya besar (>=150W) akan otomatis dimatikan.')" class="bg-emerald-800 hover:bg-emerald-900 text-xs px-3 py-2 rounded-lg font-semibold border border-emerald-400 transition flex items-center gap-1.5 shadow-sm">
      <i class="fa-solid fa-person-walking-arrow-right"></i> Mode Keluar
    </a>
  </header>

  <main class="max-w-md mx-auto p-4 space-y-4">
  <main class="max-w-md mx-auto p-4 space-y-4">

    <!-- Card 1: Estimasi Tagihan & Anggaran -->
    <section class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
      <div class="flex justify-between items-center mb-2">
        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Estimasi Tagihan Bulanan</span>
        <span class="text-xs px-2 py-1 rounded bg-slate-100 font-mono text-slate-600">R-1 1.300VA</span>
      </div>
      <div class="text-3xl font-extrabold text-slate-900 mb-1">
        Rp<?= number_format($totalCost, 0, ',', '.') ?>
      </div>
      <p class="text-xs text-slate-500 mb-4"><?= number_format($totalKwh, 1, ',', '.') ?> kWh / bulan</p>

      <div class="space-y-1">
        <div class="flex justify-between text-xs font-medium">
          <span class="text-slate-600">Batas Anggaran: <b>Rp<?= number_format($budget, 0, ',', '.') ?></b></span>
          <span class="font-bold <?= $budgetPercent >= 80 ? 'text-red-600' : 'text-emerald-600' ?>">
            <?= $budgetPercent ?>%
          </span>
        </div>
        <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
          <div class="<?= $budgetPercent >= 80 ? 'bg-red-500' : ($budgetPercent >= 60 ? 'bg-amber-500' : 'bg-emerald-500') ?> h-full transition-all duration-300" 
               style="width: <?= $budgetPercent ?>%"></div>
        </div>
      </div>
    </section>

    <!-- Banner Peringatan Perangkat Daya Besar yang Masih Menyala -->
    <?php if (!empty($dangerousDevices)): ?>
      <div class="bg-amber-50 border-l-4 border-amber-500 p-3 rounded-lg flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg mt-0.5"></i>
        <div>
          <p class="text-xs font-bold text-amber-800">Peringatan Pemborosan!</p>
          <p class="text-xs text-amber-700">
            Perangkat berdaya tinggi masih MENYALA: <b><?= esc(implode(', ', $dangerousDevices)) ?></b>. Matikan jika tidak dipakai untuk hemat biaya!
          </p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Card 2: Form Tambah Perangkat -->
    <section class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
      <h2 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
        <i class="fa-solid fa-plus-circle text-emerald-600"></i> Tambah Perangkat Baru
      </h2>
      <form action="<?= base_url('energy/add') ?>" method="post" class="space-y-3">
        <?= csrf_field() ?>
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Nama Perangkat</label>
          <input type="text" name="name" required placeholder="Contoh: Rice Cooker" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Daya (Watt)</label>
            <input type="number" name="watt" required placeholder="395" min="1" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
          </div>
          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Jam Pakai / Hari</label>
            <input type="number" name="daily_hours" required placeholder="6" min="1" max="24" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
          </div>
        </div>
        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold py-2.5 rounded-lg transition">
          Simpan ke Database
        </button>
      </form>
    </section>

    <!-- Card 3: Daftar Perangkat -->
    <section class="space-y-2">
      <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Daftar Perangkat Terpasang</h2>
      <div class="space-y-2">
        <?php if (empty($devices)): ?>
          <p class="text-xs text-slate-400 text-center py-4">Belum ada perangkat di database.</p>
        <?php endif; ?>

        <?php foreach ($devices as $device): ?>
          <?php 
            $itemKwh = (($device['watt'] * $device['daily_hours']) / 1000) * 30;
            $itemCost = $itemKwh * 1444.70;
          ?>
          <div class="p-4 rounded-xl border flex items-center justify-between <?= $device['is_turned_on'] ? 'bg-white border-slate-200' : 'bg-slate-50 border-dashed border-slate-300 opacity-60' ?>">
            <div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-slate-800"><?= esc($device['name']) ?></span>
                <?php if ($device['watt'] >= 150): ?>
                  <span class="text-[10px] px-1.5 py-0.5 rounded bg-red-100 text-red-600 font-bold">Daya Besar</span>
                <?php endif; ?>
              </div>
              <p class="text-xs text-slate-400">
                <?= $device['watt'] ?> W • <?= $device['daily_hours'] ?> jam/hari • Est. Rp<?= number_format($itemCost, 0, ',', '.') ?>/bln
              </p>
            </div>
            <div class="flex items-center gap-2">
              <!-- Tombol Sakelar On/Off -->
              <a href="<?= base_url('energy/toggle/' . $device['id']) ?>" class="text-xs px-3 py-1.5 rounded-lg border font-semibold transition <?= $device['is_turned_on'] ? 'bg-emerald-50 text-emerald-700 border-emerald-300 hover:bg-emerald-100' : 'bg-slate-200 text-slate-600 border-slate-300 hover:bg-slate-300' ?>">
                <?= $device['is_turned_on'] ? 'ON' : 'OFF' ?>
              </a>
              <!-- Tombol Hapus -->
              <a href="<?= base_url('energy/delete/' . $device['id']) ?>" onclick="return confirm('Hapus perangkat ini?')" class="text-slate-400 hover:text-red-500 p-2 transition">
                <i class="fa-solid fa-trash-can text-xs"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </main>
</body>
</html>