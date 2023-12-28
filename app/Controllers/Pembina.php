<?php

namespace App\Controllers;

use App\Models\NilaiModel;
use App\Models\SiswaModel;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Pembina extends BaseController
{
    protected $db;
    protected $siswaModel;
    protected $nilaiModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->siswaModel = new SiswaModel();
        $this->nilaiModel = new NilaiModel();
    }
    public function dashboard()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $get_siswa = $builder->countAllResults();

        $builder = $this->db->table('users');
        $builder->where('kegiatan', session()->get('kegiatan'));
        $builder->where('level', 3);
        $builder->where('status', 'sudah validasi');
        $get_info = $builder->countAllResults();

        $builder = $this->db->table('users');
        $builder->where('kegiatan', session()->get('kegiatan'));
        $builder->where('status', 'validasi nilai');
        $get_notValidasi = $builder->countAllResults();

        $builder = $this->db->table('data_pembina');
        $builder->join('data_kegiatan', 'data_kegiatan.id_kegiatan = data_pembina.mengajar_kegiatan');
        $builder->where('pembina_userid', session()->get('id'));
        $query = $builder->get()->getRow();

        // dd($query);

        $data = [
            'tittle' => 'Dashboard',
            'get_siswa' => $get_siswa,
            'get_info' => $get_info,
            'get_notValidasi' => $get_notValidasi,
            'pembina' => $query
        ];

        return view('pembina/dashboard', $data);
    }

    public function edit_profile($id_pembina)
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
        }

        $builder = $this->db->table('data_pembina');
        $builder->where('id_pembina', $id_pembina);
        $query = $builder->get()->getRow();

        $data = [
            'tittle' => 'Edit Profil',
            'pembina' => $query,
            'validation' => \Config\Services::validation()
        ];
        return view('pembina/edit_profile', $data);
    }

    public function update_profile()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
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

            'telp_pembina' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'telp harus di isi jika tidak ada ganti "-"',
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
            return redirect()->to(site_url('pembina/edit_profile/' . $this->request->getVar('id_pembina')))->withInput();
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

        $builder = $this->db->table('data_pembina');
        $builder->where('id_pembina', $this->request->getVar('id_pembina'));
        $builder->set('nip_pembina', $this->request->getVar('nip_pembina'));
        $builder->set('nama_pembina', $this->request->getVar('nama_pembina'));
        $builder->set('alamat', $this->request->getVar('alamat'));
        $builder->set('telp_pembina', $this->request->getVar('telp_pembina'));
        $builder->set('gambar_pembina', $namaGambarPembina);
        $builder->set('updated_at', Time::now());
        $builder->update();

        session()->setFlashdata('pesan_hijau', 'Profil berhasil di update');
        return redirect()->to(site_url('pembina/dashboard'));
    }

    public function siswa()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
        }

        $builder = $this->db->table('data_siswa');
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $query = $builder->get()->getResultArray();

        $builder = $this->db->table('tahun_akademik');
        $get_thnAkd = $builder->get()->getResultArray();


        $data = [
            'tittle' => 'Siswa',
            'murid' => $query,
            'tahun_akd' => $get_thnAkd,
        ];

        return view('pembina/siswa', $data);
    }

    public function validasi_nilai()
    {
        $builder = $this->db->table('data_siswa');
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $builder->orderBy('id_siswa', 'DESC');
        $siswa = $builder->get()->getResultArray();

        $get_status = $builder = $this->db->table('users');

        $data = [
            'tittle' => 'Validasi Nilai Siswa',
            'siswa' => $siswa,
            'builder' => $get_status,
        ];

        return view('pembina/validasi_nilai', $data);
    }

    public function update_validasiNilai($id_siswa)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id_siswa);
        $builder->where('level', 3);
        $builder->where('kegiatan', session()->get('kegiatan'));
        $cek_status = $builder->get()->getRowArray();

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $builder->where('J_bulan', date('Y-m'));
        $cek_jadwal = $builder->get()->getRowArray();

        if ($cek_jadwal != null) {
            if ($cek_status['status'] == 'validasi data kembali') {
                session()->setFlashdata('pesan_merah', 'data belum di lengkapi');
                return redirect()->to(site_url('pembina/validasi_nilai'));
            } elseif ($cek_status['status'] == 'sudah validasi') {
                session()->setFlashdata('pesan_merah', 'data sudah di validasi');
                return redirect()->to(site_url('pembina/validasi_nilai'));
            } elseif ($cek_status['status'] == 'validasi nilai') {
                $builder = $this->db->table('tahun_akademik');
                $builder->where('status', 'aktif');
                $get_thnAkd = $builder->get()->getRowArray();

                $builder = $this->db->table('data_siswa');
                $builder->where('siswa_userid', $id_siswa);
                $get_siswa = $builder->get()->getRowArray();

                $builder = $this->db->table('jadwal_kegiatan');
                $builder->where('id_kegiatan', session()->get('kegiatan'));
                $get_jadwal = $builder->get();


                foreach ($get_jadwal->getResult() as $row) {

                    $data_nilai = [
                        'id_siswa' => $get_siswa['id_siswa'],
                        'nilai' => ' ',
                        'id_jadwal' => $row->id_jadwal,
                        'thn_akademik' => $get_thnAkd['id_thnAkd'],
                        'created_at' => Time::now()
                    ];

                    $builder = $this->db->table('nilai_siswa');
                    $builder->insert($data_nilai);
                }

                $builder = $this->db->table('users');
                $builder->where('id', $id_siswa);
                $builder->set('status', 'sudah validasi');
                $builder->update();
            }
        } else {
            session()->setFlashdata('pesan_merah', 'jadwal kosong silahkan buat jadwal terlebih dahulu');
            return redirect()->to(site_url('pembina/validasi_nilai'));
        }

        session()->setFlashdata('pesan_hijau', 'validasi siswa sudah di update silahkan cek nilai..');
        return redirect()->to(site_url('pembina/validasi_nilai'));
    }

    public function detail_nilai($id_siswa)
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
        }

        $J_bulan = $this->request->getVar('keyword');

        if ($J_bulan) {
            $builder = $this->db->table('nilai_siswa');
            $builder->select('*');
            $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal');
            $builder->join('tahun_akademik', 'tahun_akademik.id_thnAkd = nilai_siswa.thn_akademik');
            $builder->where('id_siswa', $id_siswa);
            $builder->where('J_bulan', $J_bulan);
            $builder->where('status', 'aktif');
            $builder->where('id_kegiatan', session()->get('kegiatan'));
            $nilai = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $J_bulan);
        } else {
            $builder = $this->db->table('nilai_siswa');
            $builder->select('*');
            $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal');
            $builder->join('tahun_akademik', 'tahun_akademik.id_thnAkd = nilai_siswa.thn_akademik');
            $builder->where('id_siswa', $id_siswa);
            $builder->where('J_bulan', date('Y-m'));
            $builder->where('status', 'aktif');
            $builder->where('id_kegiatan', session()->get('kegiatan'));
            $nilai = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $J_bulan);
        }

        $builder =  $this->db->table('data_siswa');
        $builder->where('id_siswa', $id_siswa);
        $get_siswa = $builder->get()->getRowArray();

        // dd($nilai);

        $data = [
            'tittle' => 'Detail Nilai',
            'nilai' => $nilai,
            'siswa' => $get_siswa
        ];

        return view('pembina/detail_nilai', $data);
    }

    public function cek_nilai()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
        }

        $J_bulan = $this->request->getVar('J_bulan');

        $builder = $this->db->table('data_akademik');
        $builder->select('*');
        $builder->join('data_siswa', 'data_siswa.id_siswa = data_akademik.id_siswa');
        $builder->join('users', 'users.id = data_siswa.siswa_userid');
        $builder->where('tahun', $J_bulan);
        $builder->where('id_thnAkd', $this->request->getVar('id_thnAkd'));
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $cek_siswa = $builder->get();


        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $builder->where('J_bulan', $J_bulan);
        $get_jadwal = $builder->get()->getResultArray();

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('J_bulan', $J_bulan);
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $get_bulan = $builder->get()->getRowArray();
        $get_count = $builder->countAllResults();

        if ($get_bulan != null) {
            $ambilBulan = $get_bulan['J_bulan'];
        } else {
            $ambilBulan = 'tidak ada data';
        }

        $builder = $this->db->table('nilai_siswa');
        $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal', 'left');
        $builder->where('thn_akademik', $this->request->getVar('id_thnAkd'));
        $builder->where('J_bulan', $this->request->getVar('J_bulan'));
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $get_nilai = $builder->get();


        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $get_thnAkd = $builder->get()->getRowArray();

        $data = [
            'tittle' => 'Nilai Siswa',
            'cek_siswa' => $cek_siswa,
            'get_nilai' => $get_nilai,
            'jadwal' => $get_jadwal,
            'bulan' => $ambilBulan,
            'count' => $get_count,
            'tahunAkd' => $get_thnAkd,
            'bulan' => $J_bulan
        ];

        return view('pembina/cek_nilai', $data);
    }

    public function update_nilai()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('/'));
        }

        $id_nilai = $this->request->getVar('id_nilai');
        $nilai = $this->request->getVar('nilai');

        // dd([$id_nilai, $nilai]);
        if ($id_nilai == null) {
            session()->setFlashdata('pesan_merah', 'centang data terlebih dahulu kemudian simpan data');
            return redirect()->to(site_url('pembina/detail_nilai/' . $this->request->getVar('id_siswa')));
        } else {
            $jml_data = count($id_nilai);
            for ($i = 0; $i < $jml_data; $i++) {
                // $builder = $this->db->table('nilai_siswa');
                // $builder->where('id')
                $builder = $this->db->table('nilai_siswa');
                $builder->where('id_nilai', $id_nilai[$i]);
                $builder->set('nilai', $nilai);
                $builder->update();
            }
        }
        session()->setFlashdata('pesan_hijau', 'data nilai berhasil di update');
        return redirect()->to(site_url('pembina/detail_nilai/' . $this->request->getVar('id_siswa')));
    }

    public function nilai_rata()
    {
        $thn_akademik = $this->request->getVar('id_thnAkd');

        $builder = $this->db->table('data_akademik');
        $builder->join('data_siswa', 'data_siswa.id_siswa = data_akademik.id_siswa');
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $builder->where('tahun', $this->request->getVar('tahun'));
        $builder->where('id_thnAkd', $thn_akademik);
        $get_siswa = $builder->get()->getResultArray();


        $builder = $this->db->table('nilai_siswa');
        $builder->select('nilai');
        $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal');
        $builder->where('J_bulan', $this->request->getVar('tahun'));
        $nilai_rata = $builder->where('thn_akademik', $thn_akademik);


        $data = [
            'tittle' => 'Nilai Rata-rata siswa',
            'siswa' => $get_siswa,
            'nilai_rata' => $nilai_rata
        ];

        return view('pembina/nilai_rata', $data);
    }

    public function jadwal_kegiatan()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $builder->where('J_bulan', date('Y-m'));
        $query = $builder->get()->getResultArray();

        $cariJadwal = $this->request->getVar('keyword');

        if ($cariJadwal) {
            $builder = $this->db->table('jadwal_kegiatan');
            $builder->where('id_kegiatan', session()->get('kegiatan'));
            $builder->like('J_bulan', $cariJadwal);
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $cariJadwal);
        } else {
            $builder = $this->db->table('jadwal_kegiatan');
            $builder->where('id_kegiatan', session()->get('kegiatan'));
            $builder->where('J_bulan', date('Y-m'));
            $query = $builder->get()->getResultArray();
            session()->setFlashdata('lastSearch', $cariJadwal);
        }

        $data = [
            'tittle' => 'Jadwal Kegiatan',
            'jadwal' => $query
        ];

        return view('pembina/jadwal_kegiatan', $data);
    }

    public function create_jadwal()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        $data = [
            'tittle' => 'Tambah Jadwal',
            'validation' => \Config\Services::validation()
        ];

        return view('pembina/create_jadwal', $data);
    }

    public function save_jadwal()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        if (!$this->validate([
            'J_tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jadwal hari harus di isi',
                ]
            ],
            'J_bulan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jadwal hari harus di isi',
                ]
            ],
            'J_materi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'materi harus di isi',
                ]
            ],
            'J_waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'waktu harus di isi',
                ]
            ],
            'J_keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'keterangan harus di isi',
                ]
            ],

        ])) {
            return redirect()->to(site_url('pembina/create_jadwal'))->withInput();
        }

        $J_tanggal = $this->request->getVar('J_bulan') . '-' . $this->request->getVar('J_tanggal');

        $data = [
            'J_bulan' => $this->request->getVar('J_bulan'),
            'J_tanggal' => $J_tanggal,
            'J_materi' => $this->request->getVar('J_materi'),
            'J_keterangan' => $this->request->getVar('J_keterangan'),
            'J_waktu' => $this->request->getVar('J_waktu'),
            'id_kegiatan' => session()->get('kegiatan'),
            'created_at' => Time::now()
        ];

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->insert($data);
        $id_jadwal = $this->db->insertID();

        $builder = $this->db->table('data_siswa');
        $builder->join('users', 'users.id = data_siswa.siswa_userid');
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $get_siswa = $builder->get();

        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $id_thnAkd = $builder->get()->getRowArray();

        foreach ($get_siswa->getResult() as $row) {
            if ($row->status == 'validasi nilai') {
                continue;
            }
            $nilai_siswa = [
                'id_siswa' => $row->id_siswa,
                'nilai' => ' ',
                'id_jadwal' => $id_jadwal,
                'thn_akademik' => $id_thnAkd['id_thnAkd'],
                'created_at' => Time::now()
            ];

            $builder = $this->db->table('nilai_siswa');
            $builder->insert($nilai_siswa);
        }

        session()->setFlashdata('pesan_hijau', 'Jadwal kegiatan berhasil di tambahkan');
        return redirect()->to(site_url('pembina/jadwal_kegiatan'));
    }

    public function edit_jadwal($id_jadwal)
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_jadwal', $id_jadwal);
        $query = $builder->get()->getRow();

        $data = [
            'tittle' => 'Form Edit Jadwal',
            'validation' => \Config\Services::validation(),
            'jadwal' => $query
        ];

        return view('pembina/edit_jadwal', $data);
    }

    public function update_jadwal()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        $data = [
            'J_hari' => $this->request->getVar('J_hari'),
            'J_materi' => $this->request->getVar('J_materi'),
            'J_keterangan' => $this->request->getVar('J_keterangan'),
            'J_waktu' => $this->request->getVar('J_waktu'),
            'J_kegiatan' => $this->request->getVar('J_kegiatan'),
            'created_at' => Time::now()
        ];

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_jadwal', $this->request->getVar('id_jadwal'));
        $builder->update($data);

        session()->setFlashdata('pesan_hijau', 'data jadwal berhasil di update');
        return redirect()->to(site_url('pembina/jadwal_kegiatan'));
    }

    public function delete_jadwal($id_jadwal)
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_jadwal', $id_jadwal);
        $builder->delete();

        session()->setFlashdata('pesanSwal', 'Data jadwal berhasil dihapus');
        return redirect()->to(site_url('pembina/jadwal_kegiatan'));
    }

    //save excel datasiswa berdasarkan kegiatan
    public function excel()
    {
        if (session()->get('level') != 2) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 'aktif');
        $get_thnAkd = $builder->get()->getRowArray();

        $builder = $this->db->table('data_akademik');
        $builder->select('*');
        $builder->join('data_siswa', 'data_siswa.id_siswa = data_akademik.id_siswa');
        $builder->join('data_kelasmaster', 'data_kelasmaster.id_kelas = data_akademik.id_kelas');
        $builder->join('users', 'users.id = data_siswa.siswa_userid');
        $builder->where('id_thnAkd', $get_thnAkd['id_thnAkd']);
        $builder->where('pilihan_kegiatan', session()->get('kegiatan'));
        $builder->where('tahun', $this->request->getVar('J_bulan'));
        $cek_siswa = $builder->get();

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $builder->where('J_bulan', $this->request->getVar('J_bulan'));
        $get_jadwal = $builder->get()->getResultArray();

        $builder = $this->db->table('jadwal_kegiatan');
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $builder->where('J_bulan', $this->request->getVar('J_bulan'));
        $get_count = $builder->countAllResults();


        if ($get_jadwal == null) {
            session()->setFlashdata('pesan_merah', 'Gagal mencetak nilai.. tidak ada nilai di data');
            return redirect()->to(site_url('pembina/siswa'));
        }

        // $builder = $this->db->table('jadwal_kegiatan');
        // $builder->where('J_bulan', $this->request->getVar('J_bulan'));
        // $get_bulan = $builder->get()->getRowArray();

        $builder = $this->db->table('nilai_siswa');
        $builder->join('jadwal_kegiatan', 'jadwal_kegiatan.id_jadwal = nilai_siswa.id_jadwal', 'left');
        $builder->where('thn_akademik', $get_thnAkd['id_thnAkd']);
        $builder->where('J_bulan', $this->request->getVar('J_bulan'));
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $get_nilai = $builder->get();


        $builder = $this->db->table('data_pembina');
        $builder->where('pembina_userid', session()->get('id'));
        $get_pembina = $builder->get()->getRowArray();

        $builder = $this->db->table('data_kegiatan');
        $builder->where('id_kegiatan', session()->get('kegiatan'));
        $get_kegiatan = $builder->get()->getRowArray();

        $spreadsheet = new Spreadsheet();

        //Set Default Teks
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Cilibri')
            ->setSize(12);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "DAFTAR HADIR EKSTRAKURIKULER");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A1:I1");
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A2', "SMA NEGERI 1 PADEMAWU");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A2:I2");
        $spreadsheet->getActiveSheet()
            ->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A3', "TAHUN PELAJARAN " . $get_thnAkd['tahun']);
        $spreadsheet->getActiveSheet()
            ->mergeCells("A3:I3");
        $spreadsheet->getActiveSheet()
            ->getStyle('A3')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A5', "NAMA EKSTRA")
            ->setCellValue('C5', ": " . $get_kegiatan['nama_kegiatan'])
            ->setCellValue('A6', "PEMBINA")
            ->setCellValue('C6', ": " . $get_pembina['nama_pembina']);

        // style lebar kolom
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
            ->setWidth(8);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(9);

        $w = 'F';
        for ($x = 0; $x < $get_count; $x++) {
            if ($w != 'Z') {
                $spreadsheet->getActiveSheet()
                    ->getColumnDimension($w++)
                    ->setWidth(4);
            }
        }


        //set judul tabel
        $spreadsheet->getActiveSheet()
            ->setCellValue('A8', "NO");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A8:A9");
        $spreadsheet->getActiveSheet()
            ->getStyle('A8')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('B8', "NIS");
        $spreadsheet->getActiveSheet()
            ->mergeCells("B8:B9");
        $spreadsheet->getActiveSheet()
            ->getStyle('B8')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('C8', "NAMA");
        $spreadsheet->getActiveSheet()
            ->mergeCells("C8:C9");
        $spreadsheet->getActiveSheet()
            ->getStyle('C8')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('D8', "L/P");
        $spreadsheet->getActiveSheet()
            ->mergeCells("D8:D9");
        $spreadsheet->getActiveSheet()
            ->getStyle('D8')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('E8', "KELAS");
        $spreadsheet->getActiveSheet()
            ->mergeCells("E8:E9");
        $spreadsheet->getActiveSheet()
            ->getStyle('E8')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $column = 10;
        $nomer = 1;
        foreach ($cek_siswa->getResult() as $cek) {
            if ($cek->status == 'validasi nilai') {
                continue;
            }
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $column, $nomer++)
                ->setCellValue('B' . $column, $cek->nis_siswa)
                ->setCellValue('C' . $column, $cek->nama_siswa)
                ->setCellValue('D' . $column, $cek->jk)
                ->setCellValue('E' . $column, $cek->nama_kelas);

            $n = 'F';
            foreach ($get_nilai->getResult() as $row) {
                if ($cek->id_siswa != $row->id_siswa) {
                    continue;
                }
                if ($row->nilai != null) {
                    // for ($x = 0; $x < $get_count; $x++) {
                    //     if ($n != 'Z') {
                    //         $n++;
                    //     }
                    // }
                    $spreadsheet->getActiveSheet()
                        ->setCellValue($n++ . $column, $row->nilai);
                }
                // echo $row->J_keterangan . ' Nilai = ' . $row->nilai;
            }


            $hJ = 'F';
            foreach ($get_jadwal as $j) {
                // $spreadsheet->getActiveSheet()
                //     ->getStyle($n++ . 8)
                //     ->getAlignment()
                //     ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $spreadsheet->getActiveSheet()
                    ->setCellValue($hJ++ . 9, date('d', strtotime($j['J_tanggal'])));
                // $spreadsheet->getActiveSheet()
                //     ->getStyle($n++ . 9 . ':' . $n++ . 9)
                //     ->getAlignment()
                //     ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            $a = 'E';
            for ($x = 0; $x < $get_count; $x++) {
                if ($a != 'Z') {
                    $a++;
                }
            }

            $spreadsheet->getActiveSheet()
                ->setCellValue('F8', $this->request->getVar('bulan'))
                ->mergeCells('F8:' . $a . 8)
                ->getStyle('F8:' . $a . 9)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $spreadsheet->getActiveSheet()
                ->getStyle('F8:' . $a . 9)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            //Atur Border Atas
            $spreadsheet->getActiveSheet()
                ->getStyle('A8:E9')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $spreadsheet->getActiveSheet()
                ->getStyle('A' . $column . ':' . $a . $column)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()
                ->getStyle('A' . $column . ':' . 'B' . $column)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()
                ->getStyle('D' . $column . ':' . $a . $column)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $last_numb = $column;
            $column++;
        }

        //footer
        $get_lastNumb = $last_numb + 1;
        $get_column1 = $get_lastNumb + 1;
        $get_column2 = $get_column1 + 1;
        $get_column3 = $get_column2 + 6;
        $get_column4 = $get_column3 + 1;

        $spreadsheet->getActiveSheet()
            ->setCellValue('E' . $get_column1, "Pamekasan " . $this->request->getVar('tanggal') . ' ' . $this->request->getVar('bulan') . ' ' . $this->request->getVar('tahun'))
            ->setCellValue('A' . $get_column2, "Waka Kesiswaan")
            ->setCellValue('E' . $get_column2, "Pembina " . $this->request->getVar('kegiatan'))
            ->setCellValue('A' . $get_column3, "Agus Suhartono, S.Pd")
            ->setCellValue('E' . $get_column3, $get_pembina['nama_pembina'])
            ->setCellValue('A' . $get_column4, "NIP : 19691018 200604 1 007")
            ->setCellValue('E' . $get_column4, "NIP : " . $get_pembina['nip_pembina']);


        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-Data-User';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
