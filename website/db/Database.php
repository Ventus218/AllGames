<?php

    require_once("model/Schemas.php");
    require_once("DatabaseException.php");

    class Database {
        private $db;

        public function __construct($servername, $username, $password, $dbname, $port) {
            /* https://stackoverflow.com/questions/14578243/turning-query-errors-to-exceptions-in-mysqli */
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                internalServerError("Connessione a MySQL fallita: " . $this->db->connect_error);
            }    
        }

        public function __destruct() {
            $this->db->close();
        }

        /**
         * @param Schemas $schema The schema on which the query will be executed.
         * 
         * @param array $filters An associative array where each key represents the attribute name and each value represents the value to be used.
         * Filters are applied with the AND logic operator.
         * 
         * @return ?array An associative array where each key is the attribute name and each value the value retrieved. Returns null if no object was found.
         * 
         * @throws DatabaseException
         */
        public function query(Schemas $schema, $filters): array {

            $keys = array_keys($filters);

            $query = "SELECT * FROM ".$schema->value;

            $types = "";

            for ($i=0; $i < sizeof($keys); $i++) { 
                $key = $keys[$i];
                
                if ($i === 0) {
                    $query = $query.(" WHERE ".$key." = ? ");
                } else {
                    $query = $query.("AND ".$key." = ?");
                }
                $types = $types.Database::getTypeCharOf($filters[$key]);
            }

            $stmt = $this->db->prepare($query);
            if (sizeof($filters) !== 0) {
                $stmt->bind_param($types, ...array_values($filters));
            }
            
            try {
                $stmt->execute();
            } catch (Exception $e) {
                throw new DatabaseException("query(".$schema->value.", $filters): Qualcosa è andato storto durante l'esecuzione della query.\nSQL error: ".$stmt->error);
            }

            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * @param Schemas $schema The schema on which the query will be executed.
         * 
         * @param array $ids An associative array where each key represents the attribute name and each value represents the value to be used.
         * The $ids array must contain all the components of the object identifier.
         * 
         * @return ?array An associative array where each key is the attribute name and each value the value retrieved. Returns null if no object was found.
         * 
         * @throws DatabaseException
         */
        public function getOneByID(Schemas $schema, array $ids): ?array {

            $arr = $this->query($schema, $ids);
            
            if (sizeof($arr) == 1) {
                return $arr[0];
            } else if (sizeof($arr) == 0) {
                return NULL;
            } else {
                throw new DatabaseException("getOneByID(".$schema->value.", $ids): Si è ottenuto più di un oggetto, assicurarsi che l'array $ids contenga tutti e SOLO i componenti dell'identificatore.");
            }
        }

        /**
         * @param Schemas $schema The schema on which the query will be executed.
         * 
         * @return array An associative array where each key is the attribute name and each value the value retrieved.
         * 
         * @throws DatabaseException
         */
        public function getAll(Schemas $schema): array {
            return $this->query($schema, array());
        }

        /**
         * @param Schemas $schema The schema on which the query will be executed.
         * 
         * @param array $fields An associative array where each key represents the attribute name and each value represents the value to be used.
         * 
         * @return ?int The auto-generated id of the newly inserted record.
         * The returned value is null if the record id is not automatically generated.
         * Obviously that's not a problem as in that case the id must have been set in the $fields
         * array and consequently it's already known.
         *
         * @throws DatabaseException
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
            
            try {
                $stmt->execute();
            } catch (Exception $e) {
                throw new DatabaseException("create(".$schema->value.", $fields): Qualcosa è andato storto durante la creazione dell'oggetto.\nSQL error: ".$stmt->error);
            }

            return $stmt->insert_id;
        }

        /**
         * @param Schemas $schema The schema on which the query will be executed.
         * 
         * @param array $ids An associative array where each key represents the attribute name and each value represents the value to be used.
         * The $ids array must contain all the components of the object identifier.
         * 
         * @throws DatabaseException
         */
        public function delete(Schemas $schema, array $ids) {
            $objectExists = false;
            try {
                if ($this->getOneByID($schema, $ids) != null) {
                    $objectExists = true;
                }
            } catch (DatabaseException $e) {
                throw new DatabaseException("delete(".$schema->value.", $ids): Assicurarsi che l'array $ids contenga tutti e SOLO i componenti dell'identificatore.");
            } finally {
                if (!$objectExists) {
                    throw new DatabaseException("delete(".$schema->value.", $ids): L'oggetto che si sta cercando di eliminare non è stato trovato nel database.");
                }
            }

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
            
            try {
                $stmt->execute();
            } catch (Exception $e) {
                throw new DatabaseException("delete(".$schema->value.", $ids): Qualcosa è andato storto durante l'eliminazione dell'oggetto.\nSQL error: ".$stmt->error);
            }
        }

        /**
         * @param Schemas $schema The schema on which the query will be executed.
         * 
         * @param array $ids An associative array where each key represents the attribute name and each value represents the value to be used.
         * The $ids array must contain all the components of the object identifier.
         * 
         * @param array $fields An associative array where each key represents the attribute name and each value represents the value to be used.
         * 
         * @throws DatabaseException
         */
        public function update(Schemas $schema, array $fields, array $ids) {
            $objectExists = false;
            try {
                if ($this->getOneByID($schema, $ids) != null) {
                    $objectExists = true;
                }
            } catch (DatabaseException $e) {
                throw new DatabaseException("update(".$schema->value.", $ids): Assicurarsi che l'array $ids contenga tutti e SOLO i componenti dell'identificatore.");
            } finally {
                if (!$objectExists) {
                    throw new DatabaseException("update(".$schema->value.", $ids): L'oggetto che si sta cercando di aggiornare non è stato trovato nel database.");
                }
            }

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

            try {
                $stmt->execute();
            } catch (Exception $e) {
                throw new DatabaseException("update(".$schema->value.", $ids): Qualcosa è andato storto durante l'aggiornamento dell'oggetto.\nSQL error: ".$stmt->error);
            }
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
