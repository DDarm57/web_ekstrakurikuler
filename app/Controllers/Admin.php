<?php

namespace App\Controllers;

use App\Models\NilaiModel;
use App\Models\PembinaModel;
use App\Models\SiswaModel;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Admin extends BaseController
{
    protected $db;
    protected $siswaModel;
    protected $pembinaModel;
    protected $usersModel;
    public function __construct()
    {
        $this->db   = \Config\Database::connect();
        $this->siswaModel = new SiswaModel();
        $this->pembinaModel = new PembinaModel();
        $this->usersModel = new UsersModel();
    }

    public function dashboard()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_siswa');
        $query = $builder->countAllResults();
        // dd($query);

        $builder = $this->db->table('users');
        $count_users = $builder->countAllResults();

        $builder = $this->db->table('data_pembina');
        $count_pembina = $builder->countAllResults();

        $builder = $this->db->table('data_kegiatan');
        $kegiatan = $builder->countAllResults();


        $data = [
            'tittle' => 'Dashboard',
            'count_siswa' => $query,
            'users' => $count_users,
            'pembina' => $count_pembina,
            'kegiatan' => $kegiatan
        ];

        return view('admin/dashboard', $data);
    }

    public function data_register()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('users');
        // $builder->select('*');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = users.kegiatan');
        $builder->where('level', '3');
        $builder->orderBy('id', 'DESC');
        $query = $builder->get()->getResultArray();

        // dd($query);

        $data = [
            'tittle' => 'Data Register',
            'users' => $query,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/data_register', $data);
    }

    public function save_register()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        if ($this->request->getVar('username') == null) {
            session()->setFlashdata('pesan_merah', 'tidak ada data di inputkan');
            return redirect()->to(site_url('admin/data_register'));
        }

        $builder = $this->db->table('users');
        $builder->where('level', '3');
        $query = $builder->get()->getRowArray();

        $builder = $this->db->table('users');
        $builder->where('username', $this->request->getVar('username'));
        $cek_data = $builder->get()->getRowArray();

        if ($cek_data != null) {
            session()->setFlashdata('pesan_merah', 'data dengan nis ' . $this->request->getVar('username') . ' sudah ada');
            return redirect()->to(site_url('admin/data_register'));
        }

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'level' => '3',
            'status' => 'tidak aktif',
            'created_at' => Time::now()
        ];

        $builder = $this->db->table('users');
        $builder->insert($data);

        session()->setFlashdata('pesan_hijau', 'Data register berhasil di buat');
        return redirect()->to(site_url('admin/data_register'));
    }

    public function data_siswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->orderBy('id_siswa', 'DESC');
        $query = $builder->get()->getResultArray();

        // dd($query);

        $data = [
            'tittle' => 'Data Siswa',
            'siswa' => $query
        ];


        return view('admin/data_siswa', $data);
    }

    public function create_siswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_kegiatan');
        $query = $builder->get()->getResultArray();

        $builder = $this->db->table('data_kelasMaster');
        $queryKelas = $builder->get()->getResultArray();

        $builder = $this->db->table('tahun_akademik');
        $get_thnAkd = $builder->get()->getResultArray();

        $getRand = (rand(1000, 9999));

        $data = [
            'tittle' => 'Tambah Data Siswa',
            'validation' => \Config\Services::validation(),
            'kegiatan' => $query,
            'kelas' => $queryKelas,
            'get_pass' => $getRand,
            'thn_akd' => $get_thnAkd,

        ];
        return view('admin/create_siswa', $data);
    }

    public function save_siswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        if (!$this->validate([
            'nis_siswa' => [
                'rules' => 'required|is_unique[data_siswa.nis_siswa]',
                'errors' => [
                    'required' => 'nis siswa harus di isi',
                    'is_unique' => 'nis siswa sudah terdaftar'
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
            'jk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jenis kelamin harus di isi',
                ]
            ],
            'pilihan_ekstra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'pilihan kegiatan harus di isi',
                ]
            ],
            'id_thnAkd' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tahun akademik harus di isi',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password harus di isi',
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
            return redirect()->to(site_url('admin/create_siswa'))->withInput();
        }

        $builder = $this->db->table('data_pembina');
        $builder->where('mengajar_kegiatan', $this->request->getVar('pilihan_ekstra'));
        $cek_pembina = $builder->get()->getRowArray();

        $builder = $this->db->table('data_kegiatan');
        $builder->where('id_kegiatan', $this->request->getVar('pilihan_ekstra'));
        $nama_kegiatan = $builder->get()->getRowArray();

        if ($cek_pembina == null) {
            session()->setFlashdata('pesan_merah', 'ektrakurikuler ' . $nama_kegiatan['nama_kegiatan'] . ' tidak ada pembina silahkan tambahkan data pembina ' . $nama_kegiatan['nama_kegiatan'] . ' terlebih dahulu');
            return redirect()->to(site_url('admin/create_siswa'));
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

        $username = $this->request->getVar('nis_siswa');
        $password = $this->request->getVar('password');
        $level = $this->request->getVar('level');
        $kegiatan = $this->request->getVar('pilihan_ekstra');
        $time = Time::createFromDate();

        $data_user = [
            'username' => $username,
            'password' => $password,
            'level' => $level,
            'kegiatan' => $kegiatan,
            'status' => 'validasi nilai',
            'created_at' => $time
        ];

        $nis_siswa = $this->request->getVar('nis_siswa');
        $nama_siswa = $this->request->getVar('nama_siswa');
        $jk = $this->request->getVar('jk');
        $kelas = $this->request->getVar('kelas');
        $pilihan_ekstra = $this->request->getVar('pilihan_ekstra');
        $alamat_siswa = $this->request->getVar('alamat_siswa');
        $gambar_siswa = $namaGambarSiswa;
        $time = Time::createFromDate();

        $data = [
            'nis_siswa' => $nis_siswa,
            'nama_siswa' => $nama_siswa,
            'jk' => $jk,
            'pilihan_kegiatan' => $pilihan_ekstra,
            'alamat_siswa' => $alamat_siswa,
            'gambar_siswa' => $gambar_siswa,
            'created_at' => $time
        ];


        $this->siswaModel->saveSiswa($data_user, $data);
        $id_siswa = $this->db->insertID();

        $builder = $this->db->table('data_pembina');
        $builder->where('mengajar_kegiatan', $pilihan_ekstra);
        $get_pembina = $builder->get()->getRowArray();

        $data_akademik = [
            'id_siswa' => $id_siswa,
            'id_pembina' => $get_pembina['id_pembina'],
            'id_kelas' => $kelas,
            'id_kegiatan' => $pilihan_ekstra,
            'id_thnAkd' => $this->request->getVar('id_thnAkd'),
            'tahun' => date('Y-m')
        ];

        $builder = $this->db->table('data_akademik');
        $builder->insert($data_akademik);


        session()->setFlashdata('pesan_hijau', 'Data siswa berhasil ditambahkan');
        return redirect()->to(site_url('admin/data_siswa'));
    }

    public function delete_siswa($siswa_userid)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }
        //cari gambar berdasarkan id

        // $get = $this->siswaModel->find($siswa_userid);
        $builder = $this->db->table('data_siswa');
        $query = $builder->where('siswa_userid', $siswa_userid)->get()->getRowArray();
        // $get = $this->siswaModel->where('siswa_userid', $siswa_userid)->find('id_siswa');
        $get = $query;

        $builder = $this->db->table('data_akademik');
        $builder->where('id_siswa', $get['id_siswa']);
        $cek_dataAkd = $builder->get()->getRowArray();

        if ($cek_dataAkd != null) {
            session()->setFlashdata('pesan_hapus', $get['id_siswa']);
            return redirect()->to(site_url('admin/data_siswa'));
        }

        if ($get['gambar_siswa'] != 'default.jpg') {
            unlink('assets/fotosiswa/' . $get['gambar_siswa']);
        }

        $builder = $this->db->table('users');
        $builder->where('id', $siswa_userid)->delete();

        session()->setFlashdata('pesanSwal', 'Data siswa berhasil dihapus');
        return redirect()->to(site_url('admin/data_siswa'));
    }

    public function hapus_paksaSiswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $id_siswa = $this->request->getVar('id_siswa');

        $builder = $this->db->table('data_siswa');
        $builder->where('id_siswa', $id_siswa);
        $get_siswa = $builder->get()->getRowArray();

        $builder = $this->db->table('data_akademik');
        $builder->where('id_siswa', $id_siswa);
        $builder->delete();

        $builder = $this->db->table('nilai_siswa');
        $builder->where('id_siswa', $id_siswa);
        $builder->delete();

        $builder = $this->db->table('users');
        $builder->where('id', $get_siswa['siswa_userid']);
        $builder->delete();

        session()->setFlashdata('pesan_hijau', 'semua data berhasil di hapus');
        return redirect()->to(site_url('admin/data_siswa'));
    }

    public function mdelete_siswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $id_siswa = $this->request->getVar('id_siswa');

        // dd($id_siswa);

        if ($id_siswa == null) {
            session()->setFlashdata('pesan_merah', 'silahkan ceklist data terlebih dahulu!');
            return redirect()->to(site_url('admin/data_siswa'));
        } else {
            $jml_data = count($id_siswa);
            $jml_eror = 0;
            $jml_sukses = 0;
            for ($i = 0; $i < $jml_data; $i++) {

                $builder = $this->db->table('data_akademik');
                $builder->where('id_siswa', $id_siswa[$i]);
                $cek_data = $builder->get()->getRowArray();

                if ($cek_data == null) {
                    $builder = $this->db->table('data_siswa');
                    $query = $builder->where('id_siswa', $id_siswa[$i])->get()->getRowArray();

                    if ($query['gambar_siswa'] != 'default.jpg') {
                        unlink('assets/fotosiswa/' . $query['gambar_siswa']);
                    }
                    // $this->usersModel->delete($id_siswa[$i]);
                    $builder = $this->db->table('users');
                    $builder->where('id', $query['siswa_userid']);
                    $builder->delete();
                    $jml_sukses++;
                } elseif ($cek_data != null) {
                    $jml_eror++;
                }
            }
            session()->setFlashdata('toastsHijau', $jml_sukses);
            session()->setFlashdata('toastsMerah', $jml_eror);
            return redirect()->to(site_url('admin/data_siswa'));
        }
    }

    public function edit_siswa($siswa_userid)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->select('*');
        $builder->join('data_akademik', 'data_akademik.id_siswa = data_siswa.id_siswa');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_akademik.id_kegiatan');
        $builder->where('siswa_userid', $siswa_userid);
        $query = $builder->get()->getRow();

        $builder = $this->db->table('data_kelasMaster');
        $queryKelas = $builder->get()->getResultArray();

        $builder = $this->db->table('data_kegiatan');
        $queryKegiatan = $builder->get()->getResultArray();

        // dd($query);

        $data = [
            'tittle' => 'Edit Data Siswa',
            'siswa' => $query,
            'kelas' => $queryKelas,
            'kegiatan' => $queryKegiatan,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/edit_siswa', $data);
    }

    public function update_siswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }
        if (!$this->validate([
            'gambar_siswa' => [
                'rules' => 'max_size[gambar_siswa,3024]|is_image[gambar_siswa]|mime_in[gambar_siswa,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar maksimal 3mb',
                    'is_image' => 'yang anda masukan bukan gambar',
                    'mime_in' => 'yang anda masukan bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to(site_url('admin/edit_siswa'))->withInput();
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
            'alamat_siswa' => $alamat_siswa,
            'gambar_siswa' => $gambar_siswa,
            'updated_at' => $time
        ];

        $builder = $this->db->table('data_akademik');
        $builder->where('id_siswa', $this->request->getVar('id_siswa'));
        $cekKelas = $builder->get()->getRowArray();

        if ($this->request->getVar('kelas') != null) {
            if ($cekKelas['id_kelas'] != $this->request->getVar('kelas')) {
                $builder = $this->db->table('data_akademik');
                $builder->where('id_siswa', $this->request->getVar('id_siswa'));
                $builder->where('tahun', date('Y-m'));
                $builder->set('id_kelas', $this->request->getVar('kelas'));
                $builder->update();
                session()->setFlashdata('pesan_ubahKelas', 'data kelas juga berhasil di update');
            } else {
                session()->setFlashdata('pesan_merah', 'kelas gagal di update');
                return redirect()->to(site_url('admin/data_siswa'));
            }
        }
        $builder = $this->db->table('data_siswa');
        $builder->where('id_siswa', $this->request->getVar('id_siswa'));
        $builder->set($data);
        $builder->update();

        session()->setFlashdata('pesan_hijau', 'Data berhasil di update');
        return redirect()->to(site_url('admin/data_siswa'));
    }

    // Pembina

    public function data_pembina()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_pembina');
        $builder->select('*');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_pembina.mengajar_kegiatan');
        $query = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Data Pembina',
            'pembina' => $query
        ];
        return view('admin/data_pembina', $data);
    }

    public function create_pembina()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $getRand = (rand(10000, 99999));

        $builder = $this->db->table('data_kegiatan');
        $query = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Tambah Data Pembina',
            'validation' => \Config\Services::validation(),
            'kegiatan' => $query,
            'getPass' => $getRand
        ];

        return view('admin/create_pembina', $data);
    }

    public function save_pembina()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }
        if (!$this->validate([
            'nip_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kegiatan mengajar harus di isi jika tidak ada ganti "0"',
                ]
            ],
            'nama_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama pembina harus di isi',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'alamat harus di isi jika tidak ada ganti "-"',
                ]
            ],
            'mengajar_kegiatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kegiatan mengajar harus di isi',
                ]
            ],

            'telp_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'telp harus di isi jika tidak ada ganti "-"',
                ]
            ],

            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'username harus di isi',
                ]
            ],
            'password' => [
                'rules' => 'required|is_unique[users.password]',
                'errors' => [
                    'required' => 'password harus di isi',
                    'is_unique' => 'password tidak boleh sama dengan pengguna lain'
                ]
            ],

            'gambar_pembina' => [
                'rules' => 'max_size[gambar_pembina,3024]|is_image[gambar_pembina]|mime_in[gambar_pembina,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar maksimal 3mb',
                    'is_image' => 'yang anda masukan bukan gambar',
                    'mime_in' => 'yang anda masukan bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to(site_url('admin/create_pembina'))->withInput();
        }

        //ambil gambar
        $fileGambarPembina = $this->request->getFile('gambar_pembina');

        //jika tidak ada gambar yang di upload
        if ($fileGambarPembina->getError() == 4) {
            $namaGambarPembina = 'default.jpg';
        } else {
            //ambil nama gambar
            $namaGambarPembina = $fileGambarPembina->getRandomName();
            //pindahkan file ke assets
            $fileGambarPembina->move('assets/fotopembina', $namaGambarPembina);
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $level = $this->request->getVar('level');
        $kegiatan = $this->request->getVar('mengajar_kegiatan');
        $time = Time::createFromDate();

        $data_user = [
            'username' => $username,
            'password' => $password,
            'level' => $level,
            'kegiatan' => $kegiatan,
            'created_at' => $time
        ];

        $nip_pembina = $this->request->getVar('nip_pembina');
        $nama_pembina = $this->request->getVar('nama_pembina');
        $alamat = $this->request->getVar('alamat');
        $mengajar_kegiatan = $this->request->getVar('mengajar_kegiatan');
        $telp_pembina = $this->request->getVar('telp_pembina');
        $gambar_pembina = $namaGambarPembina;
        $time = Time::createFromDate();

        $data = [
            'nip_pembina' => $nip_pembina,
            'nama_pembina' => $nama_pembina,
            'alamat' => $alamat,
            'mengajar_kegiatan' => $mengajar_kegiatan,
            'telp_pembina' => $telp_pembina,
            'gambar_pembina' => $gambar_pembina,
            'created_at' => $time
        ];

        $this->pembinaModel->savePembina($data_user, $data);

        session()->setFlashdata('pesan_hijau', 'Data pembina berhasil ditambahkan');
        return redirect()->to(site_url('admin/data_pembina'));
    }

    public function delete_pembina($pembina_userid)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_pembina');
        $builder->where('pembina_userid', $pembina_userid);
        $get = $builder->get()->getRowArray();

        $builder = $this->db->table('data_akademik');
        $builder->where('id_pembina', $get['id_pembina']);
        $cek_pembina = $builder->get()->getRowArray();

        if ($cek_pembina != null) {
            session()->setFlashdata('pesan_merah', 'data agal di hapus');
            return redirect()->to(site_url('admin/data_pembina'));
        }

        if ($get['gambar_pembina'] != 'default.jpg') {
            unlink('assets/fotopembina/' . $get['gambar_pembina']);
        }

        $builder = $this->db->table('users');
        $builder->where('id', $pembina_userid)->delete();

        session()->setFlashdata('pesan_hijau', 'Data pembina berhasil di hapus');
        return redirect()->to(site_url('admin/data_pembina'));
    }

    public function mdelete_pembina()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $pembina_userid = $this->request->getVar('pembina_userid');

        if ($pembina_userid == null) {
            session()->setFlashdata('pesan_merah', 'ceklist data terlbih dahulu');
            return redirect()->to(site_url('admin/data_pembina'));
        } else {
            $jml_data = count($pembina_userid);

            for ($i = 0; $i < $jml_data; $i++) {

                $builder = $this->db->table('data_pembina');
                $builder->where('pembina_userid', $pembina_userid[$i]);
                $get = $builder->get()->getRowArray();

                if ($get['gambar_pembina'] != 'default.jpg') {
                    unlink('assets/fotopembina/' . $get['gambar_pembina']);
                }

                $this->usersModel->delete($pembina_userid[$i]);
                session()->setFlashdata('pesan_hijau', 'Data pembina sebanyak ' . $jml_data . ' berhasil di hapus');
                return redirect()->to(site_url('admin/data_pembina'));
            }
        }
    }

    public function edit_pembina($pembina_userid)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_pembina');
        $builder->select('*');
        $builder->join('users', 'users.id = data_pembina.pembina_userid');
        $builder->where('pembina_userid', $pembina_userid);
        $query = $builder->get()->getRow();

        $builder = $this->db->table('data_kegiatan');
        $get_kegiatan = $builder->get()->getResultArray();

        // dd($query);

        $data = [
            'tittle' => 'Ubah Data Pembina',
            'pembina' => $query,
            'validation' => \Config\Services::validation(),
            'kegiatan' => $get_kegiatan
        ];
        return view('admin/edit_pembina', $data);
    }

    public function update_pembina()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }
        if (!$this->validate([
            'nip_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kegiatan mengajar harus di isi jika tidak ada ganti "-"',
                ]
            ],
            'nama_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama pembina harus di isi',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'alamat harus di isi jika tidak ada ganti "-"',
                ]
            ],
            'mengajar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kegiatan mengajar harus di isi',
                ]
            ],

            'telp_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'telp harus di isi jika tidak ada ganti "-"',
                ]
            ],

            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'username harus di isi',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password harus di isi',
                ]
            ],

            'gambar_pembina' => [
                'rules' => 'max_size[gambar_pembina,3024]|is_image[gambar_pembina]|mime_in[gambar_pembina,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar maksimal 3mb',
                    'is_image' => 'yang anda masukan bukan gambar',
                    'mime_in' => 'yang anda masukan bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to(site_url('admin/edit_pembina'))->withInput();
        }

        $fileGambarPembina = $this->request->getFile('gambar_pembina');

        //cek gambar apakah tetap gambar lama
        if ($fileGambarPembina->getError() == 4) {
            $namaGambarPembina = $this->request->getVar('gambarLama');
        } else {
            //ambil nama gambar
            $namaGambarPembina = $fileGambarPembina->getRandomName();
            //pindahkan file ke assets
            $fileGambarPembina->move('assets/fotopembina', $namaGambarPembina);
            //hapus file lama
            if ($this->request->getVar('gambarLama') != 'default.jpg') {
                unlink('assets/fotopembina/' . $this->request->getVar('gambarLama'));
            }
        }

        $pembina_userid = $this->request->getVar('pembina_userid');
        $nip_pembina = $this->request->getVar('nip_pembina');
        $nama_pembina = $this->request->getVar('nama_pembina');
        $alamat = $this->request->getVar('alamat');
        $mengajar = $this->request->getVar('mengajar');
        $telp_pembina = $this->request->getVar('telp_pembina');
        $gambar_pembina = $namaGambarPembina;
        $time = Time::createFromDate();

        $data = [
            'pembina_userid' => $pembina_userid,
            'nip_pembina' => $nip_pembina,
            'nama_pembina' => $nama_pembina,
            'alamat' => $alamat,
            'mengajar_kegiatan' => $mengajar,
            'telp_pembina' => $telp_pembina,
            'gambar_pembina' => $gambar_pembina,
            'updated_at' => $time
        ];

        $builder = $this->db->table('data_pembina');
        $builder->where('pembina_userid', $pembina_userid)->update($data);

        $id = $this->request->getVar('pembina_userid');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $level = $this->request->getVar('level');
        $kegiatan = $this->request->getVar('mengajar');
        $time = Time::createFromDate();

        $data_user = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'level' => $level,
            'kegiatan' => $kegiatan,
            'updated_at' => $time
        ];

        $builder = $this->db->table('users');
        $builder->where('id', $id)->update($data_user);


        return redirect()->to(site_url('admin/data_pembina'));
    }

    public function template_import()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Cilibri')
            ->setSize(12);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'NIS')
            ->setCellValue('C1', 'NAMA')
            ->setCellValue('D1', 'L/P')
            ->setCellValue('E1', 'KELAS')
            ->setCellValue('F1', 'PASSWORD LOGIN');

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:F1')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        //lebar kolom per cell
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(4);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(9);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(26);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(9);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(10);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(17);

        $nomer = 1;
        $column = 2;
        while ($nomer <= 13) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $column, $nomer++);
            $spreadsheet->getActiveSheet()
                ->getStyle('A' . $column . ':' . 'F' . $column)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-Template-import';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    //import file excel
    public function import_excel()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_kegiatan');
        $query = $builder->get()->getResultArray();

        $builder = $this->db->table('tahun_akademik');
        $id_thnAkd = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Import Data Excel',
            'kegiatan' => $query,
            'thn_akd' => $id_thnAkd,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/import_excel', $data);
    }

    public function save_excel()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        if (!$this->validate(
            [
                'fileimport' => [
                    'label' => 'Inputan File',
                    'rules' => 'uploaded[fileimport]|ext_in[fileimport,xls,xlsx]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'ext_in' => '{field} bukan extesi xls atau xlsx'
                    ]
                ],
                'pilihan_ekstra' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'kegiatan ekstrakurikuler harus di isi',
                    ]
                ],
                'status_validasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'status validasi harus di isi',
                    ]
                ]
            ]

        )) {
            session()->setFlashdata('pesan_merah', 'Data gagal di import');
            return redirect()->to(site_url('admin/import_excel'))->withInput();
        }

        $file_excel = $this->request->getFile('fileimport');

        $ext = $file_excel->getClientExtension();

        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $render->load($file_excel);

        $data_simpan = $spreadsheet->getActiveSheet()->toArray();

        $jml_sukses = 0;
        $jml_erorr = 0;
        foreach ($data_simpan as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $builder = $this->db->table('data_kelasmaster');
            $builder->where('nama_kelas', $row[4]);
            $cek_kelas = $builder->get()->getRowArray();

            if ($cek_kelas != null) {

                $nis_siswa = $row[1];
                $nama_siswa = $row[2];
                $jk = $row[3];
                $kelas = $cek_kelas['id_kelas'];
                $pilihan_ekstra = $this->request->getVar('pilihan_ekstra');
                $alamat_siswa = '-';
                $gambar_siswa = 'default.jpg';
                $time = Time::createFromDate();

                $data = [
                    'nis_siswa' => $nis_siswa,
                    'nama_siswa' => $nama_siswa,
                    'jk' => $jk,
                    'pilihan_kegiatan' => $pilihan_ekstra,
                    'alamat_siswa' => $alamat_siswa,
                    'gambar_siswa' => $gambar_siswa,
                    'created_at' => $time
                ];

                $username = $row[1];
                $password = $row[5];
                $level = '3';
                $kegiatan = $this->request->getVar('pilihan_ekstra');
                $time = Time::createFromDate();

                // if ($this->request->getVar('status_validasi') == 'sudah validasi') {
                //     $status_validasi = 'sudah validasi';
                // } elseif ($this->request->getVar('status_validasi') == 'validasi nilai') {
                //     $status_validasi = 'validasi nilai';
                // }

                $data_user = [
                    'username' => $username,
                    'password' => $password,
                    'level' => $level,
                    'kegiatan' => $kegiatan,
                    'status' => ($this->request->getVar('status_validasi') == 'sudah validasi' ? 'sudah validasi' : 'validasi nilai'),
                    'created_at' => $time
                ];

                $this->siswaModel->saveSiswa($data_user, $data);
                $id_siswa = $this->db->insertID();

                $builder = $this->db->table('data_pembina');
                $builder->where('mengajar_kegiatan', $pilihan_ekstra);
                $get_pembina = $builder->get()->getRowArray();

                $builder = $this->db->table('data_kegiatan');
                $builder->where('id_kegiatan', $pilihan_ekstra);
                $get_kegitan = $builder->get()->getRowArray();


                if ($get_pembina == null) {
                    session()->setFlashdata('pesan_merah', 'data gagal di import!!. kegiatan ' . $get_kegitan['nama_kegiatan'] . ' tidak ada pembina.. silahkan tambah pembina ' . $get_kegitan['nama_kegiatan'] . ' dan coba kembali');
                    return redirect()->to(site_url('admin/import_excel'));
                }

                $data_akademik = [
                    'id_siswa' => $id_siswa,
                    'id_pembina' => $get_pembina['id_pembina'],
                    'id_kelas' => $kelas,
                    'id_kegiatan' => $pilihan_ekstra,
                    'id_thnAkd' => $this->request->getVar('id_thnAkd'),
                    'tahun' => date('Y-m')
                ];

                $builder = $this->db->table('data_akademik');
                $builder->insert($data_akademik);

                $builder = $this->db->table('jadwal_kegiatan');
                $builder->where('id_kegiatan', $pilihan_ekstra);
                $cek_jadwal = $builder->get()->getRowArray();

                if ($this->request->getVar('status_validasi') == 'sudah validasi') {
                    if ($cek_jadwal != null) {
                        if ($cek_jadwal['J_bulan'] == date('Y-m')) {

                            $builder = $this->db->table('jadwal_kegiatan');
                            $builder->where('id_kegiatan', $pilihan_ekstra);
                            $get_jadwal = $builder->get();

                            foreach ($get_jadwal->getResult() as $row) {

                                $data_nilai = [
                                    'id_siswa' => $id_siswa,
                                    'nilai' => '',
                                    'id_jadwal' => $row->id_jadwal,
                                    'thn_akademik' => $this->request->getVar('id_thnAkd'),
                                    'created_at' => Time::now()
                                ];

                                $builder = $this->db->table('nilai_siswa');
                                $builder->insert($data_nilai);
                            }
                        }
                    }
                }
                $jml_sukses++;
            } elseif ($cek_kelas == null) {
                $jml_erorr++;
            }
        }
        session()->setFlashdata('pesan_hijau', 'Import data berhasil sebannyak ' . $jml_sukses . '<br> gagal di import sebanyak ' . $jml_erorr . ' data');
        return redirect()->to(site_url('admin/data_siswa'));
    }

    public function data_kegiatan()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_kegiatan');
        $query = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Data Kegiatan',
            'kegiatan' => $query
        ];

        return view('admin/data_kegiatan', $data);
    }

    public function create_kegiatan()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $data = [
            'tittle' => 'Tambah Kegiatan',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/create_kegiatan', $data);
    }

    public function save_kegiatan()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        if (!$this->validate([
            'nama_kegiatan' => [
                'rules' => 'required|is_unique[data_kegiatan.id_kegiatan]',
                'errors' => [
                    'required' => 'nama kegiatan harus di isi',
                    'is_unique' => 'nama kegiatan sudah ada'
                ]
            ],
        ])) {
            return redirect()->to(site_url('admin/create_kegiatan'))->withInput();
        }

        $data = [
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'deskripsi_kegiatan' => $this->request->getVar('deskripsi_kegiatan'),
        ];

        $builder = $this->db->table('data_kegiatan');
        $builder->insert($data);

        session()->setFlashdata('pesan_hijau', 'data kegiatan berhasil di tambahkan');
        return redirect()->to(site_url('admin/data_kegiatan'));
    }

    public function delete_kegiatan($id_kegiatan)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->where('pilihan_kegiatan', $id_kegiatan);
        $cek_kegiatan = $builder->get()->getRowArray();

        if ($cek_kegiatan != null) {
            session()->setFlashdata('pesan_merah', 'gagal menghapus!!. data kegiatan sedang di pakai');
            return redirect()->to(site_url('admin/data_kegiatan'));
        }

        $builder = $this->db->table('data_kegiatan');
        $builder->where('id_kegiatan', $id_kegiatan);
        $builder->delete();

        session()->setFlashdata('pesan_hijau', 'data berhasil di hapus');
        return redirect()->to(site_url('admin/data_kegiatan'));
    }

    public function edit_kegiatan($id_kegiatan)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_kegiatan');
        $builder->where('id_kegiatan', $id_kegiatan);
        $query = $builder->get()->getRow();

        $data = [
            'tittle' => 'Edit Kegiatan',
            'kegiatan' => $query
        ];

        return view('admin/edit_kegiatan', $data);
    }

    public function update_kegiatan()
    {
        $data = [
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'deskripsi_kegiatan' => $this->request->getVar('deskripsi_kegiatan'),
        ];

        $builder = $this->db->table('data_kegiatan');
        $builder->where('id_kegiatan', $this->request->getVar('id_kegiatan'));
        $builder->update($data);

        session()->setFlashdata('pesan_hijau', 'data kegiatan ' . $this->request->getVar('nama_kegiatan') . ' berhasil di update');
        return redirect()->to(site_url('admin/data_kegiatan'));
    }

    public function data_kelasMaster()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_kelasMaster');
        $query = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Data Kelas Master',
            'kelas' => $query
        ];

        return view('admin/data_kelasMaster', $data);
    }

    public function detail_kelasMaster($id_kelas)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_akademik');
        // $builder->select('nis_siswa,nama_siswa,nama_pembina,nama_kelas,nama_kegiatan');
        $builder->join('data_siswa', 'data_siswa.id_siswa = data_akademik.id_siswa');
        $builder->join('data_pembina', 'data_pembina.id_pembina = data_akademik.id_pembina');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_akademik.id_kegiatan');
        $builder->where('id_kelas', $id_kelas);
        $builder->orderBy('id_akademik', 'DESC');
        $get_siswa = $builder->get()->getResultArray();


        $builder = $this->db->table('tahun_akademik');
        $get_thnAkd = $builder->get()->getResultArray();


        $builder = $this->db->table('data_kelasmaster');
        $get_listKelas = $builder->get()->getResultArray();

        $builder = $this->db->table('data_kelasmaster');
        $builder->where('id_kelas', $id_kelas);
        $get_kelas = $builder->get()->getRowArray();

        // dd($query);

        $data = [
            'tittle' => 'Data Siswa ' . $get_kelas['nama_kelas'],
            'validation' => \Config\Services::validation(),
            'kelas_now' => $get_kelas,
            'list_kelas' => $get_listKelas,
            'get_thnAkd' => $get_thnAkd,
            'siswa' => $get_siswa
        ];

        return view('admin/detail_kelas', $data);
    }

    public function save_kenaikanKelas()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }


        $id_siswa = $this->request->getVar('id_siswa');
        $naik_kelas = $this->request->getVar('naik_kelas');
        $id_thnAkd = $this->request->getVar('id_thnAkd');

        if ($id_siswa == null) {
            session()->setFlashdata('pesan_merah', 'silahkan ceklist data terlebih dahulu!');
            return redirect()->to(site_url('admin/detail_kelasMaster/' . $this->request->getVar('kelas_now')));
        } else {
            if ($naik_kelas == 'tidak_naik') {
                $jml_data = count($id_siswa);
                for ($i = 0; $i < $jml_data; $i++) {

                    $data = [
                        'id_siswa' => $id_siswa[$i],
                        'id_pembina' => $this->request->getVar('id_pembina'),
                        'id_kelas' => $this->request->getVar('kelas_now'),
                        'id_kegiatan' => $this->request->getVar('id_kegiatan'),
                        'id_thnAkd' => $id_thnAkd,
                        'tahun' => $this->request->getVar('tahun')
                    ];

                    // dd($data);

                    $builder = $this->db->table('data_akademik');
                    $builder->insert($data);

                    $builder = $this->db->table('data_siswa');
                    $builder->join('users', 'users.id = data_siswa.siswa_userid');
                    $builder->where('id_siswa', $id_siswa[$i]);
                    $builder->set('pilihan_kegiatan', $this->request->getVar('id_kegiatan'));
                    $builder->set('kegiatan', $this->request->getVar('id_kegiatan'));
                    $builder->update();
                }
            }
            $jml_data = count($id_siswa);
            for ($i = 0; $i < $jml_data; $i++) {

                $data = [
                    'id_siswa' => $id_siswa[$i],
                    'id_pembina' => $this->request->getVar('id_pembina'),
                    'id_kelas' => $this->request->getVar('naik_kelas'),
                    'id_kegiatan' => $this->request->getVar('id_kegiatan'),
                    'id_thnAkd' => $id_thnAkd,
                    'tahun' => $this->request->getVar('tahun')
                ];

                // dd($data);

                $builder = $this->db->table('data_akademik');
                $builder->insert($data);

                $builder = $this->db->table('data_siswa');
                $builder->where('id_siswa', $id_siswa[$i]);
                $get_id = $builder->get()->getRowArray();

                $builder = $this->db->table('users');
                $builder->where('id', $get_id['siswa_userid']);
                $builder->set('kegiatan', $this->request->getVar('id_kegiatan'));

                $builder = $this->db->table('data_siswa');
                $builder->where('id_siswa', $id_siswa[$i]);
                $builder->set('pilihan_kegiatan', $this->request->getVar('id_kegiatan'));
                $builder->update();
            }
            session()->setFlashdata('pesan_hijau', 'data kenaikan kelas siswa berhasil di ubah');
            return redirect()->to(site_url('admin/data_kelasMaster'));
        }
    }

    public function save_kelasMaster()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $kelas = $this->request->getVar('kelas');
        $jurusan = $this->request->getVar('jurusan');
        $nomor = $this->request->getVar('nomor');

        $get_kelas = $kelas . ' ' . $jurusan . ' ' . $nomor;

        $data = [
            'nama_kelas' => $get_kelas
        ];

        $builder = $this->db->table('data_kelasMaster');
        $builder->where('nama_kelas', $get_kelas);
        $get_name = $builder->get()->getRowArray();

        if ($get_name == null) {
            if ($this->request->getVar('nama_kelas') == '') {
                session()->setFlashdata('pesan_merah', 'nama kelas tidak boleh kosong');
                return redirect()->to(site_url('admin/data_kelasMaster'));
            }
            $builder = $this->db->table('data_kelasMaster');
            $builder->insert($data);
            session()->setFlashdata('pesan_hijau', 'nama kelas ' . $this->request->getVar('nama_kelas') . ' berhasil ditambahkan');
            return redirect()->to(site_url('admin/data_kelasMaster'));
        } else {
            session()->setFlashdata('pesan_merah', 'nama kelas ' . $get_name['nama_kelas'] . ' sudah ada!');
            return redirect()->to(site_url('admin/data_kelasMaster'));
        }
    }

    public function delete_kelasMaster($id_kelas)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_akademik');
        $builder->where('id_kelas', $id_kelas);
        $get_kelasSiswa = $builder->get()->getRowArray();

        if ($get_kelasSiswa != null) {
            session()->setFlashdata('pesan_merah', 'Nama kelas sedang di pakai');
            return redirect()->to(site_url('admin/data_kelasMaster'));
        }

        $builder = $this->db->table('data_kelasMaster');
        $builder->where('id_kelas', $id_kelas);
        $builder->delete();

        session()->setFlashdata('pesan_hijau', 'nama kelas berhasil dihapus');
        return redirect()->to(site_url('admin/data_kelasMaster'));
    }

    public function data_users()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $cariLevel = $this->request->getVar('cariLevel');

        if ($cariLevel == 2) {
            $builder = $this->db->table('users');
            $builder->join('data_pembina', 'data_pembina.pembina_userid = users.id');
            $builder->where('level', $cariLevel);
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $cariLevel);
        } elseif ($cariLevel == 3) {
            $builder = $this->db->table('users');
            $builder->join('data_siswa', 'data_siswa.siswa_userid = users.id');
            $builder->where('level', $cariLevel);
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $cariLevel);
        } else {
            $builder = $this->db->table('users');
            $builder->join('data_siswa', 'data_siswa.siswa_userid = users.id');
            $builder->where('level', 3);
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $cariLevel);
        }


        $data = [
            'tittle' => 'Data Users',
            'users' => $query,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/data_users', $data);
    }

    public function update_users()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('users');
        $builder->where('id', $this->request->getVar('id'));
        $builder->set('username', $this->request->getVar('username'));
        $builder->set('password', $this->request->getVar('password'));
        $builder->update();

        session()->setFlashdata('pesan_hijau', 'data users berhasil di ubah');
        return redirect()->to(site_url('admin/data_users'));
    }

    public function delete_users($id)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('users');
        $builder->where('id', $id);
        $builder->delete();

        session()->setFlashdata('pesan_hijau', 'data users di hapus');
        return redirect()->to(site_url('admin/data_users'));
    }

    public function tahun_akademik()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->orderBy('tahun', 'ASC');
        $tahun = $builder->get()->getResultArray();

        $data = [
            'tittle' => 'Tahun Akademik',
            'tahun' => $tahun
        ];

        return view('admin/tahun_akademik', $data);
    }

    public function save_thnAkd()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $tahun1 = $this->request->getVar('tahun1');
        $tahun2 = $this->request->getVar('tahun2');
        $tahun_akademik = $tahun1 . '/' . $tahun2;

        $builder = $this->db->table('tahun_akademik');
        $builder->where('tahun', $tahun_akademik);
        $cek_tahun =  $builder->get()->getRowArray();

        if ($tahun1 == $tahun2) {
            session()->setFlashdata('pesan_merah', 'tahun1 dan tahun2 tidak boleh sama');
            return redirect()->to(site_url('admin/tahun_akademik'));
        } elseif ($cek_tahun != null) {
            if ($cek_tahun['tahun'] == $tahun_akademik) {
                session()->setFlashdata('pesan_merah', 'data tahun ' . $tahun_akademik . ' sudah ada di data');
                return redirect()->to(site_url('admin/tahun_akademik'));
            }
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->insert(['tahun' => $tahun_akademik, 'status' => 'tidak aktif']);

        session()->setFlashdata('pesan_hijau', 'tahun akademik ' . $tahun_akademik . ' berhasil ditambahkan');
        return redirect()->to(site_url('admin/tahun_akademik'));
    }

    public function delete_thnAkd($id_thnAkd)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('data_akademik');
        $builder->where('id_thnAkd', $id_thnAkd);
        $cek_data = $builder->get()->getRowArray();

        if ($cek_data) {
            session()->setFlashdata('pesan_merah', 'tahun akadmik gagal dihapus karena ada data di data akademik. silahkan cek detail');
            return redirect()->to(site_url('admin/tahun_akademik'));
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->where('id_thnAkd', $id_thnAkd);
        $builder->delete();

        session()->setFlashdata('pesan_hijau', 'tahun akademik berhasil dihapus');
        return redirect()->to(site_url('admin/tahun_akademik'));
    }

    public function update_thnAkd()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $id_thnAkd = $this->request->getVar('id_thnAkd');
        $tahun = $this->request->getVar('tahun');

        $builder = $this->db->table('tahun_akademik');
        $builder->where('id_thnAkd', $id_thnAkd);
        $builder->set('tahun', $tahun);
        $builder->update();

        session()->setFlashdata('pesan_hijau', 'tahun akademik berhasil di update');
        return redirect()->to(site_url('admin/tahun_akademik'));
    }

    public function setting_thnAkd($id_thnAkd)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->where('id_thnAkd', $id_thnAkd);
        $cek_tahunAkd = $builder->get()->getRowArray();


        if ($cek_tahunAkd['status'] == 'aktif') {
            session()->setFlashdata('pesan_merah', 'tahun akademik sudah di aktifkan');
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $builder->set('status', 'tidak aktif');
        $builder->update();

        $builder = $this->db->table('tahun_akademik');
        $builder->where('id_thnAkd', $id_thnAkd);
        $builder->set('status', 'aktif');
        $builder->update();

        session()->setFlashdata('pesan_hijau', 'tahun akademik berhasil di update');
        return redirect()->to(site_url('admin/tahun_akademik'));
    }


    public function detail_thnAkd($id_thnAkd)
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $builder = $this->db->table('data_akademik');
            $builder->select('nis_siswa,nama_siswa,nama_pembina,nama_kelas,nama_kegiatan');
            $builder->join('data_siswa', 'data_siswa.id_siswa = data_akademik.id_siswa');
            $builder->join('data_pembina', 'data_pembina.id_pembina = data_akademik.id_pembina');
            $builder->join('data_kelasmaster', 'data_kelasmaster.id_kelas = data_akademik.id_kelas');
            $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_akademik.id_kegiatan');
            $builder->where('id_thnAkd', $id_thnAkd);
            $builder->where('tahun', $keyword);
            $builder->orderBy('id_akademik', 'DESC');
            $get_dataAkd = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch');
        } else {
            $builder = $this->db->table('data_akademik');
            $builder->select('nis_siswa,nama_siswa,nama_pembina,nama_kelas,nama_kegiatan');
            $builder->join('data_siswa', 'data_siswa.id_siswa = data_akademik.id_siswa');
            $builder->join('data_pembina', 'data_pembina.id_pembina = data_akademik.id_pembina');
            $builder->join('data_kelasmaster', 'data_kelasmaster.id_kelas = data_akademik.id_kelas');
            $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_akademik.id_kegiatan');
            $builder->where('id_thnAkd', $id_thnAkd);
            $builder->where('tahun', date('Y-m'));
            $builder->orderBy('id_akademik', 'DESC');
            $get_dataAkd = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch');
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->where('id_thnAkd', $id_thnAkd);
        $get_tahun = $builder->get()->getRowArray();

        $data = [
            'tittle' => 'Detail Tahun Akademik ' . $get_tahun['tahun'],
            'akademik' => $get_dataAkd
        ];

        return view('admin/detail_thnAkd', $data);
    }

    public function reset_siswa()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $reset = $this->request->getVar('reset');

        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $cek_data = $builder->get()->getRowArray();

        if ($reset) {
            $builder = $this->db->table('users');
            $builder->where('level', '3');
            $builder->where('status !=', 'tidak aktif');
            $reset_ulang =  $builder->get()->getRowArray();
            if ($reset_ulang['status'] == 'validasi data kembali') {
                session()->setFlashdata('pesan_reset', 'Data akan di kembalikan ke sudah validasi. apakah anda yakin? jika ya klik tombol kembalikan <br>');
                return redirect()->to(site_url('admin/data_register'));
            } elseif ($reset_ulang['status'] == 'sudah validasi') {
                $builder = $this->db->table('users');
                $builder->where('level', '3');
                $builder->where('status !=', 'tidak aktif');
                $builder->set('status', 'validasi data kembali');
                $builder->update();
                session()->setFlashdata('pesan_hijau', 'data sudah di reset');
                return redirect()->to(site_url('admin/data_register'));
            }
        }

        if ($cek_data != null) {
            session()->setFlashdata('pesan_confirm', 'Tahun akademik yang aktif sekarang ' . $cek_data['tahun'] . ' apakah anda yakin ingin mereset ?');
            return redirect()->to(site_url('admin/data_register'));
        }
    }

    public function kembalikan_ulang()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('users');
        $builder->where('level', '3');
        $builder->where('status !=', 'tidak aktif');
        $cek_status = $builder->get()->getRowArray();
        if ($cek_status['status'] == 'sudah validasi') {
            session()->setFlashdata('pesan_merah', 'data sudah di reset sebelumnya');
            return redirect()->to(site_url('admin/data_register'));
        } elseif ($cek_status['status'] == 'validasi data kembali') {
            $builder = $this->db->table('users');
            $builder->where('level', '3');
            $builder->where('status !=', 'tidak aktif');
            $builder->set('status', 'sudah validasi');
            $builder->update();
            session()->setFlashdata('pesan_hijau', 'data sudah di kembalikan ke sudah validasi');
            return redirect()->to(site_url('admin/data_register'));
        }
    }
}
