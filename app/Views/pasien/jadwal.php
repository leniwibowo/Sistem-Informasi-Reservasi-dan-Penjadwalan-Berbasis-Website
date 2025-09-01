<?= $this->extend('templates/pasien_layout') ?>

<?= $this->section('title') ?>
Jadwal Kunjungan Saya
<?= $this->endSection() ?>

<?php
// Helper untuk status badge, agar kode lebih bersih
function getStatusBadge($status)
{
    $status_text = esc(str_replace('_', ' ', $status));
    $base_class = "px-2.5 py-1 text-xs font-semibold rounded-full";
    switch ($status) {
        case 'Menunggu':
            return "<span class=\"{$base_class} bg-yellow-100 text-yellow-800\">{$status_text}</span>";
        case 'Selesai':
            return "<span class=\"{$base_class} bg-green-100 text-green-800\">{$status_text}</span>";
        case 'Dibatalkan':
            return "<span class=\"{$base_class} bg-red-100 text-red-800\">{$status_text}</span>";
        default:
            return "<span class=\"{$base_class} bg-gray-100 text-gray-800\">{$status_text}</span>";
    }
}
?>

<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Jadwal Kunjungan Saya</h1>
    <p class="mt-1 text-gray-500">Berikut adalah daftar semua jadwal kunjungan Anda yang akan datang dan yang telah lalu.</p>
</div>

<!-- jadwal pemeriksaan pasien -->
<?php if (!empty($jadwal_pasien)): ?>

    <div class="hidden md:block bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4">Hari / Tanggal</th>
                    <th scope="col" class="px-6 py-4">No. Antrian</th>
                    <th scope="col" class="px-6 py-4">Dokter</th>
                    <th scope="col" class="px-6 py-4">Keluhan</th>
                    <th scope="col" class="px-6 py-4 text-center">Status</th>

            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($jadwal_pasien as $jadwal): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <?= date('l, d F Y', strtotime($jadwal['tanggal'])) ?>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-700">
                            <?= esc($jadwal['no_antrian']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= esc($jadwal['nama_dokter'] ?? '-') ?>
                        </td>
                        <td class="px-6 py-4">
                            <p class="max-w-xs truncate"><?= esc($jadwal['keluhan'] ?? '-') ?></p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?= getStatusBadge($jadwal['status']) ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="md:hidden grid grid-cols-1 gap-4">
        <?php foreach ($jadwal_pasien as $jadwal): ?>
            <div class="bg-white p-4 border border-gray-200 rounded-xl shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-gray-800"><?= date('l, d F Y', strtotime($jadwal['tanggal'])) ?></p>
                        <p class="text-xs text-gray-500">No. Antrian: <span class="font-semibold text-gray-700"><?= esc($jadwal['no_antrian']) ?></span></p>
                    </div>
                    <?= getStatusBadge($jadwal['status']) ?>
                </div>
                <div class="text-sm space-y-2 border-t pt-3">
                    <div class="flex justify-between">
                        <p class="text-gray-500">Dokter</p>
                        <p class="font-semibold text-gray-800 text-right"><?= esc($jadwal['nama_dokter'] ?? '-') ?></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-gray-500">Keluhan</p>
                        <p class="font-semibold text-gray-800 text-right"><?= esc($jadwal['keluhan'] ?? '-') ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <div class="text-center py-16 bg-white border border-gray-200 rounded-xl shadow-sm">
        <i class="bi bi-calendar2-x-fill text-5xl text-gray-300"></i>
        <p class="mt-4 font-semibold text-gray-700">Belum Ada Jadwal</p>
        <p class="text-gray-500 mt-1">Anda belum pernah membuat jadwal kunjungan.</p>
        <a href="<?= base_url('/antrian') ?>" class="mt-4 inline-block px-5 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg shadow-md hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
            Buat Jadwal Baru
        </a>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>