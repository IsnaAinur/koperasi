<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function anggota()
    {
        $data = [
          'anggota' => $this->anggotaModel->findAll()
        ];
        return view('anggota', $data);
    }

    public function save()
    {
        $this->anggotaModel->insert([
            'nik_anggota'   => $this->request->getPost('nik'),
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'tgl_bergabung' => $this->request->getPost('tgl_bergabung'),
        ]);

        return redirect()->to('/anggota')->with('success', 'Data berhasil ditambah');
    }

    public function update()
    {
        $nik_lama = $this->request->getPost('id_original');
        
        $data = [
            'nik_anggota'   => $this->request->getPost('nik_baru'),
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'tgl_bergabung' => $this->request->getPost('tgl_bergabung'),
        ];

        $this->anggotaModel->update($nik_lama, $data);
        return redirect()->to('/anggota')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota')->with('success', 'Data berhasil dihapus');
    }

    public function search()
{
    $keyword = $this->request->getGet('keyword');
    $anggota = $keyword ? $this->anggotaModel->search($keyword) : $this->anggotaModel->findAll();

    if (empty($anggota)) {
        return '<tr><td colspan="7" class="text-center p-4">Data tidak ditemukan.</td></tr>';
    }

    $output = '';
    $no = 1;

    foreach ($anggota as $row) {
        $output .= <<<HTML
        <tr>
            <td class="text-center">{$no}</td>
            <td>{$row['nik_anggota']}</td> 
            <td>{$row['nama']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['no_hp']}</td>
            <td>{$row['tgl_bergabung']}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#modalEditAnggota" 
                    data-id="{$row['nik_anggota']}" 
                    data-nama="{$row['nama']}" 
                    data-alamat="{$row['alamat']}" 
                    data-no_hp="{$row['no_hp']}" 
                    data-tgl="{$row['tgl_bergabung']}">
                    Edit
                </button>
                <a href="/anggota/delete/{$row['nik_anggota']}" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('Yakin?')">
                   Hapus
                </a>
            </td>
        </tr>
HTML;
        $no++;
    }

    return $output;
}
}