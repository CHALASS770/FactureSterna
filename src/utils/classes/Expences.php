<?php

class Expenses {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function create($supplier_id, $payment_date, $amount, $receipt_path) {
        $stmt = $this->conn->prepare("INSERT INTO expenses (supplier_id, payment_date, amount, receipt_path) 
            VALUES (:supplier_id, :payment_date, :amount, :receipt_path)");
        return $stmt->execute([
            'supplier_id' => $supplier_id,
            'payment_date' => $payment_date,
            'amount' => $amount,
            'receipt_path' => $receipt_path
        ]);
    }

    public function getAllWithSupplierNames() {
        $stmt = $this->conn->query("SELECT e.id, 
                                           s.name AS supplier_name, 
                                           e.payment_date,
                                           e.amount,
                                           e.receipt_path,
                                           e.created_at
                                    FROM expenses e
                                    JOIN suppliers s ON e.supplier_id = s.id
                                    ORDER BY e.payment_date DESC
                    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
