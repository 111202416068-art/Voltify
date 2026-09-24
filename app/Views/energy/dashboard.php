<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna — Voltify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clay: {
                            50: '#FDF8F5',
                            100: '#F9ECE5',
                            500: '#D96B43',
                            600: '#C85A32',
                            700: '#A74623'
                        },
                        linen: '#FAF7F2',
                        sand: '#EDE5D8',
                        espresso: '#1E1815'
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-linen text-espresso min-h-screen pb-16 selection:bg-clay-100 selection:text-clay-700">

    <!-- Header Rapi & Presisi -->
    <header class="bg-white border-b border-sand sticky top-0 z-50 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('/') ?>" class="w-10 h-10 rounded-2xl bg-clay-600 text-white flex items-center justify-center text-sm shadow-md shadow-clay-600/25 transition hover:scale-105">
                    <i class="fa-solid fa-leaf"></i>
                </a>
                <div>
                    <h1 class="text-sm font-extrabold text-espresso leading-snug">Voltify Dashboard</h1>
                    <p class="text-[11px] text-stone-400">Halo, <?= esc(session()->get('name')) ?> 👋</p>
                </div>
            </div>

            <!-- Grup Tombol Aksi Kanan -->
            <div class="flex items-center gap-2.5">
                <?php if (!empty($dangerousDevices)): ?>
                    <a href="<?= site_url('energy/autocutoff') ?>" onclick="return confirm('Aktifkan Mode Keluar? Semua perangkat daya besar (>=150W) akan dimatikan otomatis.')" class="px-4 py-2 rounded-xl bg-clay-600 hover:bg-clay-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-md shadow-clay-600/20">
                        <i class="fa-solid fa-power-off text-[11px]"></i>
                        <span>Auto Cut-Off</span>
                    </a>
                <?php elseif (!empty($hasCutOffDevices) && $hasCutOffDevices): ?>
                    <a href="<?= site_url('energy/restore') ?>" onclick="return confirm('Pulihkan daya perangkat kembali normal?')" class="px-4 py-2 rounded-xl bg-stone-800 hover:bg-stone-900 text-white text-xs font-bold transition flex items-center gap-2 shadow-md">
                        <i class="fa-solid fa-plug-circle-bolt text-clay-400 text-[11px]"></i>
                        <span>Pulihkan Daya</span>
                    </a>
                <?php endif; ?>

                <div class="h-6 w-px bg-sand mx-1"></div>

                <a href="<?= site_url('profile') ?>" title="Pengaturan Akun" class="w-9 h-9 rounded-xl bg-linen border border-sand hover:border-clay-600 hover:bg-white text-stone-600 hover:text-clay-600 flex items-center justify-center text-xs font-bold transition shadow-sm">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="<?= site_url('logout') ?>" title="Keluar dari Akun" class="w-9 h-9 rounded-xl bg-linen border border-sand hover:bg-red-50 hover:border-red-200 hover:text-red-600 text-stone-400 flex items-center justify-center text-xs transition shadow-sm">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 pt-6 space-y-6">

        <!-- Flash Toast Notification (Auto Dismiss 3 Detik) -->
        <?php if (session()->getFlashdata('cutoff_success')): ?>
            <div id="flashToast" class="p-4 rounded-2xl bg-clay-600 text-white text-xs font-semibold shadow-lg shadow-clay-600/25 flex items-center justify-between transition-all duration-500 transform">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span><?= session()->getFlashdata('cutoff_success') ?></span>
                </div>
                <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white text-base leading-none p-1 transition">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('cutoff_info')): ?>
            <div id="flashToast" class="p-4 rounded-2xl bg-white border border-sand text-stone-700 text-xs font-semibold shadow-sm flex items-center justify-between transition-all duration-500 transform">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-info text-clay-600 text-sm"></i>
                    <span><?= session()->getFlashdata('cutoff_info') ?></span>
                </div>
                <button type="button" onclick="closeToast()" class="text-stone-400 hover:text-stone-700 text-base leading-none p-1 transition">&times;</button>
            </div>
        <?php endif; ?>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            <div class="md:col-span-8 bg-gradient-to-br from-espresso via-stone-900 to-clay-800 text-white rounded-3xl p-7 shadow-xl shadow-stone-300/40 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-widest text-clay-200">Estimasi Tagihan Bulan Ini</span>
                        <h2 class="text-4xl font-extrabold mt-1 text-white">Rp<?= number_format($totalCost, 0, ',', '.') ?></h2>
                    </div>
                    <span class="text-[11px] px-3 py-1 rounded-full bg-white/10 text-clay-100 font-mono font-bold">PLN R-1 1.300VA</span>
                </div>

                <div class="space-y-2 pt-2">
                    <div class="flex justify-between text-xs text-stone-300">
                        <span>Batas Anggaran: <b>Rp<?= number_format($budget, 0, ',', '.') ?></b></span>
                        <span class="font-bold <?= $budgetPercent >= 80 ? 'text-red-400' : 'text-clay-300' ?>"><?= $budgetPercent ?>%</span>
                    </div>
                    <div class="w-full bg-white/10 h-2.5 rounded-full overflow-hidden">
                        <div class="<?= $budgetPercent >= 80 ? 'bg-red-500' : 'bg-clay-500' ?> h-full rounded-full transition-all" style="width: <?= $budgetPercent ?>%"></div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-4 bg-white rounded-3xl p-7 border border-sand shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-xs uppercase font-bold tracking-widest text-stone-400">Konsumsi Energi</span>
                    <h3 class="text-3xl font-extrabold text-espresso mt-2"><?= number_format($totalKwh, 1, ',', '.') ?></h3>
                    <p class="text-xs text-stone-500 mt-1">kWh per bulan</p>
                </div>
                <div class="pt-4 border-t border-sand flex items-center justify-between text-xs">
                    <span class="text-stone-500">Perangkat Aktif</span>
                    <span class="font-bold text-clay-700 bg-clay-50 px-2.5 py-1 rounded-lg border border-clay-200">
                        <?= count(array_filter($devices, fn($d) => $d['is_turned_on'] == 1)) ?> / <?= count($devices) ?> ON
                    </span>
                </div>
            </div>
        </div>

        <!-- Peringatan Alat Daya Besar -->
        <?php if (!empty($dangerousDevices)): ?>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg mt-0.5"></i>
                <div class="flex-1">
                    <h4 class="text-xs font-bold text-amber-900">Perhatian: Alat Boros Masih Menyala!</h4>
                    <p class="text-xs text-amber-800 mt-0.5">Perangkat berdaya tinggi (≥ 150 Watt) aktif: <b><?= esc(implode(', ', $dangerousDevices)) ?></b>. Matikan lewat tombol Auto Cut-Off di atas untuk berhemat.</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form & Daftar Perangkat -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            <div class="md:col-span-5 bg-white rounded-3xl p-6 border border-sand shadow-sm">
                <h3 class="text-sm font-bold text-espresso mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-clay-100 text-clay-700 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    Daftarkan Perangkat Baru
                </h3>
                <form action="<?= site_url('energy/add') ?>" method="post" class="space-y-3">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1">Nama Alat</label>
                        <input type="text" name="name" required placeholder="Contoh: AC Kamar Tidur" class="w-full px-3.5 py-2.5 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1">Daya (Watt)</label>
                            <input type="number" name="watt" required placeholder="350" min="1" class="w-full px-3.5 py-2.5 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1">Jam/Hari</label>
                            <input type="number" name="daily_hours" required placeholder="8" min="1" max="24" class="w-full px-3.5 py-2.5 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl bg-espresso hover:bg-stone-800 text-white text-xs font-bold uppercase tracking-wider transition shadow-md">
                        Simpan Perangkat
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 px-1">Perangkat Terpasang di Rumah</h3>

                <?php if (empty($devices)): ?>
                    <div class="p-8 text-center bg-white rounded-3xl border border-sand text-xs text-stone-400">
                        Belum ada data perangkat. Tambahkan di form sebelah kiri.
                    </div>
                <?php endif; ?>

                <?php foreach ($devices as $d): ?>
                    <?php $itemCost = ((($d['watt'] * $d['daily_hours']) / 1000) * 30) * 1444.70; ?>
                    <div class="p-4 rounded-2xl bg-white border border-sand shadow-sm flex items-center justify-between <?= $d['is_turned_on'] ? '' : 'opacity-60 bg-linen' ?>">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-espresso"><?= esc($d['name']) ?></span>
                                <?php if ($d['watt'] >= 150): ?>
                                    <span class="text-[9px] px-2 py-0.5 rounded-full bg-red-100 text-red-600 font-bold uppercase">Daya Besar</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-xs text-stone-400 mt-0.5">
                                <?= $d['watt'] ?> Watt • <?= $d['daily_hours'] ?> jam • Est. Rp<?= number_format($itemCost, 0, ',', '.') ?>/bln
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="<?= site_url('energy/toggle/' . $d['id']) ?>" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition <?= $d['is_turned_on'] ? 'bg-clay-600 text-white hover:bg-clay-700' : 'bg-sand text-stone-600 hover:bg-stone-300' ?>">
                                <?= $d['is_turned_on'] ? 'ON' : 'OFF' ?>
                            </a>
                            <a href="<?= site_url('energy/delete/' . $d['id']) ?>" onclick="return confirm('Hapus alat ini?')" class="text-stone-300 hover:text-red-500 p-1.5 transition">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>

    <script>
        function closeToast() {
            const toast = document.getElementById('flashToast');
            if (toast) {
                toast.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => toast.remove(), 400);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('flashToast');
            if (toast) {
                setTimeout(() => {
                    closeToast();
                }, 3000);
            }
        });
    </script>
</body>

</html>