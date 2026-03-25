<?php

namespace App\Controllers;
use App\Models\LoginModel;
use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke home sesuai role
        if (session()->get('logged_in')) {
            return session()->get('role_id') == 'Admin' ? redirect()->to('admin/home') : redirect()->to('siswa/home');
        }

        $data = ['validation' => \Config\Services::validation()];
        return view('login', $data);
    }

    public function login_action()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if(!$this->validate($rules)){
             return view('login', ['validation' => $this->validator]);
        }

        $loginModel = new LoginModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $user = $loginModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, trim($user['password']))) {
                
                // Set Session Awal
                $session_data = [
                    'username'  => $user['username'],
                    'logged_in' => TRUE,
                    'role_id'   => $user['role'],
                    'id_siswa'  => $user['id_siswa'], // ID ini yang dipakai BaseController untuk cari foto
                ];
                $this->session->set($session_data);

                // Redirect berdasarkan Role
                if ($user['role'] == "Admin") {
                    return redirect()->to('admin/home');
                } else if ($user['role'] == "Siswa") {
                    return redirect()->to('siswa/home');
                } else {
                    $this->session->setFlashdata('pesan', 'Role tidak dikenali');
                    return redirect()->to('/');
                }

            } else {
                session()->setFlashdata('pesan', 'Password salah!');
                return redirect()->to('/');
            }
        } else {
            session()->setFlashdata('pesan', 'Username tidak ditemukan!');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}