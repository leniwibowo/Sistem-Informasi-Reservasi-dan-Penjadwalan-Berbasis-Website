<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah Dokter Baru</h2>
        <!-- tambah dokter -->
        <form method="post" action="<?= base_url('/admin/simpandokter'); ?>">
            <?= csrf_field(); ?>

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-semibold mb-2">Nama Dokter</label>
                <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Masukkan nama lengkap dokter" required>
            </div>

            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 text-sm font-semibold mb-2">No. Handphone</label>
                <input type="tel" name="no_hp" id="no_hp" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                <input type="text" name="username" id="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Username untuk login" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Password untuk login" required>
            </div>

            <div class="flex justify-between items-center mt-8">
                <a href="<?= base_url('/admin/keloladokter'); ?>" class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 bg-sky-600 text-white font-bold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200">
                    Simpan Dokter
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>