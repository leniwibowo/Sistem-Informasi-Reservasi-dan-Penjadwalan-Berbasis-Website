<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pasien | KlinikKita</title>

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

        /* Custom styling untuk select agar konsisten */
        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    </style>
</head>

<body class="bg-sky-50 font-sans">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-2xl flex flex-col md:flex-row">
            <div class="hidden md:flex md:w-5/12 lg:w-1/3 items-center justify-center bg-sky-600 p-12 text-white pattern-bg">
                <div class="text-center">
                    <h1 class="mt-4 text-3xl font-bold">DL Dental</h1>
                    <p class="mt-2 text-sky-100">Mari menjaga kesehatan gigi mulai hari ini!.</p>
                </div>
            </div>
            <div class="w-full p-8 md:p-10 md:w-7/12 lg:w-2/3 overflow-y-auto" style="max-height: 95vh;">
                <div class="mb-8">
                    <img src="<?= base_url(relativePath: 'assets/image/logo.png') ?>" alt="Ikon DL Dental" class="" style="height: 100px; width: auto;">
                    <h2 class="text-3xl font-bold text-gray-800">Registrasi Pasien Baru</h2>
                    <p class="text-gray-500 mt-1">Silakan lengkapi data di bawah ini.</p>
                </div>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-md mb-6" role="alert">
                        <p class="font-bold mb-2">Terjadi Kesalahan</p>
                        <ul class="list-disc list-inside text-sm">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('register') ?>" method="post" class="space-y-8">
                    <?= csrf_field() ?>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-6">Data Diri</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" name="nik" id="nik" placeholder="Wajib 16 digit angka" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="<?= old('nik') ?>" required>
                            </div>
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" placeholder="Sesuai KTP" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="<?= old('nama') ?>" required>
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="<?= old('tanggal_lahir') ?>" required>
                            </div>
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="tel" name="no_hp" id="no_hp" placeholder="081234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="<?= old('no_hp') ?>" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" placeholder="Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" required><?= old('alamat') ?></textarea>
                            </div>
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 custom-select appearance-none" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="laki-laki" <?= old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="perempuan" <?= old('jenis_kelamin') == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-6">Informasi Medis</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 custom-select appearance-none" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="A" <?= old('golongan_darah') == 'A' ? 'selected' : '' ?>>A</option>
                                    <option value="B" <?= old('golongan_darah') == 'B' ? 'selected' : '' ?>>B</option>
                                    <option value="AB" <?= old('golongan_darah') == 'AB' ? 'selected' : '' ?>>AB</option>
                                    <option value="O" <?= old('golongan_darah') == 'O' ? 'selected' : '' ?>>O</option>
                                    <option value="-" <?= old('golongan_darah') == '-' ? 'selected' : '' ?>>Tidak Tahu</option>
                                </select>
                            </div>
                            <div>
                                <label for="alergi" class="block text-sm font-medium text-gray-700">Riwayat Alergi</label>
                                <input type="text" name="alergi" id="alergi" placeholder="Udang, Debu, atau isi 'Tidak Ada'" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="<?= old('alergi') ?>" required>
                            </div>
                            <div>
                                <label for="diabetes" class="block text-sm font-medium text-gray-700">Riwayat Diabetes</label>
                                <select name="diabetes" id="diabetes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 custom-select appearance-none" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" <?= old('diabetes') == 'ya' ? 'selected' : '' ?>>Ya</option>
                                    <option value="tidak" <?= old('diabetes') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                                </select>
                            </div>
                            <div>
                                <label for="penyakit_jantung" class="block text-sm font-medium text-gray-700">Riwayat Penyakit Jantung</label>
                                <select name="penyakit_jantung" id="penyakit_jantung" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 custom-select appearance-none" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" <?= old('penyakit_jantung') == 'ya' ? 'selected' : '' ?>>Ya</option>
                                    <option value="tidak" <?= old('penyakit_jantung') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-6">Akun Login</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" id="username" placeholder="Buat username unik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="<?= old('username') ?>" required>
                            </div>
                            <div x-data="{ show: false }">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="relative mt-1">
                                    <input :type="show ? 'text' : 'password'" name="password" id="password" placeholder="Minimal 5 karakter" class="block w-full rounded-md border-gray-300 shadow-sm pr-10 focus:border-sky-500 focus:ring-sky-500" required>
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                        <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200">
                            Daftar Akun Baru
                        </button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="<?= base_url('login') ?>" class="font-medium text-sky-600 hover:text-sky-700">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>