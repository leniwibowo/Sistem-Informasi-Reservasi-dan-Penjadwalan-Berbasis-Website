<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?: 'Dashboard' ?> | DL Dental</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'sky': {
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
        body {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        /* scroll disamping kanan */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* scroll disamping kanan */
        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        /* scroll saat dipencet */
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <?php
    $uri = service('uri');
    $path = $uri->getPath();
    $base_class = "flex items-center w-full px-4 py-2.5 rounded-lg transition-colors duration-200";
    $active_class = "bg-sky-600 text-white shadow";
    $inactive_class = "text-gray-600 hover:bg-sky-50 hover:text-sky-700";
    ?>

    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50">
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black/50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>
        <!-- sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 h-full px-5 py-6 overflow-y-auto bg-white border-r transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
            :class="{'translate-x-0': sidebarOpen}">

            <a href="#" class="flex items-center mb-8 text-2xl font-bold text-gray-800">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStTTZUrtEDMUqe8T-pAy7jLiPVWf7cjv3SjA&s" alt="Ikon DL Dental" class="mr-3" style="height: 48px; width: auto;">
                <span>DL Dental</span>
            </a>

            <div class="flex flex-col justify-between flex-1">
                <nav class="space-y-2">
                    <!-- dashboard -->
                    <a href="<?= base_url('/dashboard') ?>" class="<?= $base_class ?> <?= str_contains($path, 'dashboard') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-house-door-fill h-5 w-5 mr-3"></i> Dashboard
                    </a>
                    <!-- pendaftaran pasiien-->
                    <a href="<?= base_url('/antrian') ?>" class="<?= $base_class ?> <?= str_contains($path, 'antrian') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-person-badge-fill h-5 w-5 mr-3"></i> Pendaftaran Pasien
                    </a>
                    <!-- jadwal -->
                    <a href="<?= base_url('/jadwal') ?>" class="<?= $base_class ?> <?= str_contains($path, 'jadwal') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-person-lines-fill h-5 w-5 mr-3"></i> Jadwal
                    </a>
                    <!-- riwayat -->
                    <a href="<?= base_url('/riwayat_pemeriksaan') ?>" class="<?= $base_class ?> <?= str_contains($path, 'riwayat_pemeriksaan') ? $active_class : $inactive_class ?>">
                        <i class="bi bi-easel2-fill h-5 w-5 mr-3"></i> Riwayat
                    </a>

                </nav>
            </div>
        </aside>
        <!-- sidebar end -->

        <!-- list sidebar -->
        <div class="flex flex-col flex-1 lg:ml-0">
            <header class="flex items-center justify-between h-16 px-6 py-2 bg-white shadow-sm">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <h3 class="text-lg font-medium text-gray-700 ml-4 lg:ml-0">
                        <?= $this->renderSection('title') ?: 'Dashboard' ?>
                    </h3>
                </div>
                <!-- end -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative z-10 block p-2 transition-colors duration-200 transform bg-white rounded-full hover:bg-gray-100 focus:outline-none">
                        <i class="bi bi-person-circle text-2xl text-gray-600"></i>

                    </button>
                    <? foreach ($pasien as $p): ?>
                        <div x-show="open" @click.away="open = false"

                            x-transition class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl">
                            <!-- profil pasien -->
                            <a href="<?= base_url('/profil') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Profil</a>
                            </a>
                            <!-- logout pasie -->
                            <div class="border-t border-gray-100"></div>
                            <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                        </div>
                    <? endforeach; ?>
                </div>
            </header>

            <main class="flex-1 p-4 md:p-6 overflow-x-hidden overflow-y-auto">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>

</body>

</html>