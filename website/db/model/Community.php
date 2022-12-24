<?php

    class CommunityKeys {
        public const nome = 'Nome';
        public const urlImmagine = 'UrlImmagine';
        public const fondatore = 'Fondatore';
    }

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
                CommunityKeys::nome => $nome
            ));

            return self::fromDBRow($row);
        }

        public static function fromDBRow(array $row): CommunityDTO {
            
            return new CommunityDTO(
                $row[CommunityKeys::nome],
                $row[CommunityKeys::urlImmagine],
                $row[CommunityKeys::fondatore]
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
                CommunityKeys::nome => $this->nome,
                CommunityKeys::urlImmagine => $this->urlImmagine,
                CommunityKeys::fondatore => $this->fondatore
            ));
        }
    }

?>