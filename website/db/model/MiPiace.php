<?php

    require_once("interfaces/Entity.php");

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

    class MiPiaceCreateDTO implements CreatableEntity {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            private int $post,
            private int $utente
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".MiPiaceCreateDTO::schema->value."(Post, Utente) VALUE(?, ?)");
            $stmt->bind_param("ii", $this->post, $this->utente);
            
            return $stmt;
        }
    }

    class MiPiaceDeleteDTO implements DeletableEntity {
        private const schema = Schemas::MI_PIACE;

        public function __construct(
            private int $post,
            private int $utente
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".MiPiaceDeleteDTO::schema->value." WHERE Post = ? AND Utente = ?");
            $stmt->bind_param("ii", $this->post, $this->utente);

            return $stmt;
        }

        public static function from(MiPiaceDTO $dto) {
            return new MiPiaceDeleteDTO(
                $dto->post,
                $dto->utente
            );
        }
    }
    
?>
