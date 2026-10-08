<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun & Profil — Voltify</title>
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

    <!-- Header -->
    <header class="bg-white border-b border-sand sticky top-0 z-50">
        <div class="max-w-3xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('dashboard') ?>" class="w-9 h-9 rounded-xl bg-linen border border-sand flex items-center justify-center text-stone-600 hover:text-clay-600 transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <h1 class="text-sm font-extrabold text-espresso">Pengaturan Akun</h1>
            </div>
            <a href="<?= site_url('dashboard') ?>" class="text-xs font-bold text-clay-600 hover:underline">
                Kembali ke Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 pt-8 space-y-6">

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="p-4 rounded-2xl bg-clay-600 text-white text-xs font-semibold shadow-md flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Form Profil & Batas Anggaran -->
        <div class="bg-white rounded-3xl p-8 border border-sand shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl font-extrabold text-espresso tracking-tight">Informasi Pribadi & Target Hemat</h2>
                <p class="text-xs text-stone-500 mt-1">Ubah identitas akun serta batas anggaran listrik bulanan rumahmu.</p>
            </div>

            <form action="<?= site_url('profile/update') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= esc($user['name'] ?? session()->get('name')) ?>" required class="w-full px-4 py-3 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="email" value="<?= esc($user['email'] ?? session()->get('email')) ?>" required class="w-full px-4 py-3 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1.5">Target Batas Anggaran Bulanan (Rp)</label>
                    <input type="number" name="budget" value="<?= $budget ?>" required min="50000" step="10000" class="w-full px-4 py-3 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                    <p class="text-[11px] text-stone-400 mt-1">Sistem akan memberi peringatan jika tagihan melebihi 80% dari angka ini.</p>
                </div>

                <div class="pt-4 border-t border-sand">
                    <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1.5">Ganti Kata Sandi (Opsional)</label>
                    <input type="password" name="new_password" placeholder="Kosongkan jika tidak ingin mengubah sandi" class="w-full px-4 py-3 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600">
                </div>

                <button type="submit" class="py-3.5 px-6 rounded-xl bg-clay-600 hover:bg-clay-700 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-clay-600/20 transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Danger Zone: Hapus Akun -->
        <div class="bg-red-50/60 rounded-3xl p-8 border border-red-200">
            <h3 class="text-sm font-bold text-red-900 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-600"></i> Zona Berbahaya (Danger Zone)
            </h3>
            <p class="text-xs text-red-700 mt-1 leading-relaxed">
                Menghapus akun akan menghilangkan seluruh riwayat perangkat listrik dan data pribadi secara permanen dari basis data.
            </p>

            <form action="<?= site_url('profile/delete-account') ?>" method="post" class="mt-4" onsubmit="return confirm('PERINGATAN: Apakah kamu yakin ingin menghapus akun ini secara permanen? Data tidak dapat dipulihkan kembali.')">
                <?= csrf_field() ?>
                <button type="submit" class="py-2.5 px-5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition shadow-sm">
                    Hapus Akun Saya Permanen
                </button>
            </form>
        </div>

    </main>
</body>

</html>