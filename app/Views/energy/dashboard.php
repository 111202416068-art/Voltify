<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Voltify</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen pb-16">

  <!-- Header Minimalis Elegan -->
  <header class="bg-white border-b border-slate-200/80 sticky top-0 z-50">
    <div class="max-w-4xl mx-auto px-4 py-3.5 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <a href="<?= base_url('/') ?>" class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">⚡</a>
        <div>
          <h1 class="text-sm font-bold text-slate-900 leading-none">Voltify Dashboard</h1>
          <p class="text-[11px] text-slate-400 mt-0.5">Halo, <?= esc(session()->get('name')) ?> 👋</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?= base_url('energy/autocutoff') ?>" onclick="return confirm('Aktifkan Auto Cut-Off? Semua perangkat daya besar (>=150W) akan dimatikan otomatis.')" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
          <i class="fa-solid fa-power-off"></i> Auto Cut-Off
        </a>
        <a href="<?= base_url('/logout') ?>" class="text-slate-400 hover:text-red-500 text-sm p-1.5 transition">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </a>
      </div>
    </div>
  </header>

  <main class="max-w-4xl mx-auto px-4 pt-6 space-y-6">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('cutoff_success')): ?>
      <div class="p-4 rounded-2xl bg-emerald-500 text-white text-xs font-semibold shadow-md flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-sm"></i>
        <?= session()->getFlashdata('cutoff_success') ?>
      </div>
    <?php endif; ?>

    <!-- Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      
      <!-- Card Estimasi Rupiah -->
      <div class="md:col-span-2 bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-xl shadow-slate-200">
        <div class="flex justify-between items-start mb-4">
          <div>
            <span class="text-xs uppercase font-bold tracking-wider text-slate-400">Estimasi Tagihan Bulan Ini</span>
            <h2 class="text-4xl font-extrabold mt-1 text-white">Rp<?= number_format($totalCost, 0, ',', '.') ?></h2>
          </div>
          <span class="text-[10px] px-2.5 py-1 rounded-full bg-white/10 text-emerald-300 font-mono">PLN R-1 1.300VA</span>
        </div>

        <div class="space-y-2 pt-2">
          <div class="flex justify-between text-xs text-slate-300">
            <span>Batas Anggaran: Rp<?= number_format($budget, 0, ',', '.') ?></span>
            <span class="font-bold <?= $budgetPercent >= 80 ? 'text-red-400' : 'text-emerald-400' ?>"><?= $budgetPercent ?>%</span>
          </div>
          <div class="w-full bg-white/10 h-2.5 rounded-full overflow-hidden">
            <div class="<?= $budgetPercent >= 80 ? 'bg-red-500' : 'bg-emerald-400' ?> h-full rounded-full transition-all" style="width: <?= $budgetPercent ?>%"></div>
          </div>
        </div>
      </div>

      <!-- Card Total Kwh -->
      <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
        <div>
          <span class="text-xs uppercase font-bold tracking-wider text-slate-400">Konsumsi Energi</span>
          <h3 class="text-3xl font-extrabold text-slate-900 mt-2"><?= number_format($totalKwh, 1, ',', '.') ?></h3>
          <p class="text-xs text-slate-500 mt-1">kWh / bulan</p>
        </div>
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
          <span class="text-slate-500">Perangkat Aktif</span>
          <span class="font-bold text-slate-800"><?= count(array_filter($devices, fn($d) => $d['is_turned_on'] == 1)) ?> / <?= count($devices) ?></span>
        </div>
      </div>

    </div>

    <!-- Alert Daya Besar -->
    <?php if (!empty($dangerousDevices)): ?>
      <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg mt-0.5"></i>
        <div class="flex-1">
          <h4 class="text-xs font-bold text-amber-900">Peringatan Pemborosan!</h4>
          <p class="text-xs text-amber-700 mt-0.5">Perangkat daya besar masih menyala: <b><?= esc(implode(', ', $dangerousDevices)) ?></b>.</p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Form Tambah & List Perangkat -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
      
      <!-- Kiri: Form Tambah -->
      <div class="md:col-span-5 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
          <i class="fa-solid fa-circle-plus text-emerald-600"></i> Daftarkan Perangkat
        </h3>
        <form action="<?= base_url('energy/add') ?>" method="post" class="space-y-3">
          <?= csrf_field() ?>
          <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Alat</label>
            <input type="text" name="name" required placeholder="Contoh: AC Kamar" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">Daya (Watt)</label>
              <input type="number" name="watt" required placeholder="350" min="1" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">Jam Pakai/Hari</label>
              <input type="number" name="daily_hours" required placeholder="8" min="1" max="24" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
          </div>
          <button type="submit" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
            Simpan Perangkat
          </button>
        </form>
      </div>

      <!-- Kanan: List Perangkat -->
      <div class="md:col-span-7 space-y-3">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 px-1">Perangkat di Rumah Kamu</h3>
        
        <?php if (empty($devices)): ?>
          <div class="p-8 text-center bg-white rounded-3xl border border-slate-200/80 text-xs text-slate-400">
            Belum ada data perangkat. Tambahkan di form sebelah kiri.
          </div>
        <?php endif; ?>

        <?php foreach ($devices as $d): ?>
          <?php $itemCost = ((($d['watt'] * $d['daily_hours']) / 1000) * 30) * 1444.70; ?>
          <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between <?= $d['is_turned_on'] ? '' : 'opacity-60 bg-slate-50' ?>">
            <div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-slate-800"><?= esc($d['name']) ?></span>
                <?php if ($d['watt'] >= 150): ?>
                  <span class="text-[9px] px-2 py-0.5 rounded-full bg-red-100 text-red-600 font-bold uppercase">Heavy</span>
                <?php endif; ?>
              </div>
              <p class="text-xs text-slate-400 mt-0.5">
                <?= $d['watt'] ?> W • <?= $d['daily_hours'] ?> jam • Est. Rp<?= number_format($itemCost, 0, ',', '.') ?>/bln
              </p>
            </div>
            <div class="flex items-center gap-2">
              <a href="<?= base_url('energy/toggle/' . $d['id']) ?>" class="px-3 py-1.5 rounded-xl text-xs font-bold transition <?= $d['is_turned_on'] ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' ?>">
                <?= $d['is_turned_on'] ? 'ON' : 'OFF' ?>
              </a>
              <a href="<?= base_url('energy/delete/' . $d['id']) ?>" onclick="return confirm('Hapus alat ini?')" class="text-slate-300 hover:text-red-500 p-1.5">
                <i class="fa-solid fa-trash-can text-xs"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>

  </main>
</body>
</html>