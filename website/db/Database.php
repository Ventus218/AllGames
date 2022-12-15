<?php
    foreach (glob("db/model/*") as $file) {
        require_once($file);
    }

    class Database {
        private $db;

        public function __construct($servername, $username, $password, $dbname, $port) {
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                internalServerError("Connessione a MySQL fallita: " . $db->connect_error);
            }        
        }

        public function getAllUtenti(): array {
            $stmt = $this->db->prepare("SELECT * FROM UTENTE");
            $stmt->execute();
            $result = $stmt->get_result();

            $utenti = array();

            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
                array_push($utenti, Utente::createFromDBRow($row));
            }

            return $utenti;
        }
    }
?>
