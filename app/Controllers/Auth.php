<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    protected $authModel;
    protected $db;
    public function __construct()
    {
        $this->db   = \Config\Database::connect();
        $this->authModel = new AuthModel();
    }
    public function register()
    {
        $builder = $this->db->table('data_kegiatan');
        $query = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Login | Ekstrakurikuler',
            'kegiatan' => $query,
            'validation' => \Config\Services::validation()
        ];

        return view('auth/register', $data);
    }

    public function save_register()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'username harus di isi'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password harus di isi'
                ]
            ],
            'kegiatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kegiatan harus di isi'
                ]
            ]
        ])) {
            return redirect()->to(site_url('auth/register'))->withInput();
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $builder = $this->db->table('users');
        $builder->where('username', $username);
        $query = $builder->get()->getRowArray();

        $builder = $this->db->table('data_pembina');
        $builder->where('mengajar_kegiatan', $this->request->getVar('kegiatan'));
        $cek_pembina = $builder->get()->getRowArray();

        $builder = $this->db->table('data_kegiatan');
        $builder->where('id_kegiatan', $this->request->getVar('kegiatan'));
        $get_kegiatan = $builder->get()->getRowArray();

        if ($cek_pembina == null) {
            session()->setFlashdata('pesan_merah', 'Kegiatan yang anda pilih ' . $get_kegiatan['nama_kegiatan'] . ' tidak ada pembina kegiatan.. silahkan tunggu info selanjutnya :)');
            return redirect()->to(site_url('auth/register'));
        }

        if ($query != null) {
            if ($query['status'] == 'tidak aktif') {
                $builder = $this->db->table('users');
                $builder->where('username', $username);
                $builder->set('password', $password);
                $builder->set('kegiatan', $this->request->getVar('kegiatan'));
                $builder->set('status', 'validasi data');
                $builder->set('created_at', Time::now());
                $builder->update();

                session()->setFlashdata('pesan_hijau', 'Daftar berhasil silahkan login untuk mengakses');
                return redirect()->to(site_url('auth/login'));
            } elseif ($query['status'] == 'validasi data') {
                session()->setFlashdata('pesan_hijau', 'anda sudah terdaftar silahkan login');
                return redirect()->to(site_url('auth/login'));
            } elseif ($query['status'] == 'sudah validasi') {
                session()->setFlashdata('pesan_hijau', 'anda sudah terdaftar silahkan login');
                return redirect()->to(site_url('auth/login'));
            }
        } else {
            session()->setFlashdata('pesan_merah', 'nis tidak terdaftar di database. silahkan lapor ke pembina akstra untuk form validasi');
            return redirect()->to(site_url('auth/register'));
        }
    }

    public function validasi_siswa($username)
    {
        $builder = $this->db->table('data_kelasmaster');
        $query = $builder->get()->getResultArray();

        $builder = $this->db->table('users');
        $builder->where('username', $username);
        $get_user = $builder->get()->getRowArray();

        $queryJadwal = $this->db->table('data_kegiatan');

        $data = [
            'tittle' => 'Lengkapi Data Siswa',
            'kelas' => $query,
            'user' => $get_user,
            'builder' => $queryJadwal,
            'validation' => \Config\Services::validation()
        ];

        return view('auth/validasi_siswa', $data);
    }

    public function update_validasi()
    {
        if (!$this->validate([
            'nis_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nis siswa harus di isi',
                ]
            ],
            'nama_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama siswa harus di isi',
                ]
            ],
            'jk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jenis kelamin harus di isi',
                ]
            ],
            'kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kelas harus di isi',
                ]
            ],
            'pilihan_ekstra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'pilihan kegiatan harus di isi',
                ]
            ],
            'gambar_siswa' => [
                'rules' => 'max_size[gambar_siswa,3024]|is_image[gambar_siswa]|mime_in[gambar_siswa,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar maksimal 3mb',
                    'is_image' => 'yang anda masukan bukan gambar',
                    'mime_in' => 'yang anda masukan bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to(site_url('auth/validasi_siswa/' . $this->request->getVar('nis_siswa')))->withInput();
        }

        //ambil gambar
        $fileGambarSiswa = $this->request->getFile('gambar_siswa');

        //jika tidak ada gambar yang di upload
        if ($fileGambarSiswa->getError() == 4) {
            $namaGambarSiswa = 'default.jpg';
        } else {
            //ambil nama gambar
            $namaGambarSiswa = $fileGambarSiswa->getRandomName();
            //pindahkan file ke assets
            $fileGambarSiswa->move('assets/fotosiswa', $namaGambarSiswa);
        }

        $siswa_userid = $this->request->getVar('id');
        $nis_siswa = $this->request->getVar('nis_siswa');
        $nama_siswa = $this->request->getVar('nama_siswa');
        $jk = $this->request->getVar('jk');
        $kelas = $this->request->getVar('kelas');
        $pilihan_ekstra = $this->request->getVar('pilihan_ekstra');
        $alamat_siswa = $this->request->getVar('alamat_siswa');
        $gambar_siswa = $namaGambarSiswa;
        $time = Time::now();

        $data = [
            'siswa_userid' => $siswa_userid,
            'nis_siswa' => $nis_siswa,
            'nama_siswa' => $nama_siswa,
            'jk' => $jk,
            'pilihan_kegiatan' => $pilihan_ekstra,
            'alamat_siswa' => $alamat_siswa,
            'gambar_siswa' => $gambar_siswa,
            'created_at' => $time
        ];

        $builder = $this->db->table('data_siswa');
        $builder->insert($data);
        $id_siswa = $this->db->insertID();

        $builder = $this->db->table('data_pembina');
        $builder->where('mengajar_kegiatan', $pilihan_ekstra);
        $get_pembina = $builder->get()->getRowArray();

        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $get_thnAkd = $builder->get()->getRowArray();

        $data_akademik = [
            'id_siswa' => $id_siswa,
            'id_pembina' => $get_pembina['id_pembina'],
            'id_kelas' => $kelas,
            'id_kegiatan' => $pilihan_ekstra,
            'id_thnAkd' => $get_thnAkd['id_thnAkd'],
            'tahun' => date('Y-m')
        ];

        $builder = $this->db->table('data_akademik');
        $builder->insert($data_akademik);

        $builder = $this->db->table('users');
        $builder->where('username', $this->request->getVar('nis_siswa'));
        $builder->set('status', 'validasi nilai');
        $builder->set('kegiatan', $pilihan_ekstra);
        $builder->update();

        $builder = $this->db->table('users');
        $builder->where('username', $this->request->getVar('nis_siswa'));
        $cek = $builder->get()->getRowArray();

        session()->set('log', true);
        session()->set('id', $cek['id']);
        session()->set('username', $cek['username']);
        session()->set('password', $cek['password']);
        session()->set('level', $cek['level']);
        session()->set('kegiatan', $cek['kegiatan']);

        session()->setFlashdata('pesan_toast', 'Validasi berhasil dan Login sebagai siswa');
        return redirect()->to(site_url('/'));
    }

    public function validasi_siswaKembali($username)
    {
        $builder = $this->db->table('data_siswa');
        $builder->select('*');
        $builder->join('data_akademik', 'data_akademik.id_siswa = data_siswa.id_siswa');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_akademik.id_kegiatan');
        $builder->where('nis_siswa', $username);
        $query = $builder->get()->getRow();

        $builder = $this->db->table('data_kelasMaster');
        $queryKelas = $builder->get()->getResultArray();

        $builder = $this->db->table('data_kegiatan');
        $queryKegiatan = $builder->get()->getResultArray();

        // dd($query);

        $data = [
            'tittle' => 'validasi siswa kembali',
            'siswa' => $query,
            'kelas' => $queryKelas,
            'kegiatan' => $queryKegiatan,
            'validation' => \Config\Services::validation()
        ];
        return view('auth/validasi_siswaKembali', $data);
    }

    public function update_validasiKembali()
    {
        if (!$this->validate([
            'kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kelas harus di isi'
                ]
            ],
            'pilihan_kegiatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'data kegiatan harus di isi'
                ]
            ],
            'gambar_siswa' => [
                'rules' => 'max_size[gambar_siswa,3024]|is_image[gambar_siswa]|mime_in[gambar_siswa,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar maksimal 3mb',
                    'is_image' => 'yang anda masukan bukan gambar',
                    'mime_in' => 'yang anda masukan bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to(site_url('auth/validasi_siswaKembali/' . $this->request->getVar('nis_siswa')))->withInput();
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

        $nis_siswa = $this->request->getVar('nis_siswa');
        $nama_siswa = $this->request->getVar('nama_siswa');
        $jk = $this->request->getVar('jk');
        $alamat_siswa = $this->request->getVar('alamat_siswa');
        $gambar_siswa = $namaGambar;
        $time = Time::createFromDate();

        $data = [
            'nis_siswa' => $nis_siswa,
            'nama_siswa' => $nama_siswa,
            'jk' => $jk,
            'pilihan_kegiatan' => $this->request->getVar('pilihan_kegiatan'),
            'alamat_siswa' => $alamat_siswa,
            'gambar_siswa' => $gambar_siswa,
            'updated_at' => $time
        ];

        $builder = $this->db->table('data_pembina');
        $builder->where('mengajar_kegiatan',  $this->request->getVar('pilihan_kegiatan'));
        $get_pembina = $builder->get()->getRowArray();

        $builder = $this->db->table('data_siswa');
        $builder->where('id_siswa', $this->request->getVar('id_siswa'));
        $builder->set($data);
        $builder->update();

        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $get_tahunAkd = $builder->get()->getRowArray();

        $data_akademik = [
            'id_siswa' => $this->request->getVar('id_siswa'),
            'id_pembina' => $get_pembina['id_pembina'],
            'id_kelas' => $this->request->getVar('kelas'),
            'id_kegiatan' => $this->request->getVar('pilihan_kegiatan'),
            'id_thnAkd' => $get_tahunAkd['id_thnAkd'],
            'tahun' => date('Y-m')
        ];

        $builder = $this->db->table('data_akademik');
        $builder->insert($data_akademik);

        $builder = $this->db->table('users');
        $builder->where('username', $this->request->getVar('nis_siswa'));
        $builder->set('status', 'validasi nilai');
        $builder->set('kegiatan', $this->request->getVar('pilihan_kegiatan'));
        $builder->update();

        $builder = $this->db->table('users');
        $builder->where('username', $this->request->getVar('nis_siswa'));
        $cek = $builder->get()->getRowArray();

        session()->set('log', true);
        session()->set('id', $cek['id']);
        session()->set('username', $cek['username']);
        session()->set('password', $cek['password']);
        session()->set('level', $cek['level']);
        session()->set('kegiatan', $cek['kegiatan']);

        session()->setFlashdata('pesan_toast', 'Validasi data kembali berhasil dan Login sebagai siswa');
        return redirect()->to(site_url('/'));
    }

    public function login()
    {
        $data = [
            'tittle' => 'Login | Ekstrakurikuler',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    public function cek_login()
    {
        if ($this->validate(
            [
                'username' => [
                    'label' => 'username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi'
                    ]
                ],

                'password' => [
                    'label' => 'password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi'
                    ]
                ],
            ]

        )) {

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $cek = $this->authModel->login($username, $password);


            if ($cek) {

                if ($cek['status'] == 'validasi data') {
                    return redirect()->to(site_url('auth/validasi_siswa/' . $username));
                } elseif ($cek['status'] == 'validasi data kembali') {
                    return redirect()->to(site_url('auth/validasi_siswaKembali/' . $username));
                }

                if ($cek['level'] == 1) {
                    $getLevel = 'Admin';
                } elseif ($cek['level'] == 2) {
                    $getLevel = 'Pembina';
                } elseif ($cek['level'] == 3) {
                    $getLevel = 'Siswa';
                }

                session()->set('log', true);
                session()->set('id', $cek['id']);
                session()->set('username', $cek['username']);
                session()->set('password', $cek['password']);
                session()->set('level', $cek['level']);
                session()->set('kegiatan', $cek['kegiatan']);

                session()->setFlashdata('pesan_toast', 'Berhasil Login sebagai ' . $getLevel);
                return redirect()->to(site_url('/'));
            } else {
                session()->setFlashdata('pesan_merah', 'username atau password salah');
                return redirect()->to(site_url('auth/login'));
            }
        } else {
            return redirect()->to(site_url('auth/login'))->withInput();
        }
    }

    public function logout()
    {
        session()->remove('log');
        session()->remove('id');
        session()->remove('username');
        session()->remove('password');
        session()->remove('level');
        session()->remove('kegiatan');

        session()->setFlashdata('pesan_logout', 'Logout Berhasil');
        return redirect()->to(site_url('auth/login'));
    }
}
