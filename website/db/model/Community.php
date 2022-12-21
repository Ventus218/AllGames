<?php

    class CommunityDTO {
        private const schema = Schemas::COMMUNITY;
        
        public function __construct(
            public readonly string $nome,
            public readonly string $urlImmagine,
            public readonly int $fondatore
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(CommunityDTO::schema) as $row) {
                array_push($arr, CommunityDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, string $nome): self {
            $row = $db->getOneByID(self::schema, array(
                'Nome' => $nome
            ));

            return self::fromDBRow($row);
        }

        public static function fromDBRow(array $row): CommunityDTO {
            
            return new CommunityDTO(
                $row["Nome"],
                $row["UrlImmagine"],
                $row["Fondatore"]
            );
        }
    }

    class CommunityCreateDTO  {
        private const schema = Schemas::COMMUNITY;

        public function __construct(
            private string $nome,
            private string $urlImmagine,
            private int $fondatore
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Nome' => $this->nome,
                'UrlImmagine' => $this->urlImmagine,
                'Fondatore' => $this->fondatore
            ));
        }
    }

?>