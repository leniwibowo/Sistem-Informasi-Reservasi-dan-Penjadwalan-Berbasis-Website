<?= $this->extend('templates/layout_admin') ?>
<?= $this->section('title') ?>
Pasien Terjadwal
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">
            Daftar Pasien Terjadwal (Hari Ini & Akan Datang)
        </h2>
        <!-- tombol jadwalkan pasien -->
        <a href="<?= base_url('/admin/jadwal_percobaan'); ?>" class="inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors duration-200 text-sm shadow-sm">
            <i class="bi bi-calendar-plus-fill mr-2"></i>
            Jadwalkan Pasien
        </a>
    </div>
    <!-- pesan -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5 rounded-lg" role="alert">
            <p class="font-bold">Sukses</p>
            <p><?= session()->getFlashdata('success'); ?></p>
        </div>
    <?php endif; ?>

    <!-- tabel untuk desktop -->
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-sky-700 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal Periksa</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">No RM</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama Pasien</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Dokter</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($jadwal_akan_datang)) : ?>
                    <?php foreach ($jadwal_akan_datang as $jadwal) : ?>
                        <tr class="border-b hover:bg-sky-50">
                            <td class="py-3 px-4 font-medium"><?= date('d M Y', strtotime($jadwal['tanggal_pemeriksaan'])) ?></td>
                            <td class="py-3 px-4 font-mono"><?= esc($jadwal['no_RM']) ?></td>
                            <td class="py-3 px-4 font-medium"><?= esc($jadwal['nama_pasien']) ?></td>
                            <td class="py-3 px-4">Dr. <?= esc($jadwal['nama_dokter']) ?></td>
                            <td class="text-center py-3 px-4">
                                <span class="px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full capitalize">
                                    <?= str_replace('_', ' ', esc($jadwal['status'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-8">
                            Belum ada pasien yang dijadwalkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- tampilan card mobile -->
    <div class="md:hidden space-y-4">
        <?php if (!empty($jadwal_akan_datang)) : ?>
            <?php foreach ($jadwal_akan_datang as $jadwal) : ?>
                <div class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Tanggal Periksa</p>
                    <p class="font-semibold"><?= date('d M Y', strtotime($jadwal['tanggal_pemeriksaan'])) ?></p>

                    <p class="text-sm text-gray-500 mt-2">No RM</p>
                    <p class="font-mono"><?= esc($jadwal['no_RM']) ?></p>

                    <p class="text-sm text-gray-500 mt-2">Nama Pasien</p>
                    <p class="font-medium"><?= esc($jadwal['nama_pasien']) ?></p>

                    <p class="text-sm text-gray-500 mt-2">Dokter</p>
                    <p>Dr. <?= esc($jadwal['nama_dokter']) ?></p>

                    <p class="text-sm text-gray-500 mt-2">Status</p>
                    <span class="inline-block mt-1 px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full capitalize">
                        <?= str_replace('_', ' ', esc($jadwal['status'])) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center text-gray-500 py-4">Belum ada pasien yang dijadwalkan.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>