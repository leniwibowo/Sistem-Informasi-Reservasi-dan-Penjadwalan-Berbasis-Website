<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Riwayat Pemeriksaan Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-start mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Riwayat Pemeriksaan</h1>
        <p class="mt-1 text-gray-500">Menampilkan seluruh riwayat medis untuk pasien yang dipilih.</p>
    </div>

</div>

<div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm mb-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-bold text-gray-900"><?= esc($pasien['nama']) ?></h2>
            <p class="text-sm text-gray-500">
                No. Rekam Medis:
                <span class="font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded-md"><?= esc($pasien['no_RM']) ?></span>
            </p>
        </div>
        <div class="mt-3 sm:mt-0 text-sm text-gray-600">
            <p><strong>Jenis Kelamin:</strong> <?= esc(ucfirst($pasien['jenis_kelamin'])) ?></p>
            <p><strong>Tanggal Lahir:</strong> <?= date('d F Y', strtotime($pasien['tanggal_lahir'])) ?></p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-4 pt-4 text-sm">
        <div>
            <p class="text-gray-500">No. Telepon</p>
            <p class="font-semibold text-gray-800"><?= esc($pasien['no_hp']) ?></p>
        </div>
        <div>
            <p class="text-gray-500">Golongan Darah</p>
            <p class="font-semibold text-gray-800"><?= esc($pasien['golongan_darah']) ?></p>
        </div>
        <div>
            <p class="text-gray-500">Alergi</p>
            <p class="font-semibold text-gray-800"><?= esc($pasien['alergi'] ?: '-') ?></p>
        </div>
        <div>
            <p class="text-gray-500">Riwayat Penyakit Jantung</p>
            <p class="font-semibold text-gray-800"><?= esc(ucfirst($pasien['penyakit_jantung'])) ?></p>
        </div>
        <div>
            <p class="text-gray-500">Riwayat Diabetes</p>
            <p class="font-semibold text-gray-800"><?= esc(ucfirst($pasien['diabetes'])) ?></p>
        </div>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
    <div class="p-5 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Detail Riwayat</h3>
    </div>

    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 w-12">No</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Dokter</th>
                    <th scope="col" class="px-6 py-3">Keluhan</th>
                    <th scope="col" class="px-6 py-3">Diagnosis</th>
                    <th scope="col" class="px-6 py-3">Tindakan</th>
                    <th scope="col" class="px-6 py-3">Catatan</th>
                    <th scope="col" class="px-6 py-3">Resep Obat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayat)): ?>
                    <?php $no = 1;
                    foreach ($riwayat as $row): ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= $no++ ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= date('d M Y', strtotime($row['waktu'])) ?></td>
                            <td class="px-6 py-4"><?= esc($row['nama_dokter']) ?></td>
                            <td class="px-6 py-4"><?= esc($row['keluhan']) ?></td>
                            <td class="px-6 py-4"><?= esc($row['diagnosis']) ?></td>
                            <td class="px-6 py-4"><?= esc($row['tindakan'] ?? '-') ?></td>
                            <td class="px-6 py-4"><?= esc($row['catatan'] ?? '-') ?></td>
                            <td class="px-6 py-4"><?= esc($row['resep']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="text-center py-12">
                                <i class="bi bi-file-earmark-medical text-5xl text-gray-300"></i>
                                <p class="mt-3 font-semibold text-gray-700">Belum Ada Riwayat Pemeriksaan</p>
                                <p class="text-gray-500 text-sm">Data riwayat pemeriksaan untuk pasien ini akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="block md:hidden">
        <?php if (!empty($riwayat)): ?>
            <div class="p-4 space-y-4">
                <?php $no = 1;
                foreach ($riwayat as $row): ?>
                    <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-gray-50 space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-gray-800">Kunjungan #<?= $no++ ?></p>
                                <p class="text-sm text-gray-600"><?= date('d F Y', strtotime($row['waktu'])) ?></p>
                            </div>
                            <span class="text-sm text-gray-600 font-medium"><?= esc($row['nama_dokter']) ?></span>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Keluhan:</p>
                            <p class="font-semibold text-gray-800"><?= esc($row['keluhan']) ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Diagnosis:</p>
                            <p class="font-semibold text-gray-800"><?= esc($row['diagnosis']) ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Tindakan:</p>
                            <p class="font-semibold text-gray-800"><?= esc($row['tindakan'] ?? '-') ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Resep Obat:</p>
                            <p class="font-semibold text-gray-800 whitespace-pre-wrap"><?= esc($row['resep']) ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Catatan:</p>
                            <p class="font-semibold text-gray-800 whitespace-pre-wrap"><?= esc($row['catatan']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="bi bi-file-earmark-medical text-5xl text-gray-300"></i>
                <p class="mt-3 font-semibold text-gray-700">Belum Ada Riwayat Pemeriksaan</p>
                <p class="text-gray-500 text-sm">Data riwayat pemeriksaan untuk pasien ini akan muncul di sini.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>