<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Voltify Admin Portal</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Chart JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
  >

  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  >

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

              700: '#A74623',

              800: '#7F3318'

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

  <style>

    html {
      scroll-behavior: smooth;
    }

    .menu-active {
      background: #F9ECE5;
      color: #C85A32;
      font-weight: 700;
    }

    .page-section {
      display: none;
    }

    .page-section.active {
      display: block;
    }

  </style>

</head>


<body class="bg-linen text-espresso min-h-screen">


<!-- ====================================================== -->
<!-- SIDEBAR -->
<!-- ====================================================== -->

<aside
  class="fixed left-0 top-0 bottom-0 w-60 bg-white border-r border-sand z-50 flex flex-col"
>

  <!-- LOGO -->

  <div class="px-6 py-6 border-b border-sand">

    <div class="flex items-center gap-3">

      <div
        class="w-10 h-10 rounded-xl bg-espresso text-white flex items-center justify-center"
      >

        <i class="fa-solid fa-bolt text-clay-500"></i>

      </div>

      <div>

        <h1 class="font-extrabold text-lg">
          Voltify
        </h1>

        <p class="text-[10px] text-stone-400">
          Admin Portal
        </p>

      </div>

    </div>

  </div>


  <!-- MENU -->

  <nav class="p-4 space-y-2 flex-1">

    <!-- DASHBOARD -->

    <button
      onclick="showSection('dashboard', this)"
      class="menu-item menu-active w-full flex items-center gap-4 px-4 py-3 rounded-xl text-sm text-left transition"
    >

      <i class="fa-solid fa-chart-line w-5"></i>

      <span>Dashboard</span>

    </button>


    <!-- PENGGUNA -->

    <button
      onclick="showSection('pengguna', this)"
      class="menu-item w-full flex items-center gap-4 px-4 py-3 rounded-xl text-sm text-left text-stone-700 hover:bg-clay-50 transition"
    >

      <i class="fa-solid fa-users w-5"></i>

      <span>Pengguna</span>

    </button>


    <!-- PERANGKAT -->

    <button
      onclick="showSection('perangkat', this)"
      class="menu-item w-full flex items-center gap-4 px-4 py-3 rounded-xl text-sm text-left text-stone-700 hover:bg-clay-50 transition"
    >

      <i class="fa-solid fa-plug w-5"></i>

      <span>Perangkat</span>

    </button>


    <!-- AUDIT DAYA -->

    <button
      onclick="showSection('audit', this)"
      class="menu-item w-full flex items-center gap-4 px-4 py-3 rounded-xl text-sm text-left text-stone-700 hover:bg-clay-50 transition"
    >

      <i class="fa-solid fa-clipboard-check w-5"></i>

      <span>Audit Daya</span>

    </button>

  </nav>


  <!-- BAGIAN BAWAH -->

  <div class="p-4 border-t border-sand space-y-2">

    <a
      href="<?= site_url('dashboard') ?>"
      class="w-full flex items-center gap-4 px-4 py-3 rounded-xl border border-sand text-sm font-semibold hover:border-clay-600 transition"
    >

      <i class="fa-solid fa-arrow-up-right-from-square w-5"></i>

      <span>App Pengguna</span>

    </a>


    <a
      href="<?= site_url('logout') ?>"
      class="w-full flex items-center gap-4 px-4 py-3 rounded-xl bg-espresso text-white text-sm font-semibold hover:bg-stone-800 transition"
    >

      <i class="fa-solid fa-right-from-bracket w-5"></i>

      <span>Keluar</span>

    </a>

  </div>

</aside>


<!-- ====================================================== -->
<!-- MAIN CONTENT -->
<!-- ====================================================== -->

