<?php
require_once __DIR__ . '/../config/database.php';

class GalleryModel {
    private $conn;
    private $table_name = "gallery";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($tipe, $src) {
        $query = "INSERT INTO " . $this->table_name . " (tipe, src) VALUES (:tipe, :src)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':tipe' => $tipe,
            ':src' => $src
        ]);
    }

    public function update($id, $tipe, $src) {
        $query = "UPDATE " . $this->table_name . " SET tipe = :tipe, src = :src WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':tipe' => $tipe,
            ':src' => $src
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>