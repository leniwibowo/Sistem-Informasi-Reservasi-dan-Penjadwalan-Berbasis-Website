<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah Data Pasien Baru</h2>
    <!-- pesan error -->
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
    <!-- tambah pasien -->
    <form action="<?= base_url('admin/simpanPasien') ?>" method="post">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
            <div>
                <div class="mb-4">
                    <label for="nik" class="block text-gray-700 text-sm font-semibold mb-2">NIK</label>
                    <input type="text" id="nik" name="nik" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= old('nik') ?>" required placeholder="3402031408000001" maxlength="16" pattern="\d{16}" title="NIK harus terdiri dari 16 digit angka">
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= old('nama') ?>" required placeholder="Budi Santoso">
                </div>
                <div class="mb-4">
                    <label for="tanggal_lahir" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= old('tanggal_lahir') ?>" required>
                </div>
                <div class="mb-4">
                    <label for="no_hp" class="block text-gray-700 text-sm font-semibold mb-2">Nomor Telepon</label>
                    <input type="tel" id="no_hp" name="no_hp" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= old('no_hp') ?>" required placeholder="081234567890">
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 text-sm font-semibold mb-2">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Jl. Merdeka No. 17, Kasihan, Bantul"><?= old('alamat') ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                        <option value="" disabled <?= old('jenis_kelamin') ? '' : 'selected' ?>>-- Pilih Jenis Kelamin --</option>
                        <option value="laki-laki" <?= old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="perempuan" <?= old('jenis_kelamin') == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
            </div>

            <div>
                <div class="mb-4">
                    <label for="golongan_darah" class="block text-gray-700 text-sm font-semibold mb-2">Golongan Darah</label>
                    <select id="golongan_darah" name="golongan_darah" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                        <option value="" disabled <?= old('golongan_darah') ? '' : 'selected' ?>>-- Pilih Golongan Darah --</option>
                        <option value="A" <?= old('golongan_darah') == 'A' ? 'selected' : '' ?>>A</option>
                        <option value="B" <?= old('golongan_darah') == 'B' ? 'selected' : '' ?>>B</option>
                        <option value="AB" <?= old('golongan_darah') == 'AB' ? 'selected' : '' ?>>AB</option>
                        <option value="O" <?= old('golongan_darah') == 'O' ? 'selected' : '' ?>>O</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="alergi" class="block text-gray-700 text-sm font-semibold mb-2">Riwayat Alergi</label>
                    <input type="text" id="alergi" name="alergi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= old('alergi') ?>" placeholder="Isi 'Tidak ada' jika tidak ada" required>
                </div>
                <div class="mb-4">
                    <label for="diabetes" class="block text-gray-700 text-sm font-semibold mb-2">Riwayat Diabetes</label>
                    <select id="diabetes" name="diabetes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                        <option value="tidak" <?= old('diabetes', 'tidak') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                        <option value="ya" <?= old('diabetes') == 'ya' ? 'selected' : '' ?>>Ya</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="penyakit_jantung" class="block text-gray-700 text-sm font-semibold mb-2">Riwayat Penyakit Jantung</label>
                    <select id="penyakit_jantung" name="penyakit_jantung" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                        <option value="tidak" <?= old('penyakit_jantung', 'tidak') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                        <option value="ya" <?= old('penyakit_jantung') == 'ya' ? 'selected' : '' ?>>Ya</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" value="<?= old('username') ?>" required placeholder="budi.s">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Minimal 5 karakter">
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-sky-600 text-white font-bold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200">
                <i class="bi bi-person-plus-fill mr-2"></i> Tambah Pasien
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>