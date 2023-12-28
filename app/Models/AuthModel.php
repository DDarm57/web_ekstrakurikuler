<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    public function login($username, $password)
    {
        return $this->db->table('users')->where([
            'username' => $username,
            'password' => $password,
        ])->get()->getRowArray();
    }
}
