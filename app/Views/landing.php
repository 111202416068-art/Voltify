<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voltify — Smart Habit & Energy Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clay: {
              50: '#FDF8F5',
              100: '#F9ECE5',
              200: '#F3D5C5',
              500: '#D96B43',
              600: '#C85A32',
              700: '#A74623',
              800: '#7F3318',
            },
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
  <style>
    @keyframes floatSlow {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-8px); }
    }
    .animate-float {
      animation: floatSlow 4s ease-in-out infinite;
    }
  </style>
</head>
<body class="bg-linen text-espresso antialiased selection:bg-clay-200 selection:text-clay-800 flex flex-col min-h-screen">

  <!-- Floating Earth-Tone Navbar -->
  <header class="sticky top-4 z-50 max-w-6xl mx-auto px-4 w-full">
    <nav class="bg-white/90 backdrop-blur-md border border-sand rounded-2xl px-6 py-4 flex items-center justify-between shadow-sm transition">
      
      <!-- Brand Logo -->
      <a href="#beranda" class="flex items-center gap-2.5 group">
        <span class="w-9 h-9 rounded-xl bg-clay-600 text-white flex items-center justify-center text-sm shadow-md shadow-clay-600/30 group-hover:scale-105 transition">
          <i class="fa-solid fa-leaf"></i>
        </span>
        <span class="font-extrabold text-xl tracking-tight text-espresso">Voltify<span class="text-clay-600">.</span></span>
      </a>

      <!-- 3 Menu Navigasi Saja -->
      <div class="hidden md:flex items-center gap-10 text-xs font-bold uppercase tracking-wider text-stone-600">
        <a href="#beranda" class="hover:text-clay-600 transition">Beranda</a>
        <a href="#simulasi" class="hover:text-clay-600 transition">Simulasi</a>
        <a href="#tentang" class="hover:text-clay-600 transition">Tentang Kami</a>
      </div>

      <!-- Auth Action -->
      <div class="flex items-center gap-3">
        <?php if (session()->get('logged_in')): ?>
          <a href="<?= site_url(session()->get('role') === 'admin' ? 'admin' : 'dashboard') ?>" class="px-5 py-2.5 rounded-xl bg-clay-600 text-white text-xs font-bold hover:bg-clay-700 transition shadow-sm">
            Dashboard
          </a>
        <?php else: ?>
          <a href="<?= site_url('login') ?>" class="px-4 py-2 rounded-xl text-xs font-bold text-stone-700 hover:text-espresso transition">
            Masuk
          </a>
          <a href="<?= site_url('register') ?>" class="px-5 py-2.5 rounded-xl bg-espresso text-white text-xs font-bold hover:bg-stone-800 transition shadow-sm hover:scale-[1.02]">
            Daftar
          </a>
        <?php endif; ?>
      </div>
    </nav>
  </header>

  <!-- SEKSI 1: Hero Section (Minimalis, Hanya 1 Tombol Utama) -->
  <section id="beranda" class="min-h-[82vh] flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto py-16">
    
    <!-- Animasi Badge -->
    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-clay-100 border border-clay-200 text-clay-700 text-xs font-bold tracking-wide mb-6 animate-float">
      <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-clay-500 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-clay-600"></span>
      </span>
      Proyek Manajemen Penghematan Energi 2026
    </div>

    <!-- Title Editorial -->
    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-espresso tracking-tight leading-[1.12] mb-6">
      Kelola energi cerdas, <br>
      <span class="font-serif italic font-normal text-clay-600">selaras dengan alam & kantong.</span>
    </h1>

    <p class="text-stone-600 text-sm sm:text-lg leading-relaxed max-w-2xl mx-auto mb-10">
      Kendalikan beban listrik rumah tanpa instalasi alat hardware berisiko. Cukup pantau kebiasaan penggunaan dan manfaatkan fitur pemutus daya otomatis virtual.
    </p>

    <!-- HANYA 1 TOMBOL UTAMA (Tombol simulasi ganda sudah dihapus) -->
    <div>
      <a href="<?= site_url('register') ?>" class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-clay-600 hover:bg-clay-700 text-white text-sm font-bold uppercase tracking-wider transition shadow-xl shadow-clay-600/30 hover:-translate-y-1">
        <span>Mulai Sekarang</span>
        <i class="fa-solid fa-arrow-right text-xs"></i>
      </a>
    </div>

  </section>


  <!-- SEKSI 2: Ringkasan Beban & Solusi Cut-Off (Proporsional & Seimbang) -->
  <section class="max-w-6xl mx-auto px-4 py-16 border-t border-sand">
    <div class="text-center max-w-xl mx-auto mb-12">
      <span class="text-xs uppercase font-bold tracking-widest text-clay-600">Insight Beban Listrik</span>
      <h2 class="text-3xl font-extrabold text-espresso mt-1">Transparansi Penggunaan Daya</h2>
      <p class="text-xs text-stone-500 mt-2">Gambaran nyata bagaimana pemborosan listrik terjadi jika tidak diputus saat keluar rumah.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
      
      <!-- Card Kiri: Ringkasan Beban Harian -->
      <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-sand shadow-sm hover:shadow-md transition flex flex-col justify-between">
        <div>
          <div class="flex justify-between items-center mb-6">
            <div>
              <span class="text-xs uppercase font-bold tracking-widest text-stone-400">Ringkasan Beban Harian</span>
              <h3 class="text-3xl font-black text-espresso mt-1">Rp198.400 <span class="text-xs font-normal text-stone-500">/ bulan</span></h3>
            </div>
            <span class="text-xs px-3 py-1 rounded-full bg-sand/60 text-stone-700 font-mono font-bold">PLN R-1 1.300VA</span>
          </div>

          <div class="space-y-3">
            <div class="flex items-center justify-between p-4 rounded-2xl bg-linen border border-sand">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-clay-100 text-clay-700 flex items-center justify-center text-sm">
                  <i class="fa-solid fa-snowflake"></i>
                </div>
                <div>
                  <h4 class="text-sm font-bold text-espresso">AC Kamar Tidur 1/2 PK</h4>
                  <p class="text-[11px] text-stone-400">350 Watt • Durasi 8 Jam</p>
                </div>
              </div>
              <div class="text-right">
                <span class="text-sm font-mono font-bold text-espresso">84 kWh</span>
                <p class="text-[10px] text-clay-600 font-semibold">Rp121.354/bln</p>
              </div>
            </div>

            <div class="flex items-center justify-between p-4 rounded-2xl bg-linen border border-sand">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm">
                  <i class="fa-solid fa-mug-hot"></i>
                </div>
                <div>
                  <h4 class="text-sm font-bold text-espresso">Dispenser Pemanas</h4>
                  <p class="text-[11px] text-stone-400">400 Watt • Durasi 10 Jam</p>
                </div>
              </div>
              <div class="text-right">
                <span class="text-sm font-mono font-bold text-espresso">120 kWh</span>
                <p class="text-[10px] text-clay-600 font-semibold">Rp173.364/bln</p>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 pt-4 border-t border-sand flex items-center justify-between text-xs">
          <span class="text-stone-500">Kepatuhan Anggaran:</span>
          <span class="font-bold text-clay-700 bg-clay-50 px-3 py-1 rounded-full border border-clay-200">
            <i class="fa-solid fa-check-circle"></i> Dalam Batas Wajar
          </span>
        </div>
      </div>

      <!-- Card Kanan: Virtual Cut-Off -->
      <div class="lg:col-span-5 bg-clay-600 text-white rounded-3xl p-8 flex flex-col justify-between shadow-xl shadow-clay-600/20">
        <div>
          <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl mb-6">
            <i class="fa-solid fa-power-off"></i>
          </div>
          <span class="text-xs uppercase font-bold tracking-widest text-clay-200">Smart Automated Cut-Off</span>
          <h3 class="text-2xl font-extrabold mt-2 leading-snug">Cegah Pemborosan Saat Keluar Rumah</h3>
          <p class="text-xs text-clay-100/90 leading-relaxed mt-3">
            Satu klik mode keluar rumah akan otomatis memutus beban seluruh alat yang berdaya $\ge 150$ Watt, memastikan tidak ada AC atau dispenser yang tertinggal menyala sia-sia.
          </p>
        </div>

        <div class="mt-8 pt-6 border-t border-white/20">
          <div class="p-4 rounded-2xl bg-black/15 text-xs text-clay-100 flex items-center justify-between font-medium">
            <span>Potensi Penghematan</span>
            <span class="font-bold text-white text-sm">s/d Rp85.000/bln</span>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- SEKSI 3: Kalkulator Simulasi (Ukuran Dibuat Besar, Gagah, dan Seimbang) -->
  <section id="simulasi" class="max-w-6xl mx-auto px-4 py-16 border-t border-sand">
    <div class="bg-white rounded-3xl p-8 sm:p-14 border border-sand shadow-sm">
      
      <div class="max-w-3xl mb-10">
        <span class="text-xs uppercase font-bold tracking-widest text-clay-600">Simulasi Interaktif</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-espresso mt-2">Kalkulator Pengeluaran Mandiri</h2>
        <p class="text-sm text-stone-500 mt-2 leading-relaxed">
          Geser nilai daya watt dan durasi jam pemakaian untuk mengetahui beban estimasi tagihan resmi PLN Golongan R-1 1.300VA secara real-time.
        </p>
      </div>

      <!-- Grid 50:50 yang Luas & Mantap -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
        
        <!-- Kolom Kontrol Slider (Span 7) -->
        <div class="lg:col-span-7 space-y-8 pr-0 lg:pr-4">
          
          <div class="space-y-3">
            <div class="flex justify-between items-center text-sm font-bold text-espresso">
              <span>Daya Watt Peralatan:</span>
              <span id="sliderWattLabel" class="text-clay-600 font-mono text-sm bg-clay-50 px-3 py-1 rounded-lg border border-clay-200">
                350 Watt (AC 1/2 PK)
              </span>
            </div>
            <input type="range" id="sliderWatt" min="50" max="1500" step="50" value="350" oninput="updateSim()" class="w-full h-3 bg-sand rounded-lg appearance-none cursor-pointer accent-clay-600">
            <div class="flex justify-between text-[11px] text-stone-400 font-medium">
              <span>50 Watt (Lampu/Kipas)</span>
              <span>1500 Watt (Water Heater Besar)</span>
            </div>
          </div>

          <div class="space-y-3">
            <div class="flex justify-between items-center text-sm font-bold text-espresso">
              <span>Lama Pemakaian Harian:</span>
              <span id="sliderHoursLabel" class="text-clay-600 font-mono text-sm bg-clay-50 px-3 py-1 rounded-lg border border-clay-200">
                8 Jam / hari
              </span>
            </div>
            <input type="range" id="sliderHours" min="1" max="24" step="1" value="8" oninput="updateSim()" class="w-full h-3 bg-sand rounded-lg appearance-none cursor-pointer accent-clay-600">
            <div class="flex justify-between text-[11px] text-stone-400 font-medium">
              <span>1 Jam</span>
              <span>24 Jam (Non-stop)</span>
            </div>
          </div>

        </div>

        <!-- Kolom Card Hasil (Span 5 - Dibuat Besar & Mewah) -->
        <div class="lg:col-span-5 bg-linen border border-sand rounded-3xl p-8 sm:p-10 text-center space-y-4 shadow-inner">
          <span class="text-xs uppercase font-bold tracking-wider text-stone-400">Estimasi Tagihan Beban Alat Ini</span>
          
          <div class="text-4xl sm:text-5xl font-black text-espresso tracking-tight" id="simCostDisplay">
            Rp121.354
          </div>
          
          <div class="pt-2">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white border border-sand text-xs font-semibold text-stone-600" id="simKwhDisplay">
              84.0 kWh per bulan
            </span>
          </div>

          <p class="text-[11px] text-stone-400 pt-2 border-t border-sand">
            *Dihitung berdasarkan rumus resmi kWh PLN (Tarif Rp1.444,70 / kWh).
          </p>
        </div>

      </div>

    </div>
  </section>


  <!-- SEKSI 4: Tentang Kami & Informasi Tim -->
  <footer id="tentang" class="bg-white border-t border-sand py-16 mt-auto">
    <div class="max-w-6xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div>
          <div class="flex items-center gap-2.5 mb-3">
            <span class="w-7 h-7 rounded-lg bg-clay-600 text-white flex items-center justify-center text-xs">⚡</span>
            <span class="font-extrabold text-lg text-espresso">Voltify Project</span>
          </div>
          <p class="text-xs text-stone-500 leading-relaxed">
            Aplikasi manajemen proyek perangkat lunak untuk edukasi dan pencegahan pemborosan energi rumah tangga.
          </p>
        </div>
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-espresso mb-3">Spesifikasi Sistem</h4>
          <ul class="text-xs text-stone-500 space-y-2">
            <li>Framework: CodeIgniter 4 (PHP 8.2)</li>
            <li>Database: MySQL (voltify02_db)</li>
            <li>Arsitektur: MVC + Multi-Role Auth</li>
          </ul>
        </div>
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-espresso mb-3">Tujuan Tim</h4>
          <p class="text-xs text-stone-500 leading-relaxed">
            Menghadirkan solusi hemat daya nyata yang tidak membebani pengguna dengan perakitan hardware mahal.
          </p>
        </div>
      </div>

      <div class="pt-8 border-t border-sand flex flex-col sm:flex-row justify-between items-center text-xs text-stone-400 gap-4">
        <p>© 2026 Tim Proyek Voltify. Semua hak dilindungi.</p>
        <div class="flex items-center gap-4">
          <a href="#beranda" class="hover:text-clay-600 transition">Kembali ke Atas ↑</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Script Perhitungan Live Slider -->
  <script>
    function updateSim() {
      const watt = Number(document.getElementById('sliderWatt').value);
      const hours = Number(document.getElementById('sliderHours').value);
      
      let labelDesc = `${watt} Watt`;
      if (watt <= 100) labelDesc += " (Kipas/TV)";
      else if (watt <= 400) labelDesc += " (AC 1/2 PK / Dispenser)";
      else labelDesc += " (Water Heater / Setrika)";

      document.getElementById('sliderWattLabel').innerText = labelDesc;
      document.getElementById('sliderHoursLabel').innerText = `${hours} Jam / hari`;

      const monthlyKwh = ((watt * hours) / 1000) * 30;
      const monthlyCost = monthlyKwh * 1444.70;

      document.getElementById('simCostDisplay').innerText = `Rp${Math.round(monthlyCost).toLocaleString('id-ID')}`;
      document.getElementById('simKwhDisplay').innerText = `${monthlyKwh.toFixed(1)} kWh per bulan (Tarif R-1 1.300VA)`;
    }
    updateSim();
  </script>
</body>
</html>