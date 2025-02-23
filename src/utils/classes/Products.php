<?php

class Products
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Créer un produit
    public function createProduct($product, $description, $price)
    {
        $sql = "INSERT INTO products (product, description, price) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssd", $product, $description, $price);

        return $stmt->execute();
    }

    // Récupérer un produit par ID
    public function getProduct($id)
    {
        $sql = "SELECT id, product, description, price FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows === 1 ? $result->fetch_assoc() : false;
    }

    // Récupérer tous les produits
    public function getAllProducts()
    {
        $sql = "SELECT id, product, description, price FROM products";
        $result = $this->conn->query($sql);

        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }

    // Supprimer un produit par ID
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>
