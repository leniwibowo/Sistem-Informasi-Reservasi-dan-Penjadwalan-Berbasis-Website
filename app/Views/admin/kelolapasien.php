<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<style>
    /*  responsiv tabel  */
    @media (max-width: 768px) {
        table.responsive-table thead {
            display: none;
            /* membunyikan header */
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
            padding: 0.75rem;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table.responsive-table td {
            padding: 0.5rem 0;
            border: none !important;
            text-align: left !important;
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

<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Data Pasien</h2>

    <!-- pesan sukses -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5 rounded-lg" role="alert">
            <p class="font-bold">Sukses</p>
            <p><?= session()->getFlashdata('success'); ?></p>
        </div>
    <?php endif; ?>

    <!-- tombol tambah & form pencarian -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <!-- tombol tambah -->
        <a href="<?= base_url('/admin/tambahpasien'); ?>" class="w-full md:w-auto px-5 py-2.5 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200 text-center">
            <i class="bi bi-plus-lg mr-2"></i>Tambah Pasien
        </a>
        <a href="<?= base_url('admin/download') ?>"
            class="w-full md:w-auto px-5 py-2.5 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200 text-center">
            <i class="bi bi-download mr-2"></i> Download Data Pasien
        </a>


        <!-- form pencarian -->
        <form method="get" class="w-full md:w-auto flex" action="<?= base_url('/admin/kelolapasien'); ?>">
            <input type="text" name="keyword" class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Cari nama atau No. RM...">
            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-r-lg hover:bg-gray-300 transition-colors duration-200">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- tabel data pasien -->
    <div class="overflow-x-auto md:overflow-visible">
        <table class="min-w-full bg-white border border-gray-200 responsive-table">
            <thead class="bg-sky-700 text-white">
                <tr>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">No</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">No RM</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Jenis Kelamin</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">No HP</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Alamat</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($pasien)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($pasien as $p) : ?>
                        <tr class="border-b hover:bg-sky-50">
                            <td data-label="No" class="text-center py-3 px-4"><?= $no++ ?></td>
                            <td data-label="No RM" class="py-3 px-4"><?= esc($p['no_RM']) ?></td>
                            <td data-label="Nama" class="py-3 px-4 font-medium"><?= esc($p['nama']) ?></td>
                            <td data-label="Jenis Kelamin" class="py-3 px-4"><?= esc($p['jenis_kelamin']) ?></td>
                            <td data-label="No HP" class="py-3 px-4"><?= esc($p['no_hp']) ?></td>
                            <td data-label="Alamat" class="py-3 px-4 truncate max-w-xs"><?= esc($p['alamat']) ?></td>
                            <td data-label="Aksi" class="text-center py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- edit -->
                                    <a href="<?= base_url('admin/editpasien/' . $p['id_pasien']) ?>" title="Edit" class="p-2 rounded-md text-blue-500 hover:text-blue-700 hover:bg-blue-100 transition-colors duration-200">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <!-- iwayat -->
                                    <a href="<?= base_url('admin/riwayatpemeriksaan/' . $p['id_pasien']) ?>" title="Riwayat Pemeriksaan" class="p-2 rounded-md text-amber-500 hover:text-amber-700 hover:bg-amber-100 transition-colors duration-200">
                                        <i class="bi bi-clock-history text-lg"></i>
                                    </a>
                                    <!--  profil pasien-->
                                    <a href="<?= base_url('admin/profil_pasien/' . $p['id_pasien']) ?>" title="Profil Pasien" class="p-2 rounded-md text-amber-500 hover:text-amber-700 hover:bg-amber-100 transition-colors duration-200">
                                        <i class="bi bi-person-vcard-fill mr-3 text-lg"></i>
                                    </a>
                                    <!-- hapus -->
                                    <a href="<?= base_url('admin/hapuspasien/' . $p['id_pasien']) ?>" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')" class="p-2 rounded-md text-red-500 hover:text-red-700 hover:bg-red-100 transition-colors duration-200">
                                        <i class="bi bi-trash-fill text-lg"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-6">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-info-circle text-4xl mb-2"></i>
                                <span>Tidak ada data pasien ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- pagination -->
    <div class="mt-6">
        <?php if (isset($pager)) echo $pager->links('default', 'tailwind_pagination'); ?>
    </div>
</div>

<?= $this->endSection() ?>