<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?: 'Admin Dashboard' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif']
                    },
                    colors: {
                        'sky': { // Mengganti 'sea-blue' menjadi 'sky' agar konsisten dengan Tailwind
                            '50': '#f0f9ff',
                            '100': '#e0f2fe',
                            '200': '#bae6fd',
                            '300': '#7dd3fc',
                            '400': '#38bdf8',
                            '500': '#0ea5e9',
                            '600': '#0284c7',
                            '700': '#0369a1',
                            '800': '#075985',
                            '900': '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Menyesuaikan tampilan Select2 agar cocok dengan Tailwind CSS */
        .select2-container .select2-selection--single {
            height: 46px !important;
            /* Sesuaikan dengan tinggi input */
            border-radius: 0.5rem !important;
            border: 1px solid #D1D5DB !important;
            /* Warna border gray-300 */
            background-color: #F9FAFB;
            /* Warna background gray-50 */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px !important;
            padding-left: 1rem !important;
            color: #111827;
            /* Warna teks gray-900 */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
            right: 0.75rem !important;
        }

        .select2-container--open .select2-dropdown--below {
            border-radius: 0.5rem !important;
            border-color: #38BDF8 !important;
            /* Warna border sky-500 */
        }

        .select2-search--dropdown .select2-search__field {
            border-radius: 0.375rem !important;
            border: 1px solid #D1D5DB !important;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">

    <?php
    $uri = service('uri');
    // ambil path lengkap untuk perbandingan
    $path = $uri->getPath();
    $base_class = "flex items-center w-full px-4 py-2.5 rounded-lg transition-colors duration-200";
    $active_class = "bg-sky-600 text-white shadow";
    $inactive_class = "text-gray-600 hover:bg-sky-100 hover:text-sky-700";
    ?>

    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-black/50 transition-opacity lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <aside
            class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 h-full px-5 py-6 overflow-y-auto bg-white border-r transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
            :class="{'translate-x-0': sidebarOpen}">

            <a href="#" class="flex items-center mb-8 text-2xl font-bold text-gray-800">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStTTZUrtEDMUqe8T-pAy7jLiPVWf7cjv3SjA&s" alt="Ikon DL Dental" class="mr-3" style="height: 56px; width: auto;">
                <span>DL Dental</span>
            </a>
            <!-- sidebar -->
            <div class="flex flex-col justify-between flex-1">
                <nav class="space-y-2">
                    <a href="<?= base_url('/admin/dashboard') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/dashboard') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-house-door-fill w-5 h-5 mr-3"></i> Dashboard
                    </a>
                    <a href="<?= base_url('/admin/antrian') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/antrian') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-person-badge-fill w-5 h-5 mr-3"></i> Antrian Pasien
                    </a>
                    <a href="<?= base_url('/admin/kelolapasien') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/kelolapasien') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-person-lines-fill w-5 h-5 mr-3"></i> Kelola Pasien
                    </a>
                    <a href="<?= base_url('/admin/keloladokter') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/keloladokter') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-person-vcard-fill w-5 h-5 mr-3"></i> Kelola Dokter
                    </a>
                    <a href="<?= base_url('/admin/kelolajadwal') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/kelolajadwal') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-calendar2-week-fill w-5 h-5 mr-3"></i> Kelola Jadwal Dokter
                    </a>
                    <a href="<?= base_url('/admin/kelolaadmin') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/kelolaadmin') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-person-gear w-5 h-5 mr-3"></i> Kelola Admin
                    </a>
                    <a href="<?= base_url('/admin/pasienterjadwal') ?>" class="<?= $base_class ?> <?= str_contains($path, 'admin/pasienterjadwal') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-calendar-event-fill w-5 h-5 mr-3"></i> Pasien Terjadwal
                    </a>
                </nav>
            </div>
        </aside>
        <!-- sidebar end -->

        <div class="flex flex-col flex-1">
            <header class="flex items-center justify-between h-16 px-6 py-2 bg-white shadow-sm border-b">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <h3 class="text-lg font-medium text-gray-700 ml-4 lg:ml-0">
                        <?= $this->renderSection('title') ?: 'Dashboard Admin' ?>
                    </h3>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative z-10 block p-2 transition-colors duration-200 transform bg-white rounded-full hover:bg-gray-100 focus:outline-none">
                        <i class="bi bi-person-circle text-2xl text-gray-600"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        x-transition class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl" x-cloak>
                        <a href="<?= base_url('admin/profil') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-sky-50">Lihat Profil</a>
                        <div class="border-t border-gray-100"></div>
                        <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>