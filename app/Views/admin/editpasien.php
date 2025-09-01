<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Data Pasien</h2>

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
    <!-- edit pasien -->
    <form action="<?= base_url('/admin/updatepasien/' . $pasien['id_pasien']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="nik" class="block text-gray-700 text-sm font-semibold mb-2">NIK</label>
                    <input type="text" name="nik" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 bg-gray-100 cursor-not-allowed" id="nik" value="<?= esc($pasien['nik']) ?>" readonly>
                </div>

                <div class="mb-4">
                    <label for="no_RM" class="block text-gray-700 text-sm font-semibold mb-2">No RM</label>
                    <input type="text" name="no_RM" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 bg-gray-100 cursor-not-allowed" id="no_RM" value="<?= esc($pasien['no_RM']) ?>" readonly>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-semibold mb-2">Nama Pasien</label>
                    <input type="text" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="nama" value="<?= esc($pasien['nama']) ?>" required>
                </div>

                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="jenis_kelamin" required>
                        <option value="Laki-laki" <?= $pasien['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $pasien['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="tanggal_lahir" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 bg-gray-100 cursor-not-allowed" id="tanggal_lahir" value="<?= esc($pasien['tanggal_lahir']) ?>" readonly>
                </div>

                <div class="mb-4">
                    <label for="no_hp" class="block text-gray-700 text-sm font-semibold mb-2">Nomor HP</label>
                    <input type="text" name="no_hp" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="no_hp" value="<?= esc($pasien['no_hp']) ?>" required>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 text-sm font-semibold mb-2">Alamat</label>
                    <textarea name="alamat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="alamat" required><?= esc($pasien['alamat']) ?></textarea>
                </div>
            </div>

            <div>
                <div class="mb-4">
                    <label for="alergi" class="block text-gray-700 text-sm font-semibold mb-2">Alergi</label>
                    <input type="text" name="alergi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="alergi" value="<?= esc($pasien['alergi']) ?>">
                </div>

                <div class="mb-4">
                    <label for="golongan_darah" class="block text-gray-700 text-sm font-semibold mb-2">Golongan Darah</label>
                    <input type="text" name="golongan_darah" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="golongan_darah" value="<?= esc($pasien['golongan_darah']) ?>">
                </div>

                <div class="mb-4">
                    <label for="penyakit_jantung" class="block text-gray-700 text-sm font-semibold mb-2">Penyakit Jantung</label>
                    <input type="text" name="penyakit_jantung" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="penyakit_jantung" value="<?= esc($pasien['penyakit_jantung']) ?>">
                </div>

                <div class="mb-4">
                    <label for="diabetes" class="block text-gray-700 text-sm font-semibold mb-2">Diabetes</label>
                    <input type="text" name="diabetes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="diabetes" value="<?= esc($pasien['diabetes']) ?>">
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username (opsional)</label>
                    <input type="text" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="username" value="<?= esc($pasien['username']) ?>">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password (opsional)</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" id="password" placeholder="Isi jika ingin mengganti password">
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <button type="submit" class="px-6 py-2 bg-sky-600 text-white font-bold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200">
                Simpan Perubahan
            </button>
            <a href="<?= base_url('/admin/kelolapasien') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition-colors duration-200">
                Kembali
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>