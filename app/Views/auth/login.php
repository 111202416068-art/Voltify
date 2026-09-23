<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk ke Voltify</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
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
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            serif: ['"Playfair Display"', 'serif'],
          }
        }
      }
    }
  </script>
</head>
<body class="bg-linen min-h-screen flex items-center justify-center p-4 sm:p-6 selection:bg-clay-100 selection:text-clay-700">

  <!-- Main Split Card -->
  <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-stone-300/40 border border-sand overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">
    
    <!-- Sisi Kiri: Branding & Value Proposition (Earth-Tone Terracotta) -->
    <div class="lg:col-span-5 bg-gradient-to-br from-clay-700 via-clay-600 to-clay-800 p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
      
      <!-- Subtle Decorative Glow Circles -->
      <div class="absolute -top-12 -left-12 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
      <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-black/15 rounded-full blur-2xl pointer-events-none"></div>

      <div class="relative z-10 space-y-6">
        <!-- Logo -->
        <a href="<?= site_url('/') ?>" class="inline-flex items-center gap-2.5 group">
          <span class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur-md text-white flex items-center justify-center text-sm border border-white/20 group-hover:scale-105 transition">
            <i class="fa-solid fa-leaf"></i>
          </span>
          <span class="font-extrabold text-2xl tracking-tight text-white">Voltify<span class="text-clay-200">.</span></span>
        </a>

        <!-- Headline Editorial -->
        <div class="space-y-2 pt-2">
          <h2 class="text-3xl font-extrabold leading-tight">
            Kendalikan energi, <br>
            <span class="font-serif italic font-normal text-clay-200">pangkas pengeluaran.</span>
          </h2>
          <p class="text-xs text-clay-100/80 leading-relaxed">
            Masuk untuk memantau durasi elektronik rumah, simulasi tagihan PLN, dan sistem auto cut-off pintar.
          </p>
        </div>

        <!-- 3 Feature Highlights (Lebih Elegan dari Punya Teman) -->
        <div class="space-y-3 pt-2">
          <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10">
            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-xs text-white">
              <i class="fa-solid fa-chart-pie"></i>
            </div>
            <p class="text-xs font-semibold text-white">Pemantauan Daya & Beban Harian</p>
          </div>

          <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10">
            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-xs text-white">
              <i class="fa-solid fa-calculator"></i>
            </div>
            <p class="text-xs font-semibold text-white">Estimasi Tagihan Sesuai Tarif PLN</p>
          </div>

          <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10">
            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-xs text-white">
              <i class="fa-solid fa-power-off"></i>
            </div>
            <p class="text-xs font-semibold text-white">Automasi Pemutus Beban Virtual</p>
          </div>
        </div>
      </div>

      <!-- Footer Info Kiri -->
      <div class="relative z-10 pt-6 border-t border-white/15 flex items-center justify-between text-[11px] text-clay-200">
        <span>Sistem Manajemen Proyek</span>
        <span>© 2026</span>
      </div>

    </div>

    <!-- Sisi Kanan: Form Login (Bersih, Rapi, Ada Icon & Toggle Password) -->
    <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-between bg-white">
      
      <!-- Back Link -->
      <div>
        <a href="<?= site_url('/') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-stone-500 hover:text-clay-600 transition mb-6">
          <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Beranda
        </a>

        <div class="mb-6">
          <h3 class="text-2xl sm:text-3xl font-extrabold text-espresso tracking-tight">Selamat Datang!</h3>
          <p class="text-xs text-stone-500 mt-1">Silakan masukkan email dan kata sandi akun Voltify kamu.</p>
        </div>

        <!-- Flash Error -->
        <?php if (session()->getFlashdata('error')): ?>
          <div class="mb-5 p-3.5 rounded-2xl bg-red-50 text-red-700 text-xs font-semibold border border-red-200 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-sm"></i>
            <span><?= session()->getFlashdata('error') ?></span>
          </div>
        <?php endif; ?>

        <!-- Flash Success -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="mb-5 p-3.5 rounded-2xl bg-clay-50 text-clay-700 text-xs font-semibold border border-clay-200 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-sm text-clay-600"></i>
            <span><?= session()->getFlashdata('success') ?></span>
          </div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post" class="space-y-4">
          <?= csrf_field() ?>
          
          <!-- Input Email dengan Icon -->
          <div>
            <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1.5">Email</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400 text-xs">
                <i class="fa-regular fa-envelope"></i>
              </span>
              <input type="email" name="email" value="<?= old('email') ?>" required placeholder="nama@email.com" class="w-full pl-10 pr-4 py-3 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600 focus:bg-white transition">
            </div>
          </div>

          <!-- Input Password dengan Icon & Toggle Show/Hide -->
          <div>
            <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-1.5">Kata Sandi</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400 text-xs">
                <i class="fa-solid fa-lock"></i>
              </span>
              <input type="password" id="passwordInput" name="password" required placeholder="Masukkan kata sandi" class="w-full pl-10 pr-10 py-3 text-xs bg-linen border border-sand rounded-xl outline-none focus:ring-2 focus:ring-clay-600 focus:bg-white transition">
              <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-espresso transition">
                <i class="fa-regular fa-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>

          <!-- Tombol Submit Login -->
          <button type="submit" class="w-full py-3.5 rounded-xl bg-clay-600 hover:bg-clay-700 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-clay-600/25 transition duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5 mt-2">
            <span>Masuk Sekarang</span>
            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
          </button>
        </form>
      </div>

      <!-- Bagian Bawah Form -->
      <div class="pt-6 border-t border-sand mt-6 space-y-3">
        <p class="text-center text-xs text-stone-500">
          Belum memiliki akun? <a href="<?= site_url('register') ?>" class="text-clay-600 font-bold hover:underline">Daftar sekarang</a>
        </p>
        
        <!-- Info Akun Bawaan (Bisa diklik untuk isi otomatis) -->
        <div class="p-3 rounded-2xl bg-linen border border-sand text-[11px] text-stone-500 text-center flex items-center justify-around">
          <span>Demo Akun:</span>
          <button type="button" onclick="fillDemo('admin@voltify.com', 'admin123')" class="font-bold text-clay-700 hover:underline">Admin Autofill</button>
          <span>|</span>
          <button type="button" onclick="fillDemo('user@voltify.com', 'admin123')" class="font-bold text-clay-700 hover:underline">User Autofill</button>
        </div>
      </div>

    </div>

  </div>

  <script>
    // Fitur Intip Password (Show / Hide)
    function togglePasswordVisibility() {
      const input = document.getElementById('passwordInput');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }

    // Tombol Autofill Praktis untuk Pengujian / Presentasi Dosen
    function fillDemo(email, pass) {
      document.querySelector('input[name="email"]').value = email;
      document.getElementById('passwordInput').value = pass;
    }
  </script>
</body>
</html>