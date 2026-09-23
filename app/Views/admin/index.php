<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Super Portal — Voltify</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clay: { 50: '#FDF8F5', 100: '#F9ECE5', 500: '#D96B43', 600: '#C85A32', 700: '#A74623', 800: '#7F3318' },
            linen: '#FAF7F2',
            sand: '#EDE5D8',
            espresso: '#1E1815'
          },
          fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
        }
      }
    }
  </script>
</head>
<body class="bg-linen text-espresso min-h-screen pb-16 selection:bg-clay-100 selection:text-clay-700">

  <!-- Header Admin -->
  <header class="bg-white border-b border-sand sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-espresso text-white flex items-center justify-center font-bold text-sm shadow-sm">
          <i class="fa-solid fa-shield-halved text-clay-500"></i>
        </span>
        <div>
          <h1 class="text-sm font-extrabold text-espresso leading-none">Voltify Admin Portal</h1>
          <p class="text-[11px] text-stone-400 mt-0.5">Pusat Kendali Pengguna & Audit Daya</p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= site_url('dashboard') ?>" class="px-4 py-2 rounded-xl bg-linen border border-sand hover:border-clay-600 text-xs font-bold text-stone-700 transition">
          Lihat App Pengguna
        </a>
        <a href="<?= site_url('logout') ?>" class="px-4 py-2 rounded-xl bg-espresso hover:bg-stone-800 text-white text-xs font-bold transition">
          Keluar
        </a>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 pt-8 space-y-8">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="p-4 rounded-2xl bg-clay-600 text-white text-xs font-semibold shadow-md flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="p-4 rounded-2xl bg-red-50 text-red-700 border border-red-200 text-xs font-semibold flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <!-- Metric Cards (Tema Warm Earth Tone) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="p-6 rounded-3xl bg-white border border-sand shadow-sm">
        <span class="text-xs uppercase font-bold tracking-widest text-stone-400">Total User</span>
        <h3 class="text-3xl font-extrabold text-espresso mt-2"><?= $totalUsers ?></h3>
        <p class="text-[11px] text-clay-600 font-semibold mt-1"><i class="fa-solid fa-users"></i> Terdaftar di database</p>
      </div>

      <div class="p-6 rounded-3xl bg-white border border-sand shadow-sm">
        <span class="text-xs uppercase font-bold tracking-widest text-stone-400">Total Perangkat</span>
        <h3 class="text-3xl font-extrabold text-espresso mt-2"><?= $totalDevices ?></h3>
        <p class="text-[11px] text-stone-500 font-semibold mt-1">Seluruh rumah tangga</p>
      </div>

      <div class="p-6 rounded-3xl bg-white border border-sand shadow-sm">
        <span class="text-xs uppercase font-bold tracking-widest text-stone-400">Konsumsi Global</span>
        <h3 class="text-3xl font-extrabold text-clay-600 mt-2"><?= number_format($totalGlobalKwh, 1, ',', '.') ?></h3>
        <p class="text-[11px] text-stone-500 font-semibold mt-1">kWh terpantau aktif</p>
      </div>

      <div class="p-6 rounded-3xl bg-white border border-sand shadow-sm">
        <span class="text-xs uppercase font-bold tracking-widest text-stone-400">Total Nilai Tagihan</span>
        <h3 class="text-3xl font-extrabold text-espresso mt-2">Rp<?= number_format($totalGlobalCost, 0, ',', '.') ?></h3>
        <p class="text-[11px] text-stone-500 font-semibold mt-1">Estimasi kumulatif PLN</p>
      </div>
    </div>

    <!-- TABEL 1: Kelola Pengguna (Admin Bisa Ubah Role & Hapus) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm space-y-4">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-lg font-extrabold text-espresso">Manajemen Akun Terdaftar</h2>
          <p class="text-xs text-stone-400 mt-0.5">Kelola hak akses dan akun pengguna sistem</p>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
          <thead class="text-stone-400 uppercase tracking-wider border-b border-sand font-bold">
            <tr>
              <th class="py-3 px-4">Nama</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Role Saat Ini</th>
              <th class="py-3 px-4 text-center">Tindakan Admin</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-sand text-stone-600">
            <?php foreach ($users as $u): ?>
              <tr>
                <td class="py-3.5 px-4 font-bold text-espresso"><?= esc($u['name']) ?></td>
                <td class="py-3.5 px-4 font-mono"><?= esc($u['email']) ?></td>
                <td class="py-3.5 px-4">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase <?= $u['role'] === 'admin' ? 'bg-clay-100 text-clay-700 border border-clay-200' : 'bg-sand/70 text-stone-700' ?>">
                    <?= $u['role'] ?>
                  </span>
                </td>
                <td class="py-3.5 px-4 text-center space-x-2">
                  <!-- Ganti Role -->
                  <a href="<?= site_url('admin/toggle-role/' . $u['id']) ?>" class="px-3 py-1.5 rounded-lg bg-linen border border-sand hover:border-clay-600 text-[11px] font-bold text-espresso transition">
                    Ubah Role
                  </a>
                  <!-- Hapus User -->
                  <?php if ($u['id'] != session()->get('user_id')): ?>
                    <a href="<?= site_url('admin/delete-user/' . $u['id']) ?>" onclick="return confirm('Hapus user ini beserta semua perangkatnya?')" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-[11px] font-bold transition">
                      Hapus
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- TABEL 2: Audit Perangkat Global (Fitur Tambahan Admin) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm space-y-4">
      <div>
        <h2 class="text-lg font-extrabold text-espresso">Audit Seluruh Perangkat Listrik</h2>
        <p class="text-xs text-stone-400 mt-0.5">Admin dapat mengontrol status perangkat yang lupa dimatikan oleh user</p>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
          <thead class="text-stone-400 uppercase tracking-wider border-b border-sand font-bold">
            <tr>
              <th class="py-3 px-4">Pemilik</th>
              <th class="py-3 px-4">Nama Perangkat</th>
              <th class="py-3 px-4">Daya</th>
              <th class="py-3 px-4">Durasi Harian</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4 text-center">Kontrol Daya</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-sand text-stone-600">
            <?php foreach ($devices as $d): ?>
              <tr>
                <td class="py-3 px-4 font-semibold text-espresso"><?= esc($d['user_name'] ?? 'User #'.$d['user_id']) ?></td>
                <td class="py-3 px-4 font-bold text-stone-800"><?= esc($d['name']) ?></td>
                <td class="py-3 px-4 font-mono"><?= $d['watt'] ?> W</td>
                <td class="py-3 px-4"><?= $d['daily_hours'] ?> Jam / hari</td>
                <td class="py-3 px-4">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $d['is_turned_on'] ? 'bg-clay-100 text-clay-700' : 'bg-stone-200 text-stone-500' ?>">
                    <?= $d['is_turned_on'] ? 'MENYALA (ON)' : 'MATI (OFF)' ?>
                  </span>
                </td>
                <td class="py-3 px-4 text-center space-x-1">
                  <a href="<?= site_url('energy/toggle/' . $d['id']) ?>" class="px-2.5 py-1 rounded bg-linen border border-sand hover:border-clay-600 font-bold text-[11px] text-espresso">
                    Switch ON/OFF
                  </a>
                  <a href="<?= site_url('energy/delete/' . $d['id']) ?>" onclick="return confirm('Hapus perangkat ini dari database?')" class="px-2.5 py-1 rounded bg-red-50 hover:bg-red-100 font-bold text-[11px] text-red-600">
                    Hapus
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</body>
</html>