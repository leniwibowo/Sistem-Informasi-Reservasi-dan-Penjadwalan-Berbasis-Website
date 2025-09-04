<?= $this->extend('templates/pasien_layout') ?>

<?= $this->section('title') ?>
Pendaftaran Kunjungan Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-md border border-gray-200">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Kunjungan</h1>
            <p class="text-gray-500 mt-1">Silakan isi detail keluhan, pilih tanggal, shift, dan dokter.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
                <i class="bi bi-exclamation-triangle-fill mr-3"></i>
                <div>
                    <span class="font-medium">Gagal!</span> <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
                <i class="bi bi-check-circle-fill mr-3"></i>
                <div>
                    <span class="font-medium">Berhasil!</span> <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="p-4 mb-6 border border-gray-200 bg-gray-50 rounded-lg space-y-2">
            <div class="flex justify-between text-sm">
                <span class="font-medium text-gray-600">No. Rekam Medis</span>
                <span class="font-mono font-semibold text-gray-800"><?= esc($pasien['no_RM']) ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="font-medium text-gray-600">Nama Pasien</span>
                <span class="font-semibold text-gray-800"><?= esc($pasien['nama']) ?></span>
            </div>
        </div>

        <form action="<?= base_url('antrian/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="space-y-6">
                <div>
                    <label for="keluhan" class="block mb-2 text-sm font-medium text-gray-900">
                        Keluhan Utama <span class="text-red-600">*</span>
                    </label>
                    <textarea name="keluhan" id="keluhan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-sky-500 focus:border-sky-500" placeholder="Tuliskan keluhan yang Anda rasakan secara detail..." required></textarea>
                </div>

                <div>
                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">
                        Pilih Tanggal Kunjungan <span class="text-red-600">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5"
                        min="<?= date('Y-m-d'); ?>"
                        max="<?= date('Y-m-d', strtotime('+2 days')); ?>"
                        required>
                </div>

                <div>
                    <label for="shift" class="block mb-2 text-sm font-medium text-gray-900">
                        Pilih Jam Praktik <span class="text-red-600">*</span>
                    </label>
                    <select name="shift" id="shift" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5" required>
                        <option value="">-- Pilih Jam Praktik --</option>
                        <option value="Pagi">Pagi (09.00 - 15.00 WIB)</option>
                        <option value="Sore">Sore (15.00 - 21.00 WIB)</option>
                    </select>
                </div>

                <div>
                    <label for="dokter" class="block mb-2 text-sm font-medium text-gray-900">
                        Dokter yang Bertugas <span class="text-red-600">*</span>
                    </label>
                    <select name="dokter" id="dokter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5" required>
                        <option value="">Pilih tanggal & shift terlebih dahulu</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- UPDATED CODE: AJAX untuk ambil dokter -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tanggalInput = document.getElementById('tanggal');
        const shiftSelect = document.getElementById('shift');
        const dokterSelect = document.getElementById('dokter');

        async function fetchDokter() {
            const tanggal = tanggalInput.value;
            const shift = shiftSelect.value;
            const csrfToken = '<?= csrf_token() ?>';
            const csrfHash = '<?= csrf_hash() ?>';

            // NEW CODE: Tampilkan pesan loading
            dokterSelect.innerHTML = '<option value="">Memuat...</option>';
            dokterSelect.disabled = true;

            if (!tanggal || !shift) {
                dokterSelect.innerHTML = '<option value="">Pilih tanggal & shift dulu</option>';
                dokterSelect.disabled = false;
                return;
            }

            try {
                const response = await fetch("<?= base_url('antrian/getDokter') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({
                        [csrfToken]: csrfHash,
                        tanggal: tanggal,
                        shift: shift
                    })
                });

                const data = await response.json();

                dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
                if (data.length > 0) {
                    data.forEach(d => {
                        dokterSelect.innerHTML += `<option value="${d.id_dokter}">${d.nama}</option>`;
                    });
                } else {
                    dokterSelect.innerHTML = '<option value="">Tidak ada dokter tersedia</option>';
                }

            } catch (error) {
                console.error("Gagal ambil data dokter:", error);
                dokterSelect.innerHTML = '<option value="">Error mengambil data</option>';
            } finally {
                // NEW CODE: Aktifkan kembali dropdown setelah selesai
                dokterSelect.disabled = false;
            }
        }

        // Jalankan saat tanggal atau shift berubah
        tanggalInput.addEventListener('change', fetchDokter);
        shiftSelect.addEventListener('change', fetchDokter);
    });
</script>


<?= $this->endSection() ?>