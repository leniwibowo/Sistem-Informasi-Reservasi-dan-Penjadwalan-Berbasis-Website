<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Data Admin</h2>

    <!--  pesan error validasi jika ada -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-5" role="alert">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- form action disesuaikan dengan route -->
    <form method="post" action="<?= base_url('/admin/updateadmin/' . $admin['id_admin']); ?>">
        <?= csrf_field(); ?>

        <div class="mb-4">
            <label for="nama" class="block text-gray-700 text-sm font-semibold mb-2">Nama Admin</label>
            <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= esc($admin['nama']) ?>" required>
        </div>

        <div class="mb-4">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= esc($admin['username']) ?>" required>
        </div>

        <div class="mb-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Kosongkan jika tidak ingin diubah">
            <small class="text-gray-500">Biarkan kosong jika Anda tidak ingin mengubah password.</small>
        </div>

        <div class="flex items-center justify-between mt-8">
            <a href="<?= base_url('/admin/kelolaadmin'); ?>" class="px-6 py-2 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Kembali
            </a>
            <button type="submit" class="px-6 py-2 bg-sky-600 text-white font-bold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>