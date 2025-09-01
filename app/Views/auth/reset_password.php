<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | KlinikKita</title>
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
</head>

<body class="bg-sky-50 font-sans">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="p-8 md:p-12">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-800">Buat Password Baru</h2>
                    <p class="text-gray-500 mt-1">Silakan masukkan password baru Anda.</p>
                </div>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-md relative mb-6" role="alert">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('reset-password') ?>" method="post" class="space-y-6" x-data="{ show: false, showConfirm: false }">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= esc($token, 'attr') ?>">

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <div class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password" id="password" class="block w-full rounded-md border-gray-300 py-3 pl-4 pr-10 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="pass_confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="relative mt-1">
                            <input :type="showConfirm ? 'text' : 'password'" name="pass_confirm" id="pass_confirm" class="block w-full rounded-md border-gray-300 py-3 pl-4 pr-10 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <i class="bi" :class="showConfirm ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>