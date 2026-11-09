<?php
require_once __DIR__ . '/../models/GalleryModel.php';

class GalleryController {
    private $model;

    public function __construct() {
        $this->model = new GalleryModel();
    }

    public function index() {
        $gallery = $this->model->getAll();
        require_once __DIR__ . '/../views/gallery.php';
    }

    public function store() {
        header('Content-Type: application/json');
        
        $tipe = $_POST['tipe'] ?? 'image';
        $srcPath = '';

        if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->uploadMediaFile($_FILES['media_file']);
            if ($uploadedPath) {
                $srcPath = $uploadedPath;
            }
        } elseif (!empty($_POST['src_url'])) {
            $srcPath = $_POST['src_url'];
        }

        if (empty($srcPath)) {
            echo json_encode(['success' => false, 'message' => 'Pilih berkas dari folder atau isi URL media terlebih dahulu!']);
            return;
        }

        $success = $this->model->create($tipe, $srcPath);
        echo json_encode(['success' => (bool)$success]);
    }

    public function update($id) {
        header('Content-Type: application/json');

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID media tidak valid']);
            return;
        }

        $tipe = $_POST['tipe'] ?? 'image';
        $srcPath = $_POST['src_url'] ?? '';

        if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->uploadMediaFile($_FILES['media_file']);
            if ($uploadedPath) {
                $srcPath = $uploadedPath;
            }
        }

        if (empty($srcPath)) {
            echo json_encode(['success' => false, 'message' => 'Media tidak boleh kosong']);
            return;
        }

        $success = $this->model->update($id, $tipe, $srcPath);
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

    private function uploadMediaFile($file) {
        $targetDir = __DIR__ . '/../images/';
        
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file['name']));
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'ogg'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                return 'images/' . $fileName;
            }
        }
        return false;
    }
}
?>