<?php

namespace App\Controllers;

class Home extends BaseController
{

    // Menampilkan halaman views/layouts/dashboard
    public function index()
    {
        $sharedModel = new \App\Models\SharedModel();
        $tugasModel = new \App\Models\TugasModel();

        $userId = session()->get('id');

        // Ambil semua tugas yang dibagikan ke user ini dan belum selesai
        $sharedTugas = $sharedModel
            ->join('tugas', 'shared.idtugas = tugas.id')
            ->where('shared.sharedto', $userId)
            ->whereNotIn('tugas.status', ['Selesai', 'Batal'])
            ->select('tugas.*, shared.accepted')
            ->findAll();

        $tugasSegera = [];
        $tugasTerlambat = [];
        $tugasBaru = [];

        $now = new \DateTime();

        foreach ($sharedTugas as $row) {
            $deadline = new \DateTime($row['tanggal'] . ' ' . $row['waktu']);

            // Cek jika sudah melewati deadline, tetap masukkan meskipun lewat dari 1 hari
            if (
                $deadline < $now &&
                $row['accepted'] !== 'done' &&
                $row['accepted'] !== 'canceled'
            ) {
                $tugasTerlambat[] = $row;
            }

            // Cek jika deadline masih dalam waktu 24 jam ke depan
            $interval = $now->diff($deadline);
            if (
                $deadline > $now &&
                $interval->days === 0 &&
                $interval->h < 24 &&
                $row['accepted'] !== 'done' &&
                $row['accepted'] !== 'canceled'
            ) {
                $tugasSegera[] = $row;
            }

            // Cek jika ada tugas baru yang belum diterima
            if (
                $row['accepted'] == 'shared'
            ) {
                $tugasBaru[] = $row;
            }
        }

        return view('layouts/dashboard', [
            'tugasSegera' => $tugasSegera,
            'tugasTerlambat' => $tugasTerlambat,
            'tugasBaru' => $tugasBaru,
            'title' => 'Dashboard'
        ]);
    }
}
// if this line is still there, it means I just copy paste my friend's UKK application