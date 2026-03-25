<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;

class LokasiPresensi extends BaseController
{
    public function detail($id)
    {
        $lokasisPresensiModel = new LokasiPresensiModel();
        $data = [
            'title'           => '',
            'lokasi_presensi' => $lokasisPresensiModel->find($id),
        ];

        return view('admin/lokasi_presensi/detail', $data);
    }

    public function index()
    {
        $lokasiPresensiModel = new LokasiPresensiModel();

        $data = [
            'title' => '',
            'lokasi_presensi' => $lokasiPresensiModel->findAll()
        ];

        return view('admin/lokasi_presensi/lokasi_presensi', $data);
    }

    public function create()
    {
        $data = [
            'title' => '',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/lokasi_presensi/create', $data);
    }

    public function store()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();

        $rules = [
            'nama_lokasi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama lokasi wajib diisi'
                ],
            ],
            'alamat_lokasi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Alamat lokasi wajib diisi'
                ],
            ],
            'tipe_lokasi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tipe lokasi wajib diisi'
                ],
            ],
            'latitude' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Latitude wajib diisi'
                ],
            ],
            'longitude' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'longitude wajib diisi'
                ],
            ],
            'radius' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'radius wajib diisi'
                ],
            ],
            'zona_waktu' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Zona waktu wajib diisi'
                ],
            ],
            'jam_masuk' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jam masuk wajib diisi'
                ],
            ],
            'jam_pulang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jam pulang wajib diisi'
                ],
            ],

        ];

        if (!$this->validate($rules)) {
            return view('admin/lokasi_presensi/create', [
                'title' => '',
                'validation' => $this->validator
            ]);
        }

        $LokasiPresensiModel->insert([
            'nama_lokasi'   => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi'   => $this->request->getPost('tipe_lokasi'),
            'latitude'      => $this->request->getPost('latitude'),
            'longitude'     => $this->request->getPost('longitude'),
            'radius'        => $this->request->getPost('radius'),
            'zona_waktu'    => $this->request->getPost('zona_waktu'),
            'jam_masuk'     => $this->request->getPost('jam_masuk'),
            'jam_pulang'    => $this->request->getPost('jam_pulang'),
        ]);

        session()->setFlashdata('berhasil', 'Data lokasi presensi berhasil tersimpan');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

        public function edit($id)
        {
            $LokasiPresensiModel = new LokasiPresensiModel();

            $data = [
                'title' => '',
                'lokasi_presensi' => $LokasiPresensiModel->find($id),
                'validation' => \Config\Services::validation()
            ];

            return view('admin/lokasi_presensi/edit', $data);
        }


    public function update($id)
    {
    $LokasiPresensiModel = new LokasiPresensiModel();

        $rules = [
        'nama_lokasi' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama lokasi wajib diisi'
            ],
        ],
        'alamat_lokasi' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Alamat lokasi wajib diisi'
            ],
        ],
        'tipe_lokasi' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Tipe lokasi wajib diisi'
            ],
        ],
        'latitude' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Latitude wajib diisi'
            ],
        ],
        'longitude' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Longitude wajib diisi'
            ],
        ],
        'radius' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Radius wajib diisi'
            ],
        ],
        'zona_waktu' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Zona waktu wajib diisi'
            ],
        ],
        'jam_masuk' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Jam masuk wajib diisi'
            ],
        ],
        'jam_pulang' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Jam pulang wajib diisi'
            ],
        ],
    ];


    if (!$this->validate($rules)) {
        $data = [
            'title' => '',
            'lokasi_presensi' => $LokasiPresensiModel->find($id),
            'validation' => $this->validator
        ];

        return view('admin/lokasi_presensi/edit', $data);
    }

    $LokasiPresensiModel->update($id, [
        'nama_lokasi'   => $this->request->getPost('nama_lokasi'),
        'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
        'tipe_lokasi'   => $this->request->getPost('tipe_lokasi'),
        'latitude'      => $this->request->getPost('latitude'),
        'longitude'     => $this->request->getPost('longitude'),
        'radius'        => $this->request->getPost('radius'),
        'zona_waktu'    => $this->request->getPost('zona_waktu'),
        'jam_masuk'     => $this->request->getPost('jam_masuk'),
        'jam_pulang'    => $this->request->getPost('jam_pulang'),
    ]);

    session()->setFlashdata('berhasil', 'Data lokasi presensi berhasil diupdate');

    return redirect()->to(base_url('admin/lokasi_presensi'));
    }



    function delete($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();

        $jabatan = $LokasiPresensiModel->find($id);
        if ($jabatan) {
            $LokasiPresensiModel->delete($id);
            session()->setFlashdata('berhasil', 'Data lokasi presensi berhasil dihapus');

            return redirect()->to(base_url('admin/lokasi_presensi'));
        }
    }
}
