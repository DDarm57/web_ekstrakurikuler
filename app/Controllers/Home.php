<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db   = \Config\Database::connect();
    }
    public function index()
    {
        $builder = $this->db->table('home');
        $query = $builder->get()->getRow();

        $data = [
            'tittle' => 'Home',
            'deskripsi' => $query
        ];

        return view('index', $data);
    }

    public function edit_home()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $builder = $this->db->table('home');
        $query = $builder->get()->getRow();

        $data = [
            'tittle' => 'Edit halaman home',
            'home' => $query
        ];

        return view('admin/edit_home', $data);
    }

    public function update_home()
    {
        if (session()->get('level') != 1) {
            return redirect()->to(site_url('home/index'));
        }

        $data = [
            'deskripsi_home' => $this->request->getVar('deskripsi_home')
        ];

        $builder = $this->db->table('home');
        $builder->where('id_setHome', $this->request->getVar('id_setHome'));
        $builder->update($data);

        session()->setFlashdata('pesanSwal', 'Halaman home berhasil di update');
        return redirect()->to(site_url('home/index'));
    }
}
