<?php
require_once __DIR__ . '/../config/database.php';

class RundownModel {
    private $conn;
    private $table_name = "rundowns";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
        foreach ($results as &$row) {
            $row['items'] = json_decode($row['items'], true);
        }
        return $results;
    }

    public function create($day_type, $judul, $items) {
        $query = "INSERT INTO " . $this->table_name . " (day_type, judul, items) VALUES (:day_type, :judul, :items)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':day_type' => $day_type,
            ':judul' => $judul,
            ':items' => json_encode($items)
        ]);
    }

    public function update($id, $day_type, $judul, $items) {
        $query = "UPDATE " . $this->table_name . " SET day_type = :day_type, judul = :judul, items = :items WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':day_type' => $day_type,
            ':judul' => $judul,
            ':items' => json_encode($items)
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>