<main class="ml-60 min-h-screen">


  <!-- HEADER -->

  <header
    class="h-16 bg-white border-b border-sand flex items-center justify-between px-8 sticky top-0 z-40"
  >

    <div>

      <h2 class="font-extrabold text-lg">
        Admin Dashboard
      </h2>

      <p class="text-xs text-stone-400">
        Pusat kendali sistem Voltify
      </p>

    </div>


    <div
      class="w-10 h-10 rounded-full bg-clay-100 text-clay-600 flex items-center justify-center"
    >

      <i class="fa-solid fa-user"></i>

    </div>

  </header>


  <!-- CONTENT -->

  <div class="p-8">


    <!-- ================================================= -->
    <!-- FLASH MESSAGE -->
    <!-- ================================================= -->

    <?php if (session()->getFlashdata('success')): ?>

      <div
        class="mb-6 p-4 rounded-2xl bg-clay-600 text-white text-xs font-semibold flex items-center gap-2"
      >

        <i class="fa-solid fa-circle-check"></i>

        <?= session()->getFlashdata('success') ?>

      </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

      <div
        class="mb-6 p-4 rounded-2xl bg-red-50 text-red-700 border border-red-200 text-xs font-semibold flex items-center gap-2"
      >

        <i class="fa-solid fa-circle-exclamation"></i>

        <?= session()->getFlashdata('error') ?>

      </div>

    <?php endif; ?>


    <!-- ================================================= -->
    <!-- DASHBOARD -->
    <!-- ================================================= -->

    <section id="dashboard" class="page-section active">


      <!-- JUDUL -->

      <div class="mb-7">

        <p class="text-xs uppercase tracking-widest text-clay-600 font-bold">
          Dashboard
        </p>

        <h1 class="text-2xl font-extrabold mt-1">
          Selamat datang, Admin!
        </h1>

        <p class="text-sm text-stone-400 mt-1">
          Berikut adalah ringkasan data pada dashboard.
        </p>

      </div>


      <!-- ================================================= -->
      <!-- METRIC -->
      <!-- ================================================= -->

      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">


        <!-- USER -->

        <div
          class="bg-white border border-sand rounded-3xl p-6 shadow-sm"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-xs font-bold uppercase tracking-wider text-stone-400">
                Total User
              </p>

              <h3 class="text-3xl font-extrabold mt-3">
                <?= $totalUsers ?>
              </h3>

              <p class="text-xs text-stone-400 mt-2">
                Total akun terdaftar
              </p>

            </div>

            <div
              class="w-12 h-12 rounded-full bg-clay-100 text-clay-600 flex items-center justify-center"
            >

              <i class="fa-solid fa-users"></i>

            </div>

          </div>

        </div>


        <!-- PERANGKAT -->

        <div
          class="bg-white border border-sand rounded-3xl p-6 shadow-sm"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-xs font-bold uppercase tracking-wider text-stone-400">
                Total Perangkat
              </p>

              <h3 class="text-3xl font-extrabold mt-3">
                <?= $totalDevices ?>
              </h3>

              <p class="text-xs text-stone-400 mt-2">
                Total perangkat terpasang
              </p>

            </div>

            <div
              class="w-12 h-12 rounded-full bg-clay-100 text-clay-600 flex items-center justify-center"
            >

              <i class="fa-solid fa-plug"></i>

            </div>

          </div>

        </div>


        <!-- KONSUMSI -->

        <div
          class="bg-white border border-sand rounded-3xl p-6 shadow-sm"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-xs font-bold uppercase tracking-wider text-stone-400">
                Konsumsi Global
              </p>

              <h3 class="text-3xl font-extrabold text-clay-600 mt-3">

                <?= number_format(
                  $totalGlobalKwh,
                  1,
                  ',',
                  '.'
                ) ?>

              </h3>

              <p class="text-xs text-stone-400 mt-2">
                kWh konsumsi listrik
              </p>

            </div>

            <div
              class="w-12 h-12 rounded-full bg-clay-100 text-clay-600 flex items-center justify-center"
            >

              <i class="fa-solid fa-bolt"></i>

            </div>

          </div>

        </div>


        <!-- TAGIHAN -->

        <div
          class="bg-white border border-sand rounded-3xl p-6 shadow-sm"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-xs font-bold uppercase tracking-wider text-stone-400">
                Total Nilai Tagihan
              </p>

              <h3 class="text-2xl font-extrabold mt-3">

                Rp<?= number_format(
                  $totalGlobalCost,
                  0,
                  ',',
                  '.'
                ) ?>

              </h3>

              <p class="text-xs text-stone-400 mt-2">
                Estimasi kumulatif PLN
              </p>

            </div>

            <div
              class="w-12 h-12 rounded-full bg-clay-100 text-clay-600 flex items-center justify-center"
            >

              <i class="fa-solid fa-rupiah-sign"></i>

            </div>

          </div>

        </div>

      </div>


      <!-- ================================================= -->
      <!-- GRAFIK -->
      <!-- ================================================= -->

      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">


        <!-- GRAFIK -->

        <div
          class="xl:col-span-2 bg-white rounded-3xl p-6 border border-sand shadow-sm"
        >

          <div class="flex justify-between items-center mb-5">

            <div>

              <h2 class="text-lg font-extrabold">
                Konsumsi Energi
              </h2>

              <p class="text-xs text-stone-400 mt-1">
                Estimasi konsumsi setiap perangkat per hari
              </p>

            </div>

            <span
              class="px-3 py-2 rounded-xl bg-clay-50 text-clay-700 text-[10px] font-bold"
            >
              kWh / hari
            </span>

          </div>


          <div class="relative h-80">

            <canvas id="energyChart"></canvas>

          </div>

        </div>


        <!-- RINGKASAN -->

        <div
          class="bg-espresso text-white rounded-3xl p-6"
        >

          <p class="text-xs uppercase tracking-widest text-stone-400 font-bold">
            Ringkasan
          </p>

          <h2 class="text-xl font-extrabold mt-2">
            Pemantauan Energi
          </h2>

          <p class="text-xs text-stone-400 mt-3 leading-relaxed">
            Data konsumsi dihitung berdasarkan daya perangkat dan durasi penggunaan harian.
          </p>


          <!-- PERANGKAT -->

          <div class="mt-8">

            <div class="flex justify-between text-xs mb-2">

              <span class="text-stone-400">
                Perangkat
              </span>

              <strong>
                <?= $totalDevices ?>
              </strong>

            </div>

            <div class="h-1.5 bg-stone-700 rounded-full">

              <div
                class="h-1.5 bg-clay-500 rounded-full"
                style="width: 75%"
              ></div>

            </div>

          </div>


          <!-- KONSUMSI -->

          <div class="mt-6">

            <div class="flex justify-between text-xs mb-2">

              <span class="text-stone-400">
                Konsumsi
              </span>

              <strong>
                <?= number_format($totalGlobalKwh, 1, ',', '.') ?> kWh
              </strong>

            </div>

            <div class="h-1.5 bg-stone-700 rounded-full">

              <div
                class="h-1.5 bg-clay-500 rounded-full"
                style="width: 60%"
              ></div>

            </div>

          </div>


          <!-- USER -->

          <div class="mt-6">

            <div class="flex justify-between text-xs mb-2">

              <span class="text-stone-400">
                Pengguna
              </span>

              <strong>
                <?= $totalUsers ?>
              </strong>

            </div>

            <div class="h-1.5 bg-stone-700 rounded-full">

              <div
                class="h-1.5 bg-clay-500 rounded-full"
                style="width: 80%"
              ></div>

            </div>

          </div>

        </div>

      </div>

    </section>


    <!-- ================================================= -->
    <!-- PENGGUNA -->
    <!-- ================================================= -->

    <section id="pengguna" class="page-section">


      <div class="mb-7">

        <p class="text-xs uppercase tracking-widest text-clay-600 font-bold">
          Management
        </p>

        <div class="flex justify-between items-end">

          <div>

            <h1 class="text-2xl font-extrabold mt-1">
              Manajemen Akun Terdaftar
            </h1>

            <p class="text-sm text-stone-400 mt-1">
              Kelola hak akses dan akun pengguna sistem.
            </p>

          </div>

          <span
            class="px-4 py-2 rounded-xl bg-white border border-sand text-xs font-semibold"
          >
            <?= $totalUsers ?> Pengguna
          </span>

        </div>

      </div>


      <div
        class="bg-white rounded-3xl p-6 border border-sand shadow-sm"
      >

        <div class="overflow-x-auto">

          <table class="w-full text-sm text-left">

            <thead
              class="bg-clay-50 text-stone-500 uppercase text-xs font-bold"
            >

              <tr>

                <th class="py-4 px-5">
                  Nama
                </th>

                <th class="py-4 px-5">
                  Email
                </th>

                <th class="py-4 px-5">
                  Role Saat Ini
                </th>

                <th class="py-4 px-5 text-center">
                  Tindakan Admin
                </th>

              </tr>

            </thead>


            <tbody class="divide-y divide-sand">

              <?php foreach ($users as $u): ?>

                <tr class="hover:bg-clay-50/50 transition">

                  <td class="py-4 px-5 font-bold">
                    <?= esc($u['name']) ?>
                  </td>

                  <td class="py-4 px-5 font-mono text-xs">
                    <?= esc($u['email']) ?>
                  </td>

                  <td class="py-4 px-5">

                    <span
                      class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                      <?= $u['role'] === 'admin'
                        ? 'bg-clay-100 text-clay-700'
                        : 'bg-sand text-stone-700' ?>"
                    >

                      <?= $u['role'] ?>

                    </span>

                  </td>

                  <td class="py-4 px-5 text-center">

                    <a
                      href="<?= site_url('admin/toggle-role/' . $u['id']) ?>"
                      class="px-3 py-2 rounded-lg bg-linen border border-sand hover:border-clay-600 text-xs font-bold"
                    >
                      Ubah Role
                    </a>


                    <?php if ($u['id'] != session()->get('user_id')): ?>

                      <a
                        href="<?= site_url('admin/delete-user/' . $u['id']) ?>"
                        onclick="return confirm('Hapus user ini beserta semua perangkatnya?')"
                        class="ml-2 px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold"
                      >
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

    </section>


    <!-- ================================================= -->
    <!-- PERANGKAT -->
    <!-- ================================================= -->

    <section id="perangkat" class="page-section">


      <div class="mb-7">

        <p class="text-xs uppercase tracking-widest text-clay-600 font-bold">
          Perangkat
        </p>

        <h1 class="text-2xl font-extrabold mt-1">
          Daftar Perangkat Listrik
        </h1>

        <p class="text-sm text-stone-400 mt-1">
          Seluruh perangkat listrik yang terdaftar dalam sistem.
        </p>

      </div>


      <div
        class="bg-white rounded-3xl p-6 border border-sand shadow-sm"
      >

        <div class="overflow-x-auto">

          <table class="w-full text-sm text-left">

            <thead
              class="bg-clay-50 text-stone-500 uppercase text-xs font-bold"
            >

              <tr>

                <th class="py-4 px-5">
                  Pemilik
                </th>

                <th class="py-4 px-5">
                  Nama Perangkat
                </th>

                <th class="py-4 px-5">
                  Daya
                </th>

                <th class="py-4 px-5">
                  Durasi Harian
                </th>

                <th class="py-4 px-5">
                  Status
                </th>

              </tr>

            </thead>


            <tbody class="divide-y divide-sand">

              <?php foreach ($devices as $d): ?>

                <tr class="hover:bg-clay-50/50">

                  <td class="py-4 px-5 font-semibold">
                    <?= esc(
                      $d['user_name']
                      ?? 'User #' . $d['user_id']
                    ) ?>
                  </td>

                  <td class="py-4 px-5 font-bold">
                    <?= esc($d['name']) ?>
                  </td>

                  <td class="py-4 px-5 font-mono">
                    <?= $d['watt'] ?> W
                  </td>

                  <td class="py-4 px-5">
                    <?= $d['daily_hours'] ?> Jam / hari
                  </td>

                  <td class="py-4 px-5">

                    <span
                      class="px-3 py-1 rounded-full text-[10px] font-bold
                      <?= $d['is_turned_on']
                        ? 'bg-clay-100 text-clay-700'
                        : 'bg-stone-200 text-stone-500' ?>"
                    >

                      <?= $d['is_turned_on']
                        ? 'MENYALA (ON)'
                        : 'MATI (OFF)' ?>

                    </span>

                  </td>

                </tr>

              <?php endforeach; ?>

            </tbody>

          </table>

        </div>

      </div>

    </section>


    <!-- ================================================= -->
    <!-- AUDIT DAYA -->
    <!-- ================================================= -->

    <section id="audit" class="page-section">


      <div class="mb-7">

        <p class="text-xs uppercase tracking-widest text-clay-600 font-bold">
          Audit
        </p>

        <h1 class="text-2xl font-extrabold mt-1">
          Audit Daya
        </h1>

        <p class="text-sm text-stone-400 mt-1">
          Kontrol status dan aktivitas perangkat listrik.
        </p>

      </div>


      <div
        class="bg-white rounded-3xl p-6 border border-sand shadow-sm"
      >

        <div class="overflow-x-auto">

          <table class="w-full text-sm text-left">

            <thead
              class="bg-clay-50 text-stone-500 uppercase text-xs font-bold"
            >

              <tr>

                <th class="py-4 px-5">
                  Pemilik
                </th>

                <th class="py-4 px-5">
                  Perangkat
                </th>

                <th class="py-4 px-5">
                  Daya
                </th>

                <th class="py-4 px-5">
                  Durasi
                </th>

                <th class="py-4 px-5">
                  Status
                </th>

                <th class="py-4 px-5 text-center">
                  Kontrol
                </th>

              </tr>

            </thead>


            <tbody class="divide-y divide-sand">

              <?php foreach ($devices as $d): ?>

                <tr class="hover:bg-clay-50/50">

                  <td class="py-4 px-5 font-semibold">
                    <?= esc(
                      $d['user_name']
                      ?? 'User #' . $d['user_id']
                    ) ?>
                  </td>

                  <td class="py-4 px-5 font-bold">
                    <?= esc($d['name']) ?>
                  </td>

                  <td class="py-4 px-5 font-mono">
                    <?= $d['watt'] ?> W
                  </td>

                  <td class="py-4 px-5">
                    <?= $d['daily_hours'] ?> Jam / hari
                  </td>

                  <td class="py-4 px-5">

                    <span
                      class="px-3 py-1 rounded-full text-[10px] font-bold
                      <?= $d['is_turned_on']
                        ? 'bg-clay-100 text-clay-700'
                        : 'bg-stone-200 text-stone-500' ?>"
                    >

                      <?= $d['is_turned_on']
                        ? 'MENYALA (ON)'
                        : 'MATI (OFF)' ?>

                    </span>

                  </td>

                  <td class="py-4 px-5 text-center">

                    <a
                      href="<?= site_url('energy/toggle/' . $d['id']) ?>"
                      class="px-3 py-2 rounded-lg bg-linen border border-sand hover:border-clay-600 text-xs font-bold"
                    >
                      Switch ON/OFF
                    </a>

                    <a
                      href="<?= site_url('energy/delete/' . $d['id']) ?>"
                      onclick="return confirm('Hapus perangkat ini dari database?')"
                      class="ml-2 px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold"
                    >
                      Hapus
                    </a>

                  </td>

                </tr>

              <?php endforeach; ?>

            </tbody>

          </table>

        </div>

      </div>

    </section>


  </div>

