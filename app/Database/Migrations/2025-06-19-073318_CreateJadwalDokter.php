<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalDokter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal_dokter' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'id_dokter' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'hari' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],

        ]);

        $this->forge->addKey('id_jadwal_dokter', true); //primary key
        $this->forge->addForeignKey('id_dokter', 'dokter', 'id_dokter', 'CASCADE', 'CASCADE');

        $this->forge->createTable('jadwal_dokter');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_dokter');
    }
}
