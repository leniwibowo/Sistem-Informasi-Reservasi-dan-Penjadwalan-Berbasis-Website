<?= $this->extend('templates/pasien_layout') ?>
<?= $this->section('title') ?>Reschedule Jadwal<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Reschedule Jadwal</h2>

    <div class="mb-4">
        <label class="block text-gray-600 mb-1">Jadwal Lama</label>
        <div class="px-3 py-2 bg-gray-100 rounded">
            <?= date('l, d F Y', strtotime($jadwal['tanggal_pemeriksaan'])) ?>
        </div>
    </div>

    <form action="<?= base_url('jadwal/update_reschedule/' . $jadwal['id_jadwal']) ?>" method="post" id="formReschedule">
        <?= csrf_field() ?>

        <!-- Tanggal -->
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
                Pilih Shift <span class="text-red-600">*</span>
            </label>
            <select name="shift" id="shift" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5" required>
                <option value="">-- Pilih Shift --</option>
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
        <br>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Simpan</button>
    </form>
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