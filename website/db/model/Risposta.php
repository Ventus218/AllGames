<?php

    require_once("interfaces/Entity.php");

    class RispostaDTO {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            public readonly int $id,
            public readonly string $testo,
            public readonly DateTime $timestamp,
            public readonly int $risponditore,
            public readonly int $commento
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(RispostaDTO::schema) as $row) {
                array_push($arr, RispostaDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): RispostaDTO {
            return new RispostaDTO(
                $row["Id"],
                $row["Testo"],
                $row["Timestamp"],
                $row["Risponditore"],
                $row["Commento"]
            );
        }
    }

    class RispostaCreateDTO implements CreatableEntity {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            private string $testo,
            private DateTime $timestamp,
            private int $risponditore,
            private int $commento,
            private ?int $id = null
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            if (is_null($this->id)) {
                $stmt = $db->prepare("INSERT INTO ".RispostaCreateDTO::schema->value."(Id, Testo, Timestamp, Risponditore, Commento) VALUE(?,?,?,?,?)");
                $timestamp = sqlDateFromDateTime($this->timestamp);
                $stmt->bind_param("issii", $this->id, $this->testo, $timestamp, $this->risponditore, $this->commento);
            } else {
                $stmt = $db->prepare("INSERT INTO ".RispostaCreateDTO::schema->value."(Testo, Timestamp, Risponditore, Commento) VALUE(?,?,?,?)");
                $timestamp = sqlDateFromDateTime($this->timestamp);
                $stmt->bind_param("ssii", $this->testo, $timestamp, $this->risponditore, $this->commento);
            }
            return $stmt;
        }
    }

    class RispostaDeleteDTO implements DeletableEntity {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".RispostaDeleteDTO::schema->value." WHERE Id = ?");
            $stmt->bind_param("i", $this->id);

            return $stmt;
        }

        public static function from(RispostaDTO $dto) {
            return new RispostaDeleteDTO(
                $dto->id
            );
        }
    }
    
?>
