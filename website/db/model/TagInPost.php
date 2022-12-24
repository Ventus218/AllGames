<?php

    class TagInPostKeys {
        public const tag = 'Tag';
        public const post = 'Post';
    }

    class TagInPostDTO {
        private const schema = Schemas::TAG_IN_POST;

        public function __construct(
            public readonly string $tag,
            public readonly int $post
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(TagInPostDTO::schema) as $row) {
                array_push($arr, TagInPostDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, string $tag, int $post): self {
            $row = $db->getOneByID(self::schema, array(
                TagInPostKeys::tag => $tag,
                TagInPostKeys::post => $post
            ));

            return self::fromDBRow($row);
        }

        public static function fromDBRow(array $row): TagInPostDTO {
            return new TagInPostDTO(
                $row[TagInPostKeys::tag],
                $row[TagInPostKeys::post]
            );
        }
    }

    class TagInPostCreateDTO  {
        private const schema = Schemas::TAG_IN_POST;

        public function __construct(
            private string $tag,
            private int $post
        ) {}

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                TagInPostKeys::tag => $this->tag,
                TagInPostKeys::post => $this->post
            ));
        }
    }

    class TagInPostDeleteDTO {
        private const schema = Schemas::TAG_IN_POST;

        public function __construct(
            private string $tag,
            private int $post
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                TagInPostKeys::tag => $this->tag,
                TagInPostKeys::post => $this->post
            ));
        }

        public static function from(TagInPostDTO $dto) {
            return new TagInPostDeleteDTO(
                $dto->tag,
                $dto->post
            );
        }
    }
    
?>