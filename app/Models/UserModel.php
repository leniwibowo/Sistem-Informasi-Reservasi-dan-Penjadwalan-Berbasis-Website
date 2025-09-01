<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'password',
        'role',
        'reset_token',
        'reset_token_expires_at'
    ];
    protected $useTimestamps = false;

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
