<?php

    require_once("interfaces/Entity.php");

    class CommunityDTO {
        private const schema = Schemas::COMMUNITY;
        
        public function __construct(
            public readonly string $nome,
            public readonly string $urlImmagine
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(CommunityDTO::schema) as $row) {
                array_push($arr, CommunityDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): CommunityDTO {
            
            return new CommunityDTO(
                $row["Nome"],
                $row["UrlImmagine"]
            );
        }
    }

    class CommunityCreateDTO implements CreatableEntity {
        private const schema = Schemas::COMMUNITY;

        public function __construct(
            private string $nome,
            private string $urlImmagine
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".CommunityCreateDTO::schema->value."(Nome, UrlImmagine) VALUE(?,?)");
            $stmt->bind_param("ss", $this->nome, $this->urlImmagine);
            return $stmt;
        }
    }

?>