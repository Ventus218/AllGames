<?php

    class MiPiaceKeys {
        public const post = 'Post';
        public const utente = 'Utente';
    }

    class MiPiaceDTO {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            public readonly int $post,
            public readonly int $utente
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(MiPiaceDTO::schema) as $row) {
                array_push($arr, MiPiaceDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $post, int $utente): self {
            $row = $db->getOneByID(self::schema, array(
                MiPiaceKeys::post => $post,
                MiPiaceKeys::utente => $utente
            ));

            return self::fromDBRow($row);
        }

        public static function fromDBRow(array $row): MiPiaceDTO {
            return new MiPiaceDTO(
                $row[MiPiaceKeys::post],
                $row[MiPiaceKeys::utente]
            );
        }
    }

    class MiPiaceCreateDTO  {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            private int $post,
            private int $utente
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                MiPiaceKeys::post => $this->post,
                MiPiaceKeys::utente => $this->utente
            ));
        }
    }

    class MiPiaceDeleteDTO {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            private int $post,
            private int $utente
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                MiPiaceKeys::post => $this->post,
                MiPiaceKeys::utente => $this->utente
            ));
        }

        public static function from(MiPiaceDTO $dto) {
            return new MiPiaceDeleteDTO(
                $dto->post,
                $dto->utente
            );
        }
    }
    
?>
