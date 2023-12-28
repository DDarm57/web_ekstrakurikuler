<?php

namespace App\Models;

use CodeIgniter\Model;

class PembinaModel extends Model
{
    protected $table      = 'data_pembina';
    protected $primaryKey = 'id_pembina';
    protected $allowedFields = ['pembina_userid', 'nip_pembina', 'nama_pembina', 'alamat', 'mengajar', 'telp_pembina', 'gambar_pembina'];

    public function savePembina($data_user, $data)
    {
        $this->db->table('users')->insert($data_user);
        $data['pembina_userid'] = $this->db->insertID();
        return $this->db->table('data_pembina')->insert($data);
    }
}
