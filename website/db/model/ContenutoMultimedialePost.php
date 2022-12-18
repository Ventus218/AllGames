<?php

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

        public static function getOneByID(Database $db, string $url): self {
            $row = $db->getOneByID(self::schema, array(
                'Url' => $url
            ));

            return self::fromDBRow($row);
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

    class ContenutoMultimedialePostCreateDTO  {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            private string $url,
            private int $ordine,
            private int $post,
            private bool $video,
            private bool $immagine
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Url' => $this->url,
                'Ordine' => $this->ordine,
                'Post' => $this->post,
                'Video' => $this->video,
                'Immagine' => $this->immagine
            ));
        }
    }

    class ContenutoMultimedialePostDeleteDTO {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            private string $url
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Url' => $this->url
            ));
        }

        public static function from(ContenutoMultimedialePostDTO $dto) {
            return new ContenutoMultimedialePostDeleteDTO(
                $dto->url
            );
        }
    }
    
?>