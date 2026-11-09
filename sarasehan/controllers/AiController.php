<?php
require_once __DIR__ . '/../models/RundownModel.php';
require_once __DIR__ . '/../models/AnggotaModel.php';
require_once __DIR__ . '/../models/GalleryModel.php';

class AiController {
    private $rundownModel;
    private $anggotaModel;
    private $galleryModel;

    public function __construct() {
        $this->rundownModel = new RundownModel();
        $this->anggotaModel = new AnggotaModel();
        $this->galleryModel = new GalleryModel();
    }

    public function ask() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $userPrompt = trim($input['prompt'] ?? '');
        $isAdmin = ($input['is_admin'] ?? false) === true;

        // Validasi Sisi Backend: Hanya Admin yang Boleh Mengakses Endpoint AI
        if (!$isAdmin) {
            echo json_encode([
                'reply' => '🔒 Access Denied: Fitur Jarvis AI Assistant khusus digunakan di dalam Dashboard Admin.',
                'action' => null
            ]);
            return;
        }

        if (empty($userPrompt)) {
            echo json_encode(['reply' => 'Siap Bos Admin! Ada tugas atau perintah baru untuk saya? 🫡', 'action' => null]);
            return;
        }

        $response = $this->processAICommand($userPrompt);
        echo json_encode($response);
    }

    private function processAICommand($prompt) {
        $p = strtolower($prompt);

        // 1. PERINTAH DOKUMEN & CRUD
        if (str_contains($p, 'tambah rundown') || str_contains($p, 'tambah agenda') || str_contains($p, 'buat rundown')) {
            $parts = explode(':', $prompt, 2);
            $judul = count($parts) > 1 ? trim($parts[0]) : 'AGENDA BARU AI';
            $item = count($parts) > 1 ? trim($parts[1]) : $prompt;

            $judul = str_ireplace(['tambah rundown', 'tambah agenda', 'buat rundown'], '', $judul);
            $judul = trim($judul) ?: 'AGENDA BARU (Dibuat AI)';

            $success = $this->rundownModel->create('day-1', $judul, [$item]);
            if ($success) {
                return [
                    'reply' => "✅ **Siap, Eksekusi Berhasil!** Agenda baru telah ditambahkan:\n📌 *{$judul}*\n📝 {$item}",
                    'action' => 'reload'
                ];
            }
            return ['reply' => '❌ Gagal menambahkan agenda ke database.', 'action' => null];
        }

        if (str_contains($p, 'tambah anggota') || str_contains($p, 'tambah siswa') || str_contains($p, 'tambah pengurus')) {
            preg_match('/tambah (?:anggota|siswa|pengurus)\s+([^-]+)(?:-\s*(.+))?/i', $prompt, $matches);
            $nama = isset($matches[1]) ? trim($matches[1]) : '';
            $jabatan = isset($matches[2]) ? trim($matches[2]) : 'Siswa';
            $kategori = (str_contains($p, 'pengurus') || $jabatan !== 'Siswa') ? 'pengurus' : 'siswa';

            if (!empty($nama)) {
                $success = $this->anggotaModel->create($nama, $kategori, $jabatan, 'https://via.placeholder.com/150');
                if ($success) {
                    return [
                        'reply' => "✅ **Siap Boss!** Anggota **{$nama}** ({$jabatan}) berhasil dimasukkan ke sistem.",
                        'action' => 'reload'
                    ];
                }
            }
            return ['reply' => '💡 **Format Perintah:** `tambah anggota [Nama] - [Jabatan]`', 'action' => null];
        }

        if (str_contains($p, 'logout admin') || str_contains($p, 'keluar admin')) {
            return [
                'reply' => '🫡 Siap, saya mengamankan sistem dan keluar dari mode Admin!',
                'action' => 'logout_admin'
            ];
        }

        // 2. INTERAKSI DAN INFORMASI DOKUMEN
        if (str_contains($p, 'siapa kamu') || str_contains($p, 'siapa anda')) {
            return [
                'reply' => "🤖 **Halo Bos! Saya Jarvis AI**, asisten eksekutif khusus Dashboard Admin.\nSaya siap mengeksekusi perintah manajemen rundown, anggota kelas, maupun galeri.",
                'action' => null
            ];
        }

        if (str_contains($p, 'halo') || str_contains($p, 'hai') || str_contains($p, 'pagi') || str_contains($p, 'malam')) {
            return [
                'reply' => "Halo Bos Admin! 🫡 Ada tugas baru yang perlu saya selesaikan di web hari ini?",
                'action' => null
            ];
        }

        $rundowns = $this->rundownModel->getAll();
        if (str_contains($p, 'jadwal') || str_contains($p, 'rundown') || str_contains($p, 'kegiatan')) {
            if (!empty($rundowns)) {
                $info = "📋 **Rekap Rundown Kegiatan Terkini:**\n";
                foreach ($rundowns as $r) {
                    $info .= "\n🔹 **" . $r['judul'] . "**\n";
                    if (is_array($r['items'])) {
                        foreach ($r['items'] as $item) {
                            $info .= "   • " . $item . "\n";
                        }
                    }
                }
                return ['reply' => trim($info), 'action' => null];
            }
        }

        return [
            'reply' => "Siap Bos! Saya siap menerima perintah. Coba ketik:\n• `tambah anggota [Nama] - [Jabatan]`\n• `tambah rundown HARI 1: 10.00 - 12.00: Sesi Games`",
            'action' => null
        ];
    }
}
?>