<?php

    require_once("interfaces/Entity.php");

    class PartecipazioneCommunityDTO {
        private const schema = Schemas::PARTECIPAZIONE_COMMUNITY;

        public function __construct(
            public readonly int $utente,
            public readonly string $community
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(PartecipazioneCommunityDTO::schema) as $row) {
                array_push($arr, PartecipazioneCommunityDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): PartecipazioneCommunityDTO {
            return new PartecipazioneCommunityDTO(
                $row["Utente"],
                $row["Community"]
            );
        }
    }

    class PartecipazioneCommunityCreateDTO implements CreatableEntity {
        private const schema = Schemas::PARTECIPAZIONE_COMMUNITY;

        public function __construct(
            private int $utente,
            private string $community
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".PartecipazioneCommunityCreateDTO::schema->value."(Utente, Community) VALUE(?, ?)");
            $stmt->bind_param("is", $this->utente, $this->community);
            
            return $stmt;
        }
    }

    class PartecipazioneCommunityDeleteDTO implements DeletableEntity {
        private const schema = Schemas::PARTECIPAZIONE_COMMUNITY;

        public function __construct(
            private int $utente,
            private string $community
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".PartecipazioneCommunityDeleteDTO::schema->value." WHERE Utente = ? AND Community = ?");
            $stmt->bind_param("is", $this->utente, $this->community);

            return $stmt;
        }

        public static function from(PartecipazioneCommunityDTO $dto) {
            return new PartecipazioneCommunityDeleteDTO(
                $dto->utente,
                $dto->community
            );
        }
    }
    
?>