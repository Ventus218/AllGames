<?php

    class PartecipazioneCommunityKeys {
        public const utente = 'Utente';
        public const community = 'Community';
    }

    class PartecipazioneCommunityDTO {
        private const schema = Schemas::PARTECIPAZIONE_COMMUNITY;

        public function __construct(
            public readonly int $utente,
            public readonly string $community
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(PartecipazioneCommunityDTO::schema) as $row) {
                array_push($arr, PartecipazioneCommunityDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $utente, string $community): ?self {
            $row = $db->getOneByID(self::schema, array(
                PartecipazioneCommunityKeys::utente => $utente,
                PartecipazioneCommunityKeys::community => $community
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): PartecipazioneCommunityDTO {
            return new PartecipazioneCommunityDTO(
                $row[PartecipazioneCommunityKeys::utente],
                $row[PartecipazioneCommunityKeys::community]
            );
        }
    }

    class PartecipazioneCommunityCreateDTO  {
        private const schema = Schemas::PARTECIPAZIONE_COMMUNITY;

        public function __construct(
            private int $utente,
            private string $community
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                PartecipazioneCommunityKeys::utente => $this->utente,
                PartecipazioneCommunityKeys::community => $this->community
            ));
        }
    }

    class PartecipazioneCommunityDeleteDTO {
        private const schema = Schemas::PARTECIPAZIONE_COMMUNITY;

        public function __construct(
            private int $utente,
            private string $community
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                PartecipazioneCommunityKeys::utente => $this->utente,
                PartecipazioneCommunityKeys::community => $this->community
            ));
        }

        public static function from(PartecipazioneCommunityDTO $dto) {
            return new PartecipazioneCommunityDeleteDTO(
                $dto->utente,
                $dto->community
            );
        }
    }
    
?>