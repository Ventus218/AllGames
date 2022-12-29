<?php

    class CommentoKeys {
        public const id = 'Id';
        public const testo = 'Testo';
        public const timestamp = 'Timestamp';
        public const post = 'Post';
        public const commentatore = 'Commentatore';
    }

    class CommentoDTO {
        private const schema = Schemas::COMMENTO;

        public function __construct(
            public readonly int $id,
            public readonly string $testo,
            public readonly DateTime $timestamp,
            public readonly int $post,
            public readonly int $commentatore
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(CommentoDTO::schema) as $row) {
                array_push($arr, CommentoDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $id): ?self {
            $row = $db->getOneByID(self::schema, array(
                CommentoKeys::id => $id
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): CommentoDTO {
            return new CommentoDTO(
                $row[CommentoKeys::id],
                $row[CommentoKeys::testo],
                dateTimeFromSQLDate($row[CommentoKeys::timestamp]),
                $row[CommentoKeys::post],
                $row[CommentoKeys::commentatore]
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

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                CommentoKeys::id => $this->id,
                CommentoKeys::testo => $this->testo,
                CommentoKeys::timestamp => sqlDateFromDateTime($this->timestamp),
                CommentoKeys::post => $this->post,
                CommentoKeys::commentatore => $this->commentatore
            ));
        }
    }

    class CommentoDeleteDTO {
        private const schema = Schemas::COMMENTO;

        public function __construct(
            private int $id
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                CommentoKeys::id => $this->id
            ));
        }

        public static function from(CommentoDTO $dto) {
            return new CommentoDeleteDTO(
                $dto->id
            );
        }
    }
    
?>
