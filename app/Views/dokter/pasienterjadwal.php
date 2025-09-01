<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Pasien Terjadwal
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-start mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Pasien Terjadwal</h1>
        <p class="mt-1 text-gray-500">Daftar semua pasien yang dijawalkan ulang.</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm">

    <div class="overflow-x-auto hidden lg:block">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4">No</th>
                    <th scope="col" class="px-6 py-4">No. RM</th>
                    <th scope="col" class="px-6 py-4">Nama Pasien</th>
                    <th scope="col" class="px-6 py-4">Dokter Pemeriksa</th>
                    <th scope="col" class="px-6 py-4">Tanggal Periksa</th>
                    <th scope="col" class="px-6 py-4">Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($jadwal)) : ?>
                    <?php $no = 1; // Sesuaikan dengan logika paginasi Anda 
                    ?>
                    <?php foreach ($jadwal as $j) : ?>
                        <tr class="bg-white border-b hover:bg-gray-50 align-top">
                            <td class="px-6 py-4 text-gray-800"><?= $no++ ?></td>
                            <td class="px-6 py-4 font-mono text-gray-700"><?= esc($j['no_RM']); ?></td>
                            <td class="px-6 py-4 font-semibold text-gray-900"><?= esc($j['nama_pasien']); ?></td>
                            <td class="px-6 py-4"><?= esc($j['nama_dokter']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= date('d F Y', strtotime($j['tanggal_pemeriksaan'])); ?></td>
                            <td class="px-6 py-4">
                                <p class="max-w-xs truncate" title="<?= esc($j['pemeriksaan']); ?>">
                                    <?= esc($j['pemeriksaan'] ?? '-'); ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">
                            <div class="text-center text-gray-500 py-16">
                                <i class="bi bi-file-earmark-x text-6xl"></i>
                                <p class="mt-4 text-lg font-medium">Data Tidak Ditemukan</p>
                                <p class="mt-1 text-sm">Belum ada pasien yang terjadwalkan.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="block lg:hidden">
        <div class="p-4 space-y-4">
            <?php if (!empty($jadwal)) : ?>
                <?php $no = 1; // Sesuaikan dengan logika paginasi Anda 
                ?>
                <?php foreach ($jadwal as $j) : ?>
                    <div class="p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-mono text-sm text-sea-blue-700 bg-sea-blue-100 px-2 py-0.5 rounded"><?= esc($j['no_RM']); ?></span>
                            <span class="text-sm font-bold text-gray-700">#<?= $no++ ?></span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Nama Pasien</p>
                                <p class="font-semibold text-gray-800"><?= esc($j['nama_pasien']); ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Dokter & Tgl Periksa</p>
                                <p class="text-sm text-gray-600"><?= esc($j['nama_dokter']); ?> &bull; <?= date('d M Y', strtotime($j['tanggal_pemeriksaan'])); ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Catatan Pemeriksaan</p>
                                <p class="text-sm text-gray-600 truncate">
                                    <?= esc($j['pemeriksaan'] ?? '-'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="text-center text-gray-500 py-16">
                    <i class="bi bi-file-earmark-x text-6xl"></i>
                    <p class="mt-4 text-lg font-medium">Data Tidak Ditemukan</p>
                    <p class="mt-1 text-sm">Belum ada riwayat pemeriksaan pasien yang tercatat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($jadwal)) : ?>
        <div class="p-4 sm:p-6 border-t bg-gray-50">
            <nav class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                <span class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold">1</span>-<span class="font-semibold">10</span> dari <span class="font-semibold">50</span> hasil
                </span>
                <div class="inline-flex -space-x-px text-sm">
                    <a href="#" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100">Sebelumnya</a>
                    <a href="#" class="px-3 h-8 text-white bg-sea-blue-600 border border-sea-blue-600">1</a>
                    <a href="#" class="px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">2</a>
                    <a href="#" class="px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100">Selanjutnya</a>
                </div>
            </nav>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>