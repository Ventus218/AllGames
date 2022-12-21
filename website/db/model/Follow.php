<?php

    class FollowDTO {
        private const schema = Schemas::FOLLOW;

        public function __construct(
            public readonly int $utenteSeguace,
            public readonly int $utenteSeguito
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(FollowDTO::schema) as $row) {
                array_push($arr, FollowDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $utenteSeguace, int $utenteSeguito): self {
            $row = $db->getOneByID(self::schema, array(
                'UtenteSeguace' => $utenteSeguace,
                'UtenteSeguito' => $utenteSeguito
            ));

            return self::fromDBRow($row);
        }

        public static function fromDBRow(array $row): FollowDTO {
            return new FollowDTO(
                $row["UtenteSeguace"],
                $row["UtenteSeguito"]
            );
        }
    }

    class FollowCreateDTO  {
        private const schema = Schemas::FOLLOW;

        public function __construct(
            private int $utenteSeguace,
            private int $utenteSeguito
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'UtenteSeguace' => $this->utenteSeguace,
                'UtenteSeguito' => $this->utenteSeguito
            ));
        }
    }

    class FollowDeleteDTO {
        private const schema = Schemas::FOLLOW;

        public function __construct(
            private int $utenteSeguace,
            private int $utenteSeguito
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'UtenteSeguace' => $this->utenteSeguace,
                'UtenteSeguito' => $this->utenteSeguito
            ));
        }

        public static function from(FollowDTO $dto) {
            return new FollowDeleteDTO(
                $dto->utenteSeguace,
                $dto->utenteSeguito
            );
        }
    }
    
?>