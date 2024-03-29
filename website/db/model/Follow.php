<?php

    class FollowKeys {
        public const utenteSeguace = 'UtenteSeguace';
        public const utenteSeguito = 'UtenteSeguito';
    }

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
        public static function getOneByID(Database $db, int $utenteSeguace, int $utenteSeguito): ?self {
            $row = $db->getOneByID(self::schema, array(
                FollowKeys::utenteSeguace => $utenteSeguace,
                FollowKeys::utenteSeguito => $utenteSeguito
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): FollowDTO {
            return new FollowDTO(
                $row[FollowKeys::utenteSeguace],
                $row[FollowKeys::utenteSeguito]
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
                FollowKeys::utenteSeguace => $this->utenteSeguace,
                FollowKeys::utenteSeguito => $this->utenteSeguito
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
                FollowKeys::utenteSeguace => $this->utenteSeguace,
                FollowKeys::utenteSeguito => $this->utenteSeguito
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