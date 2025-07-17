<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class Antrian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_antrian' => [
                'type'   => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_pasien' => [
                'type' => 'INT',
                'usigned' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',

            ],
            'no_RM' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status' => [
                'type'   => 'ENUM',
                'constraint' => ['Menunggu', 'Dipriksa', 'Selesai'],
                'default'  => 'Menunggu'
            ],
            'create_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_jadwal' => [
                'type' => 'INT',
                'usigned' => true
            ],
            'id_tanggal' => [
                'type' => 'INT',
                'usigned' => true
            ],
            'keluhan' => [
                'type' => 'TEXT'
            ]

        ]);

        $this->forge->addKey('id_antrian', true);
        $this->forge->addForeignKey('id_pasien', 'pasien', 'id_pasien', 'CASADE', 'CASCADE');
        $this->forge->createTable('antrian');
    }

    public function down()
    {
        $this->forge->dropTable('antrian');
    }
}
