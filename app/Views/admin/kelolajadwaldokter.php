<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('title') ?>
Kelola Jadwal Praktik Dokter
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mx-auto max-w-5xl">

    <!-- kelola jadwal dokter -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Sukses!</p>
            <p><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Gagal!</p>
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200 mb-8">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">Tambah Jadwal Praktik Baru</h2>
            <p class="text-gray-500 mt-1">Pilih dokter dan hari praktik untuk ditambahkan ke sistem.</p>
        </div>
        <form action="<?= base_url('admin/jadwal-dokter/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="id_dokter" class="block mb-2 text-sm font-medium text-gray-700">Dokter</label>
                    <select name="id_dokter" id="id_dokter" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" required>
                        <option value="" disabled selected>-- Pilih Dokter --</option>
                        <?php foreach ($dokter_list as $dokter) : ?>
                            <option value="<?= $dokter['id_dokter'] ?>"><?= esc($dokter['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="hari" class="block mb-2 text-sm font-medium text-gray-700">Hari Praktik</label>
                    <select name="hari" id="hari" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" required>
                        <option value="" disabled selected>-- Pilih Hari --</option>
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                    </select>
                </div>
                <div class="md:col-span-1">
                    <button type="submit" class="w-full flex items-center justify-center gap-x-2 text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg px-6 py-3 text-center transition-all">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Tambah Jadwal</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Daftar Jadwal Praktik Aktif</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Dokter</th>
                        <th scope="col" class="px-6 py-3">Hari</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($jadwal_dokter)) : ?>
                        <tr class="bg-white border-b">
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada jadwal praktik yang ditambahkan.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($jadwal_dokter as $jadwal) : ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4"><?= $no++ ?></td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <?= esc($jadwal['nama_dokter']) ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php
                                    // nama hari ke Bahasa Indonesia
                                    $hari_map = [
                                        'Monday'    => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday'  => 'Kamis',
                                        'Friday'  => 'Jumat',
                                        'Saturday'  => 'Sabtu',
                                        'Sunday'    => 'Minggu'
                                    ];
                                    echo $hari_map[$jadwal['hari']];
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?= base_url('admin/jadwal-dokter/hapus/' . $jadwal['id_jadwal_dokter']) ?>" class="font-medium text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>