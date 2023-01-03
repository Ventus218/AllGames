<?php

    class ContenutoMultimedialePostKeys {
        public const url = 'Url';
        public const ordine = 'Ordine';
        public const post = 'Post';
        public const video = 'Video';
        public const immagine = 'Immagine';
    }

    class ContenutoMultimedialePostDTO {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            public readonly string $url,
            public readonly int $ordine,
            public readonly int $post,
            public readonly bool $video,
            public readonly bool $immagine
        ) {}

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(ContenutoMultimedialePostDTO::schema) as $row) {
                array_push($arr, ContenutoMultimedialePostDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, string $url): ?self {
            $row = $db->getOneByID(self::schema, array(
                ContenutoMultimedialePostKeys::url => $url
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): ContenutoMultimedialePostDTO {
            return new ContenutoMultimedialePostDTO(
                $row[ContenutoMultimedialePostKeys::url],
                $row[ContenutoMultimedialePostKeys::ordine],
                $row[ContenutoMultimedialePostKeys::post],
                $row[ContenutoMultimedialePostKeys::video],
                $row[ContenutoMultimedialePostKeys::immagine]
            );
        }

        public function getFullUrl(): string {
            return "multimedia-db/".$this->url;
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

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                ContenutoMultimedialePostKeys::url => $this->url,
                ContenutoMultimedialePostKeys::ordine => $this->ordine,
                ContenutoMultimedialePostKeys::post => $this->post,
                ContenutoMultimedialePostKeys::video => $this->video,
                ContenutoMultimedialePostKeys::immagine => $this->immagine
            ));
        }
    }

    class ContenutoMultimedialePostDeleteDTO {
        private const schema = Schemas::CONTENUTO_MULTIMEDIALE_POST;

        public function __construct(
            private string $url
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                ContenutoMultimedialePostKeys::url => $this->url
            ));
        }

        public static function from(ContenutoMultimedialePostDTO $dto) {
            return new ContenutoMultimedialePostDeleteDTO(
                $dto->url
            );
        }
    }
    
?>