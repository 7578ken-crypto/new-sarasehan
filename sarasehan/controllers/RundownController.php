<?php
require_once __DIR__ . '/../models/RundownModel.php';

class RundownController {
    private $model;

    public function __construct() {
        $this->model = new RundownModel();
    }

    public function store() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data || empty($data['judul'])) {
            echo json_encode(['success' => false, 'message' => 'Judul kegiatan wajib diisi']);
            return;
        }

        $success = $this->model->create(
            $data['day_type'] ?? 'day-1',
            $data['judul'],
            $data['items'] ?? []
        );
        echo json_encode(['success' => (bool)$success]);
    }

    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$id || !$data) {
            echo json_encode(['success' => false, 'message' => 'ID atau Data update tidak valid']);
            return;
        }

        $success = $this->model->update(
            $id,
            $data['day_type'] ?? 'day-1',
            $data['judul'],
            $data['items'] ?? []
        );
        echo json_encode(['success' => (bool)$success]);
    }

    public function delete($id) {
        header('Content-Type: application/json');
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
            return;
        }
        $success = $this->model->delete($id);
        echo json_encode(['success' => (bool)$success]);
    }
}
?>