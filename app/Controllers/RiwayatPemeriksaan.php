<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RiwayatModel;
use CodeIgniter\HTTP\ResponseInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class RiwayatPemeriksaan extends BaseController
{
    protected $riwayatModel;

    public function __construct()
    {
        $this->riwayatModel = new RiwayatModel();
    }

    // Daftar riwayat pasien
    public function index()
    {
        $userID = session()->get('id_pasien');

        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter, dokter.sip')
            ->join('pasien', 'pasien.id_pasien = riwayat_pemeriksaan.id_pasien')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_pasien', $userID)
            ->orderBy('waktu', 'DESC')
            ->findAll();

        return view('riwayat_pemeriksaan', [
            'riwayat' => $riwayat
        ]);
    }

    // Detail riwayat + QR Code
    public function detail($id)
    {
        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter, dokter.sip')
            ->join('pasien', 'pasien.id_pasien = riwayat_pemeriksaan.id_pasien')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_riwayat', $id)
            ->first();

        if (!$riwayat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data riwayat tidak ditemukan.");
        }

        // Data untuk QR Code
        $qrText = "Dokter: {$riwayat['nama_dokter']}\n"
            . "SIP: {$riwayat['sip']}\n"
            . "Jam: " . date('H:i', strtotime($riwayat['waktu']));

        // Generate QR Code
        $qrCode = QrCode::create($qrText)
            ->setSize(200)
            ->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrImage = base64_encode($result->getString());

        return view('riwayat/detail', [
            'riwayat'   => $riwayat,
            'qrImage'   => $qrImage,
            'qrText'    => $qrText
        ]);
    }

    // Endpoint khusus untuk menampilkan QR Code PNG
    public function qrcode($id)
    {
        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, dokter.nama AS nama_dokter, dokter.sip')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_riwayat', $id)
            ->first();

        if (!$riwayat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data riwayat tidak ditemukan");
        }

        $qrText = "Dokter: {$riwayat['nama_dokter']}\n"
            . "SIP: {$riwayat['sip']}\n"
            . "Jam: " . date('H:i', strtotime($riwayat['waktu']));

        $qrCode = QrCode::create($qrText)->setSize(200)->setMargin(10);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return $this->response
            ->setContentType('image/png')
            ->setBody($result->getString());
    }
}