</main>


<!-- ====================================================== -->
<!-- JAVASCRIPT -->
<!-- ====================================================== -->

<script>


/* =====================================================
   PINDAH MENU
===================================================== */

function showSection(sectionId, button) {

  // Sembunyikan semua section

  document
    .querySelectorAll('.page-section')
    .forEach(function(section) {

      section.classList.remove('active');

    });


  // Tampilkan section yang dipilih

  const selectedSection =
    document.getElementById(sectionId);

  if (selectedSection) {

    selectedSection.classList.add('active');

  }


  // Hapus active dari semua menu

  document
    .querySelectorAll('.menu-item')
    .forEach(function(menu) {

      menu.classList.remove('menu-active');

    });


  // Tambahkan active ke menu yang diklik

  if (button) {

    button.classList.add('menu-active');

  }

}


/* =====================================================
   DATA GRAFIK DARI PHP
===================================================== */

const deviceLabels = <?= json_encode(

  array_map(

    fn($d) => $d['name'],

    $devices

  )

) ?>;


const deviceConsumption = <?= json_encode(

  array_map(

    fn($d) => round(

      ($d['watt'] * $d['daily_hours']) / 1000,

      2

    ),

    $devices

  )

) ?>;


/* =====================================================
   GRAFIK GARIS
===================================================== */

const ctx =
  document.getElementById('energyChart');


if (ctx) {

  new Chart(ctx, {

    type: 'line',

    data: {

      labels: deviceLabels,

      datasets: [{

        label: 'Konsumsi (kWh/hari)',

        data: deviceConsumption,

        borderColor: '#D96B43',

        backgroundColor: 'rgba(217, 107, 67, 0.10)',

        borderWidth: 3,

        tension: 0.4,

        fill: true,

        pointRadius: 5,

        pointHoverRadius: 7,

        pointBackgroundColor: '#FFFFFF',

        pointBorderColor: '#D96B43',

        pointBorderWidth: 3

      }]

    },


    options: {

      responsive: true,

      maintainAspectRatio: false,


      plugins: {

        legend: {

          display: true,

          labels: {

            font: {

              family: 'Plus Jakarta Sans'

            }

          }

        }

      },


      scales: {

        y: {

          beginAtZero: true,

          title: {

            display: true,

            text: 'kWh / hari'

          }

        },


        x: {

          title: {

            display: true,

            text: 'Perangkat'

          },

          ticks: {

            maxRotation: 20,

            minRotation: 0

          }

        }

      }

    }

  });

}

</script>


</body>

</html>
