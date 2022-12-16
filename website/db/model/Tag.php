<?php

    require_once("interfaces/Entity.php");

    class TagDTO {
        private const schema = Schemas::TAG;

        public function __construct(
            public readonly string $nome
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(TagDTO::schema) as $row) {
                array_push($arr, TagDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): TagDTO {
            return new TagDTO(
                $row["Nome"]
            );
        }
    }

    class TagCreateDTO implements CreatableEntity {
        private const schema = Schemas::TAG;

        public function __construct(
            private string $nome
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".TagCreateDTO::schema->value."(Nome) VALUE(?)");
            $stmt->bind_param("s", $this->nome);
            
            return $stmt;
        }
    }

    class TagDeleteDTO implements DeletableEntity {
        private const schema = Schemas::TAG;

        public function __construct(
            private string $nome
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".TagDeleteDTO::schema->value." WHERE Nome = ?");
            $stmt->bind_param("s", $this->nome);

            return $stmt;
        }

        public static function from(TagDTO $dto) {
            return new TagDeleteDTO(
                $dto->nome
            );
        }
    }
    
?>