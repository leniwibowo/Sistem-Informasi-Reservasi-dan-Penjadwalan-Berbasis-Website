<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatPemeriksaanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_riwayat' => [
                'type' => 'INT',
                'unsigned' => 'true',
                'auto_increment' => true
            ],
            'id_pasien' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_dokter' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'waktu' => [
                'type' => 'DATETIME',
            ],
            'diagnosis' => [
                'type' => 'TEXT',
            ],
            'resep' => [
                'type' => 'TEXT',
            ],
            'keluhan' => [
                'type' => 'TEXT',
            ],
            'catatan' => [
                'type' => 'TEXT',
            ],

            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'




        ]);

        $this->forge->addKey('id_riwayat', true);
        $this->forge->createTable('riwayat_pemeriksaan');
    }


    public function down()
    {
        //
    }
}
