<?php

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

    class RispostaCreateDTO  {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            private string $testo,
            private DateTime $timestamp,
            private int $risponditore,
            private int $commento,
            private ?int $id = null
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Id' => $this->id,
                'Testo' => $this->testo,
                'Timestamp' => sqlDateFromDateTime($this->timestamp),
                'Risponditore' => $this->risponditore,
                'Commento' => $this->commento
            ));
        }
    }

    class RispostaDeleteDTO {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Id' => $this->id
            ));
        }

        public static function from(RispostaDTO $dto) {
            return new RispostaDeleteDTO(
                $dto->id
            );
        }
    }
    
?>
