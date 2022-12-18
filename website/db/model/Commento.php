<?php

    class CommentoDTO {
        private const schema = Schemas::COMMENTO;

        public function __construct(
            public readonly int $id,
            public readonly string $testo,
            public readonly DateTime $timestamp,
            public readonly int $post,
            public readonly int $commentatore
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(CommentoDTO::schema) as $row) {
                array_push($arr, CommentoDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): CommentoDTO {
            return new CommentoDTO(
                $row["Id"],
                $row["Testo"],
                dateTimeFromSQLDate($row["Timestamp"]),
                $row["Post"],
                $row["Commentatore"]
            );
        }
    }

    class CommentoCreateDTO  {
        private const schema = Schemas::COMMENTO;

        public function __construct(
            private string $testo,
            private DateTime $timestamp,
            private int $post,
            private int $commentatore,
            private ?int $id = null
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Id' => $this->id,
                'Testo' => $this->testo,
                'Timestamp' => sqlDateFromDateTime($this->timestamp),
                'Post' => $this->post,
                'Commentatore' => $this->commentatore
            ));
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            if (is_null($this->id)) {
                $stmt = $db->prepare("INSERT INTO ".CommentoCreateDTO::schema->value."(Id, Testo, Timestamp, Post, Commentatore) VALUE(?,?,?,?,?)");
                $timestamp = sqlDateFromDateTime($this->timestamp);
                $stmt->bind_param("issii", $this->id, $this->testo, $timestamp, $this->post, $this->commentatore);
            } else {
                $stmt = $db->prepare("INSERT INTO ".CommentoCreateDTO::schema->value."(Testo, Timestamp, Post, Commentatore) VALUE(?,?,?,?)");
                $timestamp = sqlDateFromDateTime($this->timestamp);
                $stmt->bind_param("ssii", $this->testo, $timestamp, $this->post, $this->commentatore);
            }
            return $stmt;
        }
    }

    class CommentoDeleteDTO {
        private const schema = Schemas::COMMENTO;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Id' => $this->id
            ));
        }

        public static function from(CommentoDTO $dto) {
            return new CommentoDeleteDTO(
                $dto->id
            );
        }
    }
    
?>
