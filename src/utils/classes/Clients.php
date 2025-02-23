<?php

class Clients
{
    private $conn;

    // Constructeur : initialise la connexion à la base de données
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Créer un nouveau client
     *
     * @param string $firstname Prénom
     * @param string $lastname Nom
     * @param string $email Email
     * @param string $phone Téléphone
     * @return bool True si le client a été créé avec succès, False sinon
     */
    public function createClient($firstname, $lastname, $address, $city, $zipcode, $email, $phone)
    {
        $sql = "INSERT INTO clients (firstname, lastname, `address`, city, zipcode, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiss", $firstname, $lastname, $address, $city, $zipcode, $email, $phone);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Supprimer un client par son ID
     *
     * @param int $id ID du client à supprimer
     * @return bool True si le client a été supprimé avec succès, False sinon
     */
    public function deleteClient($id)
    {
        $sql = "DELETE FROM clients WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    /**
     * Récupérer les informations d'un client par son ID
     *
     * @param int $id ID du client
     * @return mixed Retourne les informations du client si trouvé, False sinon
     */
    public function getClient($id)
    {
        $sql = "SELECT id, firstname, lastname, email, phone FROM clients WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc(); // Retourne les informations du client
        }

        return false; // Aucun client trouvé
    }

    /**
     * Récupérer tous les clients
     *
     * @return mixed Retourne un tableau contenant tous les clients ou False s'il n'y a pas de clients
     */
    public function getAllClients()
    {
        $sql = "SELECT id, firstname, lastname, email, phone FROM clients";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Retourne un tableau associatif
        }

        return false; // Aucun client trouvé
    }
}

?>
