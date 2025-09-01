<!-- mengambil dari template -->
<?= $this->extend('templates/pasien_layout') ?>

<?= $this->section('title') ?>
Dashboard Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- tampilan dashboard -->
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Selamat Datang, <?= esc($pasien['nama']) ?>!</h1>
    <p class="mt-1 text-gray-500">Ayo jaga kesehatan gigi mulai dari sekarang!!</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- status antrian-->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Antrian Anda Hari Ini</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                <!-- no antrian -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Nomor Antrian Anda</p>
                    <p class="text-3xl sm:text-4xl font-bold text-sky-600 mt-1"><?= esc($nomor_antrian_anda) ?></p>
                </div>
                <!-- antrian saat ini -->
                <div class="py-4 sm:py-0 border-y sm:border-y-0 sm:border-x border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Antrian Saat Ini</p>
                    <p class="text-3xl sm:text-4xl font-bold text-gray-800 mt-1"><?= esc($antrian_sekarang) ?></p>
                </div>
                <!-- perkiraan menunggu -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Perkiraan Menunggu</p>
                    <p class="text-3xl sm:text-4xl font-bold text-gray-800 mt-1">
                        <?= esc($sisa_antrian) ?>
                        <span class="text-base sm:text-lg font-medium text-gray-500"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- jadwal kunjungan berikutnya  -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Jadwal Kunjungan Berikutnya</h3>
                <?php if (!empty($jadwal)): ?>
                    <span class="px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Dikonfirmasi</span>
                <?php endif; ?>
            </div>
            <!--  dokter yang memeriksa-->
            <?php if (!empty($jadwal)): ?>
                <div class="flex items-center space-x-3 p-3 sm:p-4 bg-gray-50 rounded-lg">
                    <i class="bi bi-calendar2-check-fill text-2xl sm:text-3xl text-sky-600"></i>
                    <div>
                        <p class="text-base sm:text-lg font-bold text-gray-900"><?= date('l, d F Y', strtotime($jadwal['tanggal_pemeriksaan'])) ?></p>
                        <p class="text-sm text-gray-500">dengan <?= esc($jadwal['nama_dokter']) ?></p>
                    </div>
                </div>
                <!-- tidak memiliki jadwal kunjungan -->
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="bi bi-calendar2-x-fill text-4xl text-gray-300"></i>
                    <p class="mt-2 text-gray-500">Anda tidak memiliki jadwal kunjungan.</p>
                    <!-- pendaftaran -->
                    <a href="<?= base_url('/antrian') ?>" class="mt-4 inline-block px-5 py-2.5 text-sm font-medium text-white bg-sky-600 rounded-lg shadow-md hover:bg-sky-700">
                        Buat Janji Temu Baru
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="space-y-8">
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
            <!-- untuk pendaftaran -->
            <div class="space-y-3">
                <a href="<?= base_url('/antrian') ?>" class="flex items-center justify-between w-full p-4 bg-sky-50 hover:bg-sky-100 rounded-lg transition-colors">
                    <span class="font-semibold text-sky-800">Buat Janji Temu Baru</span>
                    <i class="bi bi-chevron-right text-sky-800"></i>
                </a>
                <!-- untuk melihat riwayat -->
                <a href="<?= base_url('/riwayat_pemeriksaan') ?>" class="flex items-center justify-between w-full p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <span class="font-semibold text-gray-800">Lihat Semua Riwayat</span>
                    <i class="bi bi-chevron-right text-gray-800"></i>
                </a>
            </div>
        </div>
        <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-xl">
            <div class="flex items-start space-x-4">
                <i class="bi bi-info-circle-fill text-2xl text-yellow-500 mt-1"></i>
                <!-- pengingat pasien -->
                <div>
                    <h3 class="text-lg font-semibold text-yellow-900">Pengingat</h3>
                    <p class="mt-1 text-sm text-yellow-800">Jangan lupa untuk melakukan kontrol rutin.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- menampilkan riwayat pemeriksaan terkahir -->
<div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="p-5 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Riwayat Pemeriksaan Terakhir</h3>
        <a href="<?= base_url('/riwayat_pemeriksaan') ?>" class="text-sm font-medium text-sky-600 hover:underline">Lihat Semua</a>
    </div>
    <!-- menampilan data riwayat terkhair pemeriksaan -->
    <?php if (!empty($riwayat)): ?>
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full table-fixed text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-40">Tanggal</th>
                        <th scope="col" class="px-6 py-3 w-48">Dokter</th>
                        <th scope="col" class="px-6 py-3">Diagnosis</th>
                        <th scope="col" class="px-6 py-3">Resep</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($riwayat as $r): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= date('d M Y', strtotime($r['waktu'])) ?></td>
                            <td class="px-6 py-4">Dr. <?= esc($r['nama_dokter']) ?></td>
                            <td class="px-6 py-4 break-words"><?= esc($r['diagnosis']) ?></td>
                            <td class="px-6 py-4 break-words"><?= esc($r['resep']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="md:hidden p-4 space-y-4">
            <?php foreach ($riwayat as $r): ?>
                <div class="p-4 border rounded-lg">
                    <p class="font-semibold text-gray-800 mb-2 pb-2 border-b"><?= date('d F Y', strtotime($r['waktu'])) ?></p>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500">Dokter</p>
                            <p class="font-medium text-gray-900 mt-0.5">Dr. <?= esc($r['nama_dokter']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Diagnosis</p>
                            <p class="font-medium text-gray-900 mt-0.5"><?= esc($r['diagnosis']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Resep</p>
                            <p class="font-medium text-gray-900 mt-0.5"><?= esc($r['resep']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-8 px-4">
            <i class="bi bi-folder2-open text-4xl text-gray-300"></i>
            <p class="mt-2 text-sm font-semibold text-gray-600">Belum ada riwayat pemeriksaan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>