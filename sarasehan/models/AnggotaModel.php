<?php
require_once __DIR__ . '/../config/database.php';

class AnggotaModel {
    private $conn;
    private $table_name = "members";

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

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create($nama, $kategori, $jabatan, $foto) {
        $query = "INSERT INTO " . $this->table_name . " (nama, kategori, jabatan, foto) VALUES (:nama, :kategori, :jabatan, :foto)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nama' => $nama,
            ':kategori' => $kategori,
            ':jabatan' => $jabatan,
            ':foto' => $foto
        ]);
    }

    public function update($id, $nama, $kategori, $jabatan, $foto) {
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, kategori = :kategori, jabatan = :jabatan, foto = :foto WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':nama' => $nama,
            ':kategori' => $kategori,
            ':jabatan' => $jabatan,
            ':foto' => $foto
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>