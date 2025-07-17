<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class CreatePasienTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pasien' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 20, // untuk hash password
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'no_RM' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'auto_increment' => true,
            ],
            'NIK' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'unique'     => true,
            ],
            'golongan_darah' => [
                'type' => 'VARCHAR',
                'constraint' => 5,

            ],
            'alergi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'diabetes' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'penyakit_jantung' => [
                'type' => 'VARCHAR',
                'constraint' => 10,

            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_pasien', true);
        $this->forge->createTable('pasien');
    }

    public function down()
    {
        $this->forge->dropTable('pasien');
    }
}
