<?php

    class PostDTO {
        private const schema = Schemas::POST;

        public function __construct(
            public readonly int $id,
            public readonly string $testo,
            public readonly DateTime $timestamp,
            public readonly int $utente,
            public readonly ?string $community
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(PostDTO::schema) as $row) {
                array_push($arr, PostDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $id): self {
            $row = $db->getOneByID(self::schema, array(
                'Id' => $id
            ));

            return self::fromDBRow($row);
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

    class PostCreateDTO  {
        private const schema = Schemas::POST;

        public function __construct(
            private string $testo,
            private DateTime $timestamp,
            private int $utente,
            private ?string $community,
            private ?int $id = null
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Id' => $this->id,
                'Testo' => $this->testo,
                'Timestamp' => sqlDateFromDateTime($this->timestamp),
                'Utente' => $this->utente,
                'Community' => $this->community
            ));
        }
    }

    class PostDeleteDTO {
        private const schema = Schemas::POST;

        public function __construct(
            private int $id
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Id' => $this->id
            ));
        }

        public static function from(PostDTO $dto) {
            return new PostDeleteDTO(
                $dto->id
            );
        }
    }
    
?>