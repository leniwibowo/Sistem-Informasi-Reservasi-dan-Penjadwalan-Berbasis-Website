<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Riwayat Pemeriksaan</h1>
    <a href="<?= site_url('admin/kelolapasien') ?>"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
        ← Antrian Pasien
    </a>
</div>

<!-- riwayat pemersiksaan -->
<div class="p-6 mb-6 bg-white rounded-lg shadow-md">
    <h2 class="pb-2 mb-4 text-xl font-semibold text-gray-700 border-b border-gray-200">Data Pasien</h2>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <h3 class="mb-3 font-semibold text-sea-blue-700">Data Diri</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">No. RM</span>
                    <span class="text-gray-800"><?= esc($pasien['no_RM']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Nama</span>
                    <span class="text-gray-800"><?= esc($pasien['nama']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Tanggal Lahir</span>
                    <span class="text-gray-800"><?= date('d F Y', strtotime($pasien['tanggal_lahir'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Jenis Kelamin</span>
                    <span class="text-gray-800"><?= esc($pasien['jenis_kelamin']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">No. Telepon</span>
                    <span class="text-gray-800"><?= esc($pasien['no_hp']) ?></span>
                </div>
            </div>
        </div>
        <div>
            <h3 class="mb-3 font-semibold text-sea-blue-700">Data Medis</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Golongan Darah</span>
                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full"><?= esc($pasien['golongan_darah']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Alergi</span>
                    <span class="text-gray-800"><?= esc($pasien['alergi'] ?: '-') ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Penyakit Jantung</span>
                    <span class="text-gray-800"><?= esc($pasien['penyakit_jantung']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Diabetes</span>
                    <span class="text-gray-800"><?= esc($pasien['diabetes']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- destop -->
<div class="hidden md:block overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">Dokter</th>
                <th class="px-6 py-3">Keluhan</th>
                <th class="px-6 py-3">Diagnosis</th>
                <th class="px-6 py-3">Tindakan</th>
                <th class="px-6 py-3">Catatan</th>
                <th class="px-6 py-3">Resep</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($riwayat)): ?>
                <?php $no = 1;
                foreach ($riwayat as $row): ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><?= $no++ ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?= date('d M Y', strtotime($row['waktu'])) ?></td>
                        <td class="px-6 py-4"><?= esc($row['nama_dokter']) ?></td>
                        <td class="px-6 py-4"><?= esc($row['keluhan']) ?></td>
                        <td class="px-6 py-4"><?= esc($row['diagnosis']) ?></td>
                        <td class="px-6 py-4"><?= esc($row['tindakan']) ?></td>
                        <td class="px-6 py-4"><?= esc($row['catatan']) ?></td>
                        <td class="px-6 py-4"><?= esc($row['resep']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada riwayat pemeriksaan.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- mobile -->
<div class="block md:hidden space-y-4">
    <?php if (!empty($riwayat)): ?>
        <?php $no = 1;
        foreach ($riwayat as $row): ?>
            <div class="p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between mb-2">
                    <span class="font-semibold text-gray-700">No</span>
                    <span><?= $no++ ?></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-semibold text-gray-700">Tanggal</span>
                    <span><?= date('d M Y', strtotime($row['waktu'])) ?></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-semibold text-gray-700">Dokter</span>
                    <span><?= esc($row['nama_dokter']) ?></span>
                </div>
                <div class="mb-2">
                    <span class="block font-semibold text-gray-700">Keluhan</span>
                    <span><?= esc($row['keluhan']) ?></span>
                </div>
                <div class="mb-2">
                    <span class="block font-semibold text-gray-700">Diagnosis</span>
                    <span><?= esc($row['diagnosis']) ?></span>
                </div>
                <div class="mb-2">
                    <span class="block font-semibold text-gray-700">Tindakan</span>
                    <span><?= esc($row['tindakan']) ?></span>
                </div>
                <div class="mb-2">
                    <span class="block font-semibold text-gray-700">Catatan</span>
                    <span><?= esc($row['catatan']) ?></span>
                </div>
                <div>
                    <span class="block font-semibold text-gray-700">Resep</span>
                    <span><?= esc($row['resep']) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="p-4 text-center text-gray-500 bg-white rounded-lg shadow">
            Belum ada riwayat pemeriksaan.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>