<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;

class Jabatan extends BaseController
{
    public function index()
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'title' => '',
            'jabatan' => $jabatanModel->findAll()
        ];

        return view('admin/jabatan/jabatan', $data);
    }

    public function create()
    {
        $data = [
            'title' => '',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/jabatan/create', $data);
    }

    public function store()
    {
        $jabatanModel = new JabatanModel();

        $rules = [
            'jabatan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama jabatan wajib diisi'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $jabatanModel->insert([
            'jabatan' => $this->request->getPost('jabatan')
        ]);

        session()->setFlashdata('berhasil', 'Data jabatan berhasil tersimpan');

        return redirect()->to(base_url('admin/jabatan'));
    }

    public function edit($id)
    {   
        $jabatanModel = new JabatanModel();
        $data = [
            'title' => '',
            'jabatan' => $jabatanModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jabatan/edit', $data);
    


        if (!$this->validate($rules)){
            $data = [
                'title' => '',
                'jabatan' => $jabatanModel->findAll()
            ];
            echo view ('admin/jabatan/create', $data); 
        } else {
            $jabatanModel = new JabatanModel();
            $jabatanModel->insert([
                'jabatan' => $this->request->getPost('jabatan')
            ]);
            
            session()->setFlashdata('berhasil', 'Data jabatan berhasil tersimpan');

                return redirect()->to(base_url('admin/jabatan'));
        }
    }


        public function update($id)
    {
        $jabatanModel = new JabatanModel();
        $rules = [
            'jabatan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama jabatan wajib diisi'
                ],
            ],
        ];

        if (!$this->validate($rules)){
            $data = [
                'title' => '',
                'jabatan' => $jabatanModel->find($id),
                'validation' => \Config\Services::validation()
            ];
            echo view ('admin/jabatan/edit', $data); 
        } else {
            $jabatanModel = new JabatanModel();
            $jabatanModel->update($id, [
                'jabatan' => $this->request->getPost('jabatan')
            ]);
            
            session()->setFlashdata('berhasil', 'Data jabatan berhasil diupdate');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }


    function delete($id)
    {
        $jabatanModel = new JabatanModel();

        $jabatan = $jabatanModel->find($id);
        if ($jabatan) {
            $jabatanModel->delete($id);
            session()->setFlashdata('berhasil', 'Data jabatan berhasil dihapus');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }
}               

