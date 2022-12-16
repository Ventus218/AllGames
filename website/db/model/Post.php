<?php

    require_once("interfaces/Entity.php");

    class PostDTO {
        private const schema = Schemas::POST;

        public function __construct(
            public readonly int $id,
            public readonly string $testo,
            public readonly DateTime $timestamp,
            public readonly int $utente,
            public readonly ?string $community
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(PostDTO::schema) as $row) {
                array_push($arr, PostDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): PostDTO {
            return new PostDTO(
                $row["Id"],
                $row["Testo"],
                dateTimeFromSQLDate($row["Timestamp"]),
                $row["Utente"],
                $row["Community"],
            );
        }
    }

    class PostCreateDTO implements CreatableEntity {
        private const schema = Schemas::POST;

        public function __construct(
            private string $testo,
            private DateTime $timestamp,
            private int $utente,
            private ?string $community,
            private ?int $id = null
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            if (is_null($this->id)) {
                $stmt = $db->prepare("INSERT INTO ".PostCreateDTO::schema->value."(Id, Testo, Timestamp, Utente, Community) VALUE(?,?,?,?,?)");
                $timestamp = sqlDateFromDateTime($this->timestamp);
                $stmt->bind_param("issis", $this->id, $this->testo, $timestamp, $this->utente, $this->community);
            } else {
                $stmt = $db->prepare("INSERT INTO ".PostCreateDTO::schema->value."(Testo, Timestamp, Utente, Community) VALUE(?,?,?,?)");
                $timestamp = sqlDateFromDateTime($this->timestamp);
                $stmt->bind_param("ssis", $this->testo, $timestamp, $this->utente, $this->community);
            }
            return $stmt;
        }
    }

    class PostDeleteDTO implements DeletableEntity {
        private const schema = Schemas::POST;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".PostDeleteDTO::schema->value." WHERE Id = ?");
            $stmt->bind_param("i", $this->id);

            return $stmt;
        }

        public static function from(PostDTO $dto) {
            return new PostDeleteDTO(
                $dto->id
            );
        }
    }
    
?>