<?php

    class MiPiaceDTO {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            public readonly int $post,
            public readonly int $utente
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(MiPiaceDTO::schema) as $row) {
                array_push($arr, MiPiaceDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): MiPiaceDTO {
            return new MiPiaceDTO(
                $row["Post"],
                $row["Utente"]
            );
        }
    }

    class MiPiaceCreateDTO  {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            private int $post,
            private int $utente
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Post' => $this->post,
                'Utente' => $this->utente
            ));
        }
    }

    class MiPiaceDeleteDTO {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            private int $post,
            private int $utente
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Post' => $this->post,
                'Utente' => $this->utente
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
