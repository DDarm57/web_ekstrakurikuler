<?php

namespace App\Controllers;

use CodeIgniter\Config\Config;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class Siswa extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db   = \Config\Database::connect();
    }
    public function dashboard()
    {
        if (session()->get('level') != 3) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_siswa.pilihan_kegiatan');
        $builder->where('siswa_userid', session()->get('id'));
        $query = $builder->get()->getRow();

        $data = [
            'tittle' => 'Dashboard',
            'siswa' => $query
        ];

        return view('siswa/dashboard', $data);
    }

    public function nilai_kegiatan()
    {
        if (session()->get('level') != 3) {
            return redirect()->to(site_url('index/home'));
        }
        $builder = $this->db->table('users');
        $builder->where('id', session()->get('id'));
        $cek = $builder->get()->getRowArray();
        if ($cek['status'] == 'validasi nilai') {
            session()->setFlashdata('pesan_merah', 'Validasi ke pembina terlebihdahulu sebelum mengakses data nilai');
            return redirect()->to(site_url('siswa/dashboard'));
        }

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $builder = $this->db->table('nilai_siswa');
            $builder->select('*');
            $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal');
            $builder->join('data_siswa', 'data_siswa.id_siswa = nilai_siswa.id_siswa');
            $builder->where('siswa_userid', session()->get('id'));
            $builder->where('J_bulan', $keyword);
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $keyword);
        } else {
            $builder = $this->db->table('nilai_siswa');
            $builder->select('*');
            $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal');
            $builder->join('data_siswa', 'data_siswa.id_siswa = nilai_siswa.id_siswa');
            $builder->where('siswa_userid', session()->get('id'));
            $builder->where('J_bulan', date('Y-m'));
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $keyword);
        }


        // dd($query);
        $data = [
            'tittle' => 'Data Nilai',
            'nilai' => $query
        ];

        return view('siswa/nilai_kegiatan', $data);
    }

    public function ubah_profile($id_siswa)
    {
        if (session()->get('level') != 3) {
            return redirect()->to(site_url('index/home'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->where('id_siswa', $id_siswa);
        $siswa = $builder->get()->getRow();

        $data = [
            'tittle' => 'Ubah Profil',
            'siswa' => $siswa,
            'validation' => \Config\Services::validation()
        ];

        return view('siswa/ubah_profile', $data);
    }

    public function update_profile()
    {
        if (session()->get('level') != 3) {
            return redirect()->to(site_url('index/home'));
        }

        $fileGambarSiswa = $this->request->getFile('gambar_siswa');

        //cek gambar apakah tetap gambar lama
        if ($fileGambarSiswa->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            //ambil nama gambar
            $namaGambar = $fileGambarSiswa->getRandomName();
            //pindahkan file ke assets
            $fileGambarSiswa->move('assets/fotosiswa', $namaGambar);
            //hapus file lama
            if ($this->request->getVar('gambarLama') != 'default.jpg') {
                unlink('assets/fotosiswa/' . $this->request->getVar('gambarLama'));
            }
        }

        $builder = $this->db->table('data_siswa');
        $builder->where('id_siswa', $this->request->getVar('id_siswa'));
        $builder->set('jk', $this->request->getVar('jk'));
        $builder->set('alamat_siswa', $this->request->getVar('alamat_siswa'));
        $builder->set('gambar_siswa', $namaGambar);
        $builder->update();

        session()->setFlashdata('pesan_hijau', 'Data profil berhasil di update');
        return redirect()->to(site_url('siswa/dashboard'));
    }
}
