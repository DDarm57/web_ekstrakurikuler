<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table      = 'data_siswa';
    protected $primaryKey = 'id_siswa';
    protected $allowedFields = ['siswa_userid', 'nis_siswa', 'nama_siswa', 'jk', 'pilihan_kegiatan', 'alamat_siswa', 'gambar_siswa'];

    public function saveSiswa($data_user, $data)
    {
        $this->db->table('users')->insert($data_user);
        $data['siswa_userid'] = $this->db->insertID();

        $masukan = [
            $this->db->table('data_siswa')->insert($data),
        ];

        return $masukan;
    }

    
}
