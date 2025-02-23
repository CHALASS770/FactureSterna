<?php

class InvoiceProducts
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Associer un produit à une facture
    public function addProductToInvoice($invoice_id, $product_id, $quantity, $unit_price)
    {
        $total = $quantity * $unit_price; // Calcul du total
        $sql = "INSERT INTO invoice_products (invoice_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiid", $invoice_id, $product_id, $quantity, $unit_price);

        return $stmt->execute();
    }

    // Récupérer les produits d'une facture
    public function getProductsByInvoice($invoice_id)
    {
        $sql = "SELECT invoice_id, product_id, quantity, unit_price, total FROM invoice_products WHERE invoice_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $invoice_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }

    // Supprimer un produit d'une facture
    public function removeProductFromInvoice($id)
    {
        $sql = "DELETE FROM invoice_products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>
