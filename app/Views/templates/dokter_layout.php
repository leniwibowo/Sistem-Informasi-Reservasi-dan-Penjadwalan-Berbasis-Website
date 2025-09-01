<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?: 'Dokter Dashboard' ?></title>

    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sea-blue': {
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
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body class="bg-gray-100">

    <?php
    $uri = service('uri');
    $current_segment = $uri->getSegment(2) ?: 'dashboard';
    $base_class     = "flex items-center px-4 py-2 rounded-lg transition-colors duration-200 transform";
    $active_class   = "bg-sea-blue-500 text-white shadow-md";
    $inactive_class = "text-gray-700 hover:bg-sea-blue-100 hover:text-sea-blue-700";
    ?>

    <div x-data="{ isSidebarOpen: false }" class="flex h-screen bg-gray-200">

        <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 lg:hidden" x-cloak></div>

        <div
            :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 px-4 py-6 overflow-y-auto bg-white shadow-md transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0"
            x-cloak>
            <a href="#" class="flex items-center mb-8 text-2xl font-bold text-gray-800">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStTTZUrtEDMUqe8T-pAy7jLiPVWf7cjv3SjA&s" alt="Ikon DL Dental" class="mr-3" style="height: 48px; width: auto;">
                <span>DL Dental</span>
            </a>

            <nav class="space-y-2">
                <a href="<?= base_url('/dokter/dashboard') ?>" class="<?= $base_class ?> <?= ($current_segment == 'dashboard') ? $active_class : $inactive_class ?>">
                    <i class="bi bi-house-door-fill h-6 w-6 mr-3"></i> Dashboard
                </a>
                <a href="<?= base_url('/dokter/antrian') ?>" class="<?= $base_class ?> <?= ($current_segment == 'antrian' || $current_segment == 'pemeriksaan') ? $active_class : $inactive_class ?>">
                    <i class="bi bi-person-badge-fill h-6 w-6 mr-3"></i> Antrian Pasien
                </a>
                <a href="<?= base_url('/dokter/datapasien') ?>" class="<?= $base_class ?> <?= ($current_segment == 'datapasien') ? $active_class : $inactive_class ?>">
                    <i class="bi bi-person-lines-fill h-6 w-6 mr-3"></i> Data Pasien
                </a>
                <a href="<?= base_url('/dokter/pasienterjadwal') ?>" class="<?= $base_class ?> <?= ($current_segment == 'pasienterjadwal') ? $active_class : $inactive_class ?>">
                    <i class="bi bi-calendar-check-fill h-6 w-6 mr-3"></i> Pasien Terjadwal
                </a>
            </nav>
        </div>

        <div class="flex flex-col flex-1 lg:ml-0">
            <header class="flex items-center justify-between h-16 px-6 py-2 bg-white shadow-sm">

                <div class="flex items-center">
                    <button @click="isSidebarOpen = !isSidebarOpen" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                        <i class="bi bi-list text-2xl"></i>
                    </button>

                    <h3 class="text-lg font-medium text-gray-700">
                        <?= $this->renderSection('title') ?: 'Dashboard' ?>
                    </h3>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative z-10 block p-2 transition-colors duration-200 transform bg-white rounded-full hover:bg-gray-100 focus:outline-none">
                        <i class="bi bi-person-circle text-2xl text-gray-600"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        x-transition
                        class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl"
                        x-cloak>
                        <a href="<?= base_url('dokter/profil/') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Profil</a>
                        <div class="border-t border-gray-100"></div>
                        <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 overflow-x-hidden overflow-y-auto">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <style>
        /* Mencegah 'kedipan' elemen Alpine saat halaman dimuat */
        [x-cloak] {
            display: none !important;
        }
    </style>

</body>

</html>