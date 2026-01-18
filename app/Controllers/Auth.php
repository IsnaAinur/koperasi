<?php

namespace App\Controllers;

use App\Models\AuthModel; // Tambahkan ini

class Auth extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        // Inisialisasi Model
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        
        return view('login'); 
    }

    public function login()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Menggunakan Model untuk mencari user
        $admin = $this->authModel->cekLogin($username);

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $ses_data = [
                    'id_petugas' => $admin['id_petugas'],
                    'user_name'  => $admin['username'],
                    'logged_in'  => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to(base_url('/'));
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username Tidak Ditemukan');
            return redirect()->to('/login');
        }
    }

    public function profil()
    {
        $id_petugas = session()->get('id_petugas');

        // Ambil data admin terbaru menggunakan Model (find)
        $data['admin'] = $this->authModel->find($id_petugas);

        return view('layout/header') . view('profil', $data) . view('layout/footer');
    }

    public function updateProfil()
    {
        $id_petugas = session()->get('id_petugas');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $updateData = [
            'id_petugas' => $id_petugas,
            'username'   => $username
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Simpan perubahan menggunakan fungsi save() bawaan Model
        $this->authModel->save($updateData);

        session()->set('user_name', $username);

        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}