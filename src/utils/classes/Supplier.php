<?php

class Supplier {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO suppliers (name) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT id, name FROM suppliers ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNameById($id) {
        $stmt = $this->conn->prepare("SELECT name FROM suppliers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
