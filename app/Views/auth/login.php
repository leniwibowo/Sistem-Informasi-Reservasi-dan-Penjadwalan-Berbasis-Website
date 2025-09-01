<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DL Dental</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Customizing Tailwind's default theme to add our color palette
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
                        },
                    }
                }
            }
        }
    </script>
    <style>
        /* Menambahkan background pattern yang halus */
        .pattern-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230ea5e9' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="bg-sky-50 font-sans">

    <div class="flex min-h-screen items-center justify-center p-4">

        <div class="w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl flex flex-col md:flex-row">

            <div class="hidden md:flex md:w-1/2 items-center justify-center bg-sky-600 p-12 text-white pattern-bg">
                <div class="text-center">
                    <h1 class="mt-4 text-3xl font-bold">DL Dental</h1>
                    <p class="mt-2 text-sky-100">Mari menjaga kesehatan gigi mulai hari ini!.</p>
                </div>
            </div>

            <div class="w-full p-8 md:p-12 md:w-1/2">
                <div class="mb-8 text-center">
                    <img src="<?= base_url('assets/image/logo.png') ?>" alt="Ikon DL Dental" class="mx-auto" style="height: 100px; width: auto;">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
                    <p class="text-gray-500 mt-1">Silakan masuk ke akun Anda.</p>
                </div>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-md relative mb-6" role="alert">
                        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="post" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="bi bi-person text-gray-400"></i>
                            </span>
                            <input type="text" name="username" id="username" class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        </div>
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="bi bi-lock text-gray-400"></i>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" id="password" class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-10 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-right text-sm">
                        <a href="<?= base_url('auth/lupa-password') ?>" class="font-medium text-sky-600 hover:text-sky-700">
                            Lupa Password?
                        </a>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200">
                            Login
                        </button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="<?= base_url('register') ?>" class="font-medium text-sky-600 hover:text-sky-700">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>