<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_dokter' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_pasien' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_pasien' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'tanggal_pemeriksaan' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'pemeriksaan' => [
                'type' => 'TEXT',
                'null'  => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id_jadwal', true);
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        //
    }
}
