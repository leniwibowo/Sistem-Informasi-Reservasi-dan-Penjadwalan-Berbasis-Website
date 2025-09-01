<?= $this->extend('templates/layout_admin'); ?>

<?= $this->section('content'); ?>

<style>
    /* Mobile view */
    @media (max-width: 768px) {
        table.responsive-table thead {
            display: none;
            /* sembunyikan header di mobile */
        }

        table.responsive-table,
        table.responsive-table tbody,
        table.responsive-table tr,
        table.responsive-table td {
            display: block;
            width: 100%;
        }

        table.responsive-table tr {
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            /* gray-200 */
            border-radius: 0.5rem;
            /* rounded */
            padding: 0.75rem;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            /* shadow-sm */
        }

        table.responsive-table td {
            text-align: left;
            padding: 0.5rem 0;
            border: none !important;
        }

        table.responsive-table td::before {
            content: attr(data-label);
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
            color: #374151;
            /* gray-700 */
        }
    }
</style>

<div class="px-6 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar Antrian Pasien Hari Ini</h1>
    <p class="text-gray-600 mb-6">Halaman ini menampilkan daftar pasien yang sedang menunggu atau sedang dalam proses pemeriksaan.</p>

    <!-- pesan data -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')) : ?>
        <div class="mb-4 rounded-lg bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3">
            <?= session()->getFlashdata('info'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- daftar pasien yang memiliki antria -->
        <div class="bg-gray-50 px-4 py-3 border-b">
            <h6 class="font-semibold text-gray-700">Antrian Aktif</h6>
        </div>

        <div class="p-4">
            <table class="min-w-full border border-gray-200 text-sm text-gray-600 responsive-table">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b">No. Antrian</th>
                        <th class="px-4 py-3 border-b">No. RM</th>
                        <th class="px-4 py-3 border-b">Nama Pasien</th>
                        <th class="px-4 py-3 border-b">Status</th>
                        <th class="px-4 py-3 border-b w-52">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pasienTerdaftar)) : ?>
                        <?php foreach ($pasienTerdaftar as $pasien) : ?>
                            <tr class="hover:bg-gray-50">
                                <td data-label="No. Antrian" class="px-4 py-3 font-bold text-lg text-gray-800"><?= esc($pasien['no_antrian']); ?></td>
                                <td data-label="No. RM" class="px-4 py-3"><?= esc($pasien['no_RM']); ?></td>
                                <td data-label="Nama Pasien" class="px-4 py-3"><?= esc($pasien['nama_pasien']); ?></td>
                                <td data-label="Status" class="px-4 py-3">
                                    <?php
                                    $status = esc($pasien['status']);
                                    $badge_class = '';
                                    if ($status == 'Menunggu') {
                                        $badge_class = 'bg-yellow-100 text-yellow-800';
                                    } elseif ($status == 'Diperiksa') {
                                        $badge_class = 'bg-blue-100 text-blue-800';
                                    }
                                    ?>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full <?= $badge_class; ?>">
                                        <?= $status; ?>
                                    </span>
                                </td>
                                <td data-label="Aksi" class="px-4 py-3 flex flex-wrap gap-2">
                                    <?php if ($pasien['status'] == 'Menunggu') : ?>
                                        <a href="/admin/periksa/<?= $pasien['id_antrian']; ?>"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">
                                            <i class="fas fa-play mr-1"></i> Periksa
                                        </a>
                                        <a href="/admin/lewati/<?= $pasien['id_antrian']; ?>"
                                            class="inline-flex items-center px-3 py-1.5 bg-gray-500 text-white text-xs font-medium rounded hover:bg-gray-600 transition">
                                            <i class="fas fa-forward mr-1"></i> Lewati
                                        </a>
                                    <?php elseif ($pasien['status'] == 'Diperiksa') : ?>
                                        <a href="/admin/selesai/<?= $pasien['id_antrian']; ?>"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">
                                            <i class="fas fa-check mr-1"></i> Selesai
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- jika tidak ada pasien -->
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Tidak ada pasien dalam antrian saat ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>