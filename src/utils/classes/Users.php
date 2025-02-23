<?php

class Users
{
    private $conn;

    // Constructeur : initialise la connexion à la base de données
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Créer un nouvel utilisateur
     *
     * @param string $firstname Prénom
     * @param string $lastname Nom
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe (non haché)
     * @return bool True si l'utilisateur a été créé avec succès, False sinon
     */
    public function createUser($firstname, $lastname, $email, $username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hachage du mot de passe
        
        $sql = "INSERT INTO users (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $username, $hashedPassword);
        
        if ($stmt->execute()) {
            $user = array('firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'username' => $username);
            $user['timestamp'] = time();
            $_SESSION['user'] = $user;
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    /**
     * Supprimer un utilisateur par son ID
     *
     * @param int $id ID de l'utilisateur à supprimer
     * @return bool True si l'utilisateur a été supprimé avec succès, False sinon
     */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    /**
     * Connexion de l'utilisateur
     *
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe (non haché)
     * @return mixed Retourne l'utilisateur si la connexion réussit, False sinon
     */
    public function loginUser($username, $password)
    {
        $sql = "SELECT id, firstname, lastname, username, password FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                // create a session with a user key which have a timestamp if the user is connected and not used for a long time and all user info without password
                $user['timestamp'] = time();
                unset($user['password']);
                $_SESSION['user'] = $user;
                return TRUE; // Retourne true si la connexion réussit
            }
        }

        return false; // Échec de la connexion
    }

    /**
    * check_session
     */
    public function check_session()
    {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            //echo 'session found';
            if (time() - $user['timestamp'] > 3600) {
                unset($_SESSION['user']);
                return false;
            } else {
                $user['timestamp'] = time();
                $_SESSION['user'] = $user;
                return true;
            }
        } else {
            return false;
        }
    }



}

?>
