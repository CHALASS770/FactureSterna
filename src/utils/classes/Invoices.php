<?php

class Invoices
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Créer une facture
    public function createInvoice($client_id, $type, $status, $total , $payment_date = null, $reduction = 0.0)
    {
        $sql = "INSERT INTO invoices (client_id, type, date_creation, `status`, payement_date, total, reduction) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Erreur lors de la préparation : " . $this->conn->error);
        }

        // Utiliser bind_param pour lier les paramètres
        $date_creation = date('Y-m-d');
        $stmt->bind_param("issssdd", $client_id, $type, $date_creation, $status, $payment_date, $total, $reduction);

        if (!$stmt->execute()) {
            die("Erreur lors de l'exécution : " . $stmt->error);
        }

        $invoice_id = $stmt->insert_id;
        

        $stmt->close();

        return $invoice_id;

    
    }

    // Récupérer une facture par ID
    public function getInvoiceByMonth($month)
    {
        $sql = "SELECT invoice_number, client_id, type, date_creation, total FROM invoices WHERE MONTH(date_creation) = ?";
        $stmt = $this->conn->prepare($sql);
        //check if the statement is prepared
        if (!$stmt) {
            //echo "Statement not prepared";
            //i want see the sql request
            //echo $sql;
            return false;
        }
        else
        {
            //echo "Statement prepared";
        }
        //echo "Statement prepared";
        //echo $this->conn->error;
        $stmt->bind_param("i", $month);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }

// Récupérer les données regroupées par jour pour un mois donné
public function getSumInvoiceByMonth($month)
{
    $sql = "
        SELECT 
            DATE(date_creation) AS day,
            SUM(CASE WHEN type = 'facture' THEN total ELSE 0 END) AS total_factures,
            COUNT(CASE WHEN type = 'facture' THEN id ELSE NULL END) AS nombre_factures,
            SUM(CASE WHEN type = 'devis' THEN total ELSE 0 END) AS total_devis,
            COUNT(CASE WHEN type = 'devis' THEN id ELSE NULL END) AS nombre_devis
        FROM invoices
        WHERE MONTH(date_creation) = ?
        GROUP BY DATE(date_creation)
        ORDER BY day ASC
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $month);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

    public function getInvoiceByID($invoice_number)
    {
        $sql = "SELECT
	invoice_number,
	type,
	CONCAT(cust.firstname, ' ', cust.lastname) AS customer_name,
	cust.address,
	cust.city,
	cust.zipcode,
    cust.email,
	cust.phone,
	i.total,
	IP.product_id,
	IP.quantity,
    i.reduction,
	CONCAT(IP.total, ' ₪') as total_product_price,
	CONCAT(IP.unit_price, ' ₪') as unit_price,
	p.product,
    i.payement_date,
	DATE_FORMAT(DATE(i.updated_at), '%Y-%m-%d') updated_at 
    FROM
	    invoices i
	LEFT JOIN clients cust ON (client_id = cust.id) 
	LEFT JOIN invoice_products IP on (IP.invoice_id = invoice_number)
	LEFT JOIN products p on (p.id = IP.product_id)
    WHERE
	    invoice_number = ?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $invoice_number);
        $stmt->execute();
        $result = $stmt->get_result();
        

    
        return $result->num_rows >= 1 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }

    // Récupérer toutes les factures
    public function getAllInvoices()
    {
        $sql = "SELECT
	invoice_number,
	type,
	CONCAT(cust.firstname, ' ', cust.lastname) AS customer_name,
	total,
	DATE_FORMAT(DATE(updated_at), '%d-%m-%Y') updated_at
    FROM
	invoices
    LEFT JOIN
    clients cust on (client_id = cust.id);";
        $result = $this->conn->query($sql);

        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }

    // Supprimer une facture par ID
    public function deleteInvoice($id)
    {
        $sql = "DELETE FROM invoices WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    /**
     * add in invoice table the name of the folder where the pictures are stored
     */
    public function addPicturesFolder($invoice_number, $folder)
    {
        $sql = "UPDATE invoices SET pictures_folder = ? WHERE invoice_number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $folder, $invoice_number);

        return $stmt->execute();
    }
}

?>
