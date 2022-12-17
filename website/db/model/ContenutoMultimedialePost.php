<?php

    require_once("interfaces/Entity.php");

    class ContenutoMultimedialePostDTO {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            public readonly string $url,
            public readonly int $ordine,
            public readonly int $post,
            public readonly bool $video,
            public readonly bool $immagine
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(ContenutoMultimedialePostDTO::schema) as $row) {
                array_push($arr, ContenutoMultimedialePostDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): ContenutoMultimedialePostDTO {
            return new ContenutoMultimedialePostDTO(
                $row["Url"],
                $row["Ordine"],
                $row["Post"],
                $row["Video"],
                $row["Immagine"]
            );
        }
    }

    class ContenutoMultimedialePostCreateDTO implements CreatableEntity {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            private string $url,
            private int $ordine,
            private int $post,
            private bool $video,
            private bool $immagine
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("INSERT INTO ".ContenutoMultimedialePostCreateDTO::schema->value."(Url, Ordine, Post, Video, Immagine) VALUE(?, ?, ?, ?, ?)");
            $stmt->bind_param("siiii", $this->url, $this->ordine, $this->post, $this->video, $this->immagine);
            
            return $stmt;
        }
    }

    class ContenutoMultimedialePostDeleteDTO implements DeletableEntity {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            private string $url
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".ContenutoMultimedialePostDeleteDTO::schema->value." WHERE Url = ?");
            $stmt->bind_param("s", $this->url);

            return $stmt;
        }

        public static function from(ContenutoMultimedialePostDTO $dto) {
            return new ContenutoMultimedialePostDeleteDTO(
                $dto->url
            );
        }
    }
    
?>