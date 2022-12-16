<?php

    require_once("model/interfaces/Entity.php");
    require_once("model/Schemas.php");

    class Database {
        private $db;

        public function __construct($servername, $username, $password, $dbname, $port) {
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                internalServerError("Connessione a MySQL fallita: " . $this->db->connect_error);
            }        
        }

        public function __destruct() {
            $this->db->close();
        }

        public function getAll(Schemas $schema): array {
            $stmt = $this->db->prepare("SELECT * FROM ".$schema->value);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * @return ?int The auto-generated id of the newly inserted record.
         * 
         * Note: The returned value is null is the record id is not automatically generated.
         * 
         * Obviously that's not a problem as in that case the id must have been set in the DTO
         * and consequently it's already known.
         */
        public function create(CreatableEntity $createDTO): ?int {
            $stmt = $createDTO->creationPreparedStatement($this->db);
            $stmt->execute();

            return $stmt->insert_id;
        }

        public function delete(DeletableEntity $deleteDTO) {
            $stmt = $deleteDTO->deletionPreparedStatement($this->db);
            $stmt->execute();
        }

        public function update(UpdatableEntity $updateDTO) {
            $stmt = $updateDTO->updatePreparedStatement($this->db);
            $stmt->execute();
        }
    }
?>
