<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table      = 'nilai_siswa';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['nilai_userid', 'nilai1', 'nilai2', 'nilai3', 'nilai4', 'nilai_kegiatan'];

    // public function updateNilai()
    // {
    //     $this->db->table('nilai_siswa')->set(['nilai1' => '','nilai1' => '','nilai1' => '','nilai1' => '',])
    // }
}
