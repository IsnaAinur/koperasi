<?php

namespace App\Controllers;

// Gunakan BaseController agar fungsi request, session, dll tersedia
class Auth extends BaseController
{
    /**
     * Menampilkan Halaman Login
     * Ini yang menyebabkan error 404 jika tidak ada
     */
    public function index()
    {
        // Jika sudah login, jangan kasih akses halaman login lagi, lempar ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        
        return view('login'); // Pastikan file ada di app/Views/login.php
    }

    /**
     * Memproses Data Login
     */
    public function login()
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Query ke tabel admin
        $admin = $db->table('admin')->where('username', $username)->get()->getRowArray();

        if ($admin) {
            // Cek password hash
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
    $db = \Config\Database::connect();
    $id_petugas = session()->get('id_petugas');

    // Ambil data admin terbaru dari database
    $data['admin'] = $db->table('admin')->where('id_petugas', $id_petugas)->get()->getRowArray();

    return view('layout/header') . view('profil', $data) . view('layout/footer');
}

    public function updateProfil()
    {
        $db = \Config\Database::connect();
        $id_petugas = session()->get('id_petugas');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $updateData = ['username' => $username];

        // Jika password diisi, maka update passwordnya (hash)
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $db->table('admin')->where('id_petugas', $id_petugas)->update($updateData);

        // Update session nama agar di header langsung berubah
        session()->set('user_name', $username);

        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Proses Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}