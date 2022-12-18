<?php

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

    class TagCreateDTO  {
        private const schema = Schemas::TAG;

        public function __construct(
            private string $nome
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Nome' => $this->nome
            ));
        }
    }

    class TagDeleteDTO {
        private const schema = Schemas::TAG;

        public function __construct(
            private string $nome
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Nome' => $this->nome
            ));
        }

        public static function from(TagDTO $dto) {
            return new TagDeleteDTO(
                $dto->nome
            );
        }
    }
    
?>