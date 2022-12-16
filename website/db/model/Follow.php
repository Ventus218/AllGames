<?php

    require_once("interfaces/Entity.php");

    class FollowDTO {
        private const schema = Schemas::FOLLOW;

        public function __construct(
            public readonly int $utenteSeguace,
            public readonly int $utenteSeguito
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(FollowDTO::schema) as $row) {
                array_push($arr, FollowDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): FollowDTO {
            return new FollowDTO(
                $row["UtenteSeguace"],
                $row["UtenteSeguito"]
            );
        }
    }

    class FollowCreateDTO implements CreatableEntity {
        private const schema = Schemas::FOLLOW;

        public function __construct(
            private int $utenteSeguace,
            private int $utenteSeguito
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".FollowCreateDTO::schema->value."(UtenteSeguace, UtenteSeguito) VALUE(?, ?)");
            $stmt->bind_param("ii", $this->utenteSeguace, $this->utenteSeguito);
            
            return $stmt;
        }
    }

    class FollowDeleteDTO implements DeletableEntity {
        private const schema = Schemas::FOLLOW;

        public function __construct(
            private int $utenteSeguace,
            private int $utenteSeguito
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".FollowDeleteDTO::schema->value." WHERE UtenteSeguace = ? AND UtenteSeguito = ?");
            $stmt->bind_param("ii", $this->utenteSeguace, $this->utenteSeguito);

            return $stmt;
        }

        public static function from(FollowDTO $dto) {
            return new FollowDeleteDTO(
                $dto->utenteSeguace,
                $dto->utenteSeguito
            );
        }
    }
    
?>