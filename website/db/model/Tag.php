<?php

    class TagKeys {
        public const nome = 'Nome';
    }

    class TagDTO {
        private const schema = Schemas::TAG;

        public function __construct(
            public readonly string $nome
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(TagDTO::schema) as $row) {
                array_push($arr, TagDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, string $nome): ?self {
            $row = $db->getOneByID(self::schema, array(
                TagKeys::nome => $nome
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): TagDTO {
            return new TagDTO(
                $row[TagKeys::nome]
            );
        }
    }

    class TagCreateDTO  {
        private const schema = Schemas::TAG;

        public function __construct(
            private string $nome
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                TagKeys::nome => $this->nome
            ));
        }
    }

    class TagDeleteDTO {
        private const schema = Schemas::TAG;

        public function __construct(
            private string $nome
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                TagKeys::nome => $this->nome
            ));
        }

        public static function from(TagDTO $dto) {
            return new TagDeleteDTO(
                $dto->nome
            );
        }
    }
    
?>