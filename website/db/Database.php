<?php

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

        public function getOneByID(Schemas $schema, array $ids): array {

            $keys = array_keys($ids);

            $query = "SELECT * FROM ".$schema->value." WHERE ";

            $types = "";

            for ($i=0; $i < sizeof($keys); $i++) { 
                $key = $keys[$i];
                
                if ($i === 0) {
                    $query = $query.($key." = ? ");
                } else {
                    $query = $query.("AND ".$key." = ?");
                }
                $types = $types.Database::getTypeCharOf($ids[$key]);
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...array_values($ids));
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC)[0];
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
         * Note: The returned value is null if the record id is not automatically generated.
         * 
         * Obviously that's not a problem as in that case the id must have been set in the $fields
         * array and consequently it's already known.
         */
        public function create(Schemas $schema, array $fields): ?int {
            $keys = array_keys($fields);

            $query = "INSERT INTO ".$schema->value." (";

            $types = "";

            for ($i=0; $i < sizeof($keys); $i++) { 
                $key = $keys[$i];
                
                if ($i === 0) {
                    $query = $query.($key);
                } else {
                    $query = $query.(", ".$key);
                }
                $types = $types.Database::getTypeCharOf($fields[$key]);
            }

            $query = $query.") VALUE(";

            for ($i=0; $i < sizeof($keys); $i++) { 
                
                if ($i === 0) {
                    $query = $query.("?");
                } else {
                    $query = $query.(", ?");
                }
            }

            $query = $query.");";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...array_values($fields));
            $stmt->execute();

            return $stmt->insert_id;
        }

        public function delete(Schemas $schema, array $ids) {
            $keys = array_keys($ids);

            $query = "DELETE FROM ".$schema->value." WHERE ";

            $types = "";

            for ($i=0; $i < sizeof($keys); $i++) { 
                $key = $keys[$i];
                
                if ($i === 0) {
                    $query = $query.($key." = ? ");
                } else {
                    $query = $query.("AND ".$key." = ? ");
                }
                $types = $types.Database::getTypeCharOf($ids[$key]);
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...array_values($ids));
            $stmt->execute();
            
            return;
        }

        public function update(Schemas $schema, array $fields, array $ids) {
            $keys = array_keys($fields);

            $query = "UPDATE ".$schema->value." SET ";

            $types = "";

            for ($i=0; $i < sizeof($keys); $i++) { 
                $key = $keys[$i];
                
                if ($i === 0) {
                    $query = $query.($key." = ?");
                } else {
                    $query = $query.(", ".$key." = ?");
                }
                $types = $types.Database::getTypeCharOf($fields[$key]);
            }

            $query = $query." WHERE ";

            $keys = array_keys($ids);

            for ($i=0; $i < sizeof($keys); $i++) { 
                $key = $keys[$i];
                
                if ($i === 0) {
                    $query = $query.($key." = ? ");
                } else {
                    $query = $query.("AND ".$key." = ? ");
                }
                $types = $types.Database::getTypeCharOf($ids[$key]);
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...array_merge(array_values($fields), array_values($ids)));
            $stmt->execute();

            return $stmt;
        }

        private static function getTypeCharOf($var): string {
            switch (gettype($var)) {
                case 'NULL':
                    return "s";
                    break;
                
                case 'boolean':
                    return "i";
                    break;

                case 'integer':
                    return "i";
                    break;

                case 'double':
                    return "d";
                    break;

                case 'string':
                    return "s";
                    break;

                default:
                    // A little rough but we are only going to use primitive types..
                    internalServerError("Unexpected query parameter of type: ".gettype($var));
                    break;
            }
        }
    }
?>
