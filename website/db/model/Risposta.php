<?php

    class RispostaKeys {
        public const id = 'Id';
        public const testo = 'Testo';
        public const timestamp = 'Timestamp';
        public const risponditore = 'Risponditore';
        public const commento = 'Commento';
    }

    class RispostaDTO {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            public readonly int $id,
            public readonly string $testo,
            public readonly DateTime $timestamp,
            public readonly int $risponditore,
            public readonly int $commento
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(RispostaDTO::schema) as $row) {
                array_push($arr, RispostaDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $id): ?self {
            $row = $db->getOneByID(self::schema, array(
                RispostaKeys::id => $id
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): RispostaDTO {
            return new RispostaDTO(
                $row[RispostaKeys::id],
                $row[RispostaKeys::testo],
                dateTimeFromSQLDate($row[RispostaKeys::timestamp]),
                $row[RispostaKeys::risponditore],
                $row[RispostaKeys::commento]
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

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                RispostaKeys::id => $this->id,
                RispostaKeys::testo => $this->testo,
                RispostaKeys::timestamp => sqlDateFromDateTime($this->timestamp),
                RispostaKeys::risponditore => $this->risponditore,
                RispostaKeys::commento => $this->commento
            ));
        }
    }

    class RispostaDeleteDTO {
        private const schema = Schemas::RISPOSTA;

        public function __construct(
            private int $id
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                RispostaKeys::id => $this->id
            ));
        }

        public static function from(RispostaDTO $dto) {
            return new RispostaDeleteDTO(
                $dto->id
            );
        }
    }
    
?>
