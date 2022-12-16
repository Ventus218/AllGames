<?php

    require_once("interfaces/Entity.php");

    class TagInPostDTO {
        private const schema = Schemas::TAG_IN_POST;

        public function __construct(
            public readonly string $tag,
            public readonly int $post
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(TagInPostDTO::schema) as $row) {
                array_push($arr, TagInPostDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): TagInPostDTO {
            return new TagInPostDTO(
                $row["Tag"],
                $row["Post"]
            );
        }
    }

    class TagInPostCreateDTO implements CreatableEntity {
        private const schema = Schemas::TAG_IN_POST;

        public function __construct(
            private string $tag,
            private int $post
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".TagInPostCreateDTO::schema->value."(Tag, Post) VALUE(?, ?)");
            $stmt->bind_param("si", $this->tag, $this->post);
            
            return $stmt;
        }
    }

    class TagInPostDeleteDTO implements DeletableEntity {
        private const schema = Schemas::TAG_IN_POST;

        public function __construct(
            private string $tag,
            private int $post
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".TagInPostDeleteDTO::schema->value." WHERE Tag = ? AND Post = ?");
            $stmt->bind_param("si", $this->tag, $this->post);

            return $stmt;
        }

        public static function from(TagInPostDTO $dto) {
            return new TagInPostDeleteDTO(
                $dto->tag,
                $dto->post
            );
        }
    }
    
?>