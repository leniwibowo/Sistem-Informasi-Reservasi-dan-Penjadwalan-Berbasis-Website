<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Nama class ini sudah benar
class AddResetTokenToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'reset_token'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'reset_token_expires_at'  => ['type' => 'DATETIME', 'null' => true],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['reset_token', 'reset_token_expires_at']);
    }
}
