<?php
require_once __DIR__ . '/../models/AnggotaModel.php';

class AnggotaController {
    private $model;

    public function __construct() {
        $this->model = new AnggotaModel();
    }

    public function index() {
        $members = $this->model->getAll();
        require_once __DIR__ . '/../views/anggota.php';
    }

    public function store() {
        header('Content-Type: application/json');
        
        $nama = $_POST['nama'] ?? '';
        $kategori = $_POST['kategori'] ?? '';
        $jabatan = $_POST['jabatan'] ?? 'Siswa';
        $fotoPath = 'https://via.placeholder.com/150';

        if (empty($nama) || empty($kategori)) {
            echo json_encode(['success' => false, 'message' => 'Data nama dan kategori wajib diisi']);
            return;
        }

        // Simpan File Upload ke Folder images/
        if (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->uploadImageFile($_FILES['foto_file']);
            if ($uploadedPath) {
                $fotoPath = $uploadedPath;
            }
        } elseif (!empty($_POST['foto_url'])) {
            $fotoPath = $_POST['foto_url'];
        }

        $success = $this->model->create($nama, $kategori, $jabatan, $fotoPath);
        echo json_encode(['success' => (bool)$success]);
    }

    public function update($id) {
        header('Content-Type: application/json');
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
            return;
        }

        $currentMember = $this->model->getById($id);
        $fotoPath = $currentMember ? $currentMember['foto'] : 'https://via.placeholder.com/150';

        $nama = $_POST['nama'] ?? '';
        $kategori = $_POST['kategori'] ?? '';
        $jabatan = $_POST['jabatan'] ?? 'Siswa';

        if (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->uploadImageFile($_FILES['foto_file']);
            if ($uploadedPath) {
                $fotoPath = $uploadedPath;
            }
        } elseif (!empty($_POST['foto_url'])) {
            $fotoPath = $_POST['foto_url'];
        }

        $success = $this->model->update($id, $nama, $kategori, $jabatan, $fotoPath);
        echo json_encode(['success' => (bool)$success]);
    }

    public function delete($id) {
        header('Content-Type: application/json');
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
            return;
        }
        $success = $this->model->delete($id);
        echo json_encode(['success' => (bool)$success]);
    }

    // Fungsi Pembantu Upload ke Folder images/
    private function uploadImageFile($file) {
        $targetDir = __DIR__ . '/../images/';
        
        // Buat folder images otomatis jika belum ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file['name']));
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                return 'images/' . $fileName; // Path publik yang disimpan ke Database
            }
        }
        return false;
    }
}
?>