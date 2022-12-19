<?php

    enum GenereUtente: string {
        case MASCHIO = "M";
        case FEMMINA = "F";
        CASE NON_DEFINITO = "U";
    }

    class UtenteDTO {
        private const schema = Schemas::UTENTE;

        public function __construct(
            public readonly int $id,
            public readonly string $username,
            public readonly string $passwordHash,
            public readonly string $nome,
            public readonly string $cognome,
            public readonly DateTime $dataNascita,
            public readonly GenereUtente $genere,
            public readonly string $email,
            public readonly string $telefono,
            public readonly ?string $urlImmagine
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(UtenteDTO::schema) as $row) {
                array_push($arr, UtenteDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function getOneByID(Database $db, int $id): self {
            $row = $db->getOneByID(self::schema, array(
                'Id' => $id
            ));

            return self::fromDBRow($row);
        }

        public static function fromDBRow(array $row): UtenteDTO {
            return new UtenteDTO(
                $row["Id"],
                $row["Username"],
                $row["PasswordHash"],
                $row["Nome"],
                $row["Cognome"],
                dateTimeFromSQLDate($row["DataNascita"]),
                GenereUtente::from($row["Genere"]),
                $row["Email"],
                $row["Telefono"],
                $row["UrlImmagine"]
            );
        }
    }

    class UtenteCreateDTO  {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private string $username,
            private string $passwordHash,
            private string $nome,
            private string $cognome,
            private DateTime $dataNascita,
            private GenereUtente $genere,
            private string $email,
            private string $telefono,
            private ?string $urlImmagine,
            private ?int $id = null
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                'Id' => $this->id,
                'Username' => $this->username,
                'PasswordHash' => $this->passwordHash,
                'Nome' => $this->nome,
                'Cognome' => $this->cognome,
                'DataNascita' => sqlDateFromDateTime($this->dataNascita),
                'Genere' => $this->genere->value,
                'Email' => $this->email,
                'Telefono' => $this->telefono,
                'UrlImmagine' => $this->urlImmagine,
            ));
        }
    }

    class UtenteDeleteDTO {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Id' => $this->id
            ));
        }

        public static function from(UtenteDTO $dto) {
            return new UtenteDeleteDTO(
                $dto->id
            );
        }
    }

    class UtenteUpdateDTO {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private int $id,
            public string $username,
            public string $passwordHash,
            public string $nome,
            public string $cognome,
            public DateTime $dataNascita,
            public GenereUtente $genere,
            public string $email,
            public string $telefono,
            public ?string $urlImmagine
        ) {}

        public function updateOn(Database $db) {
            return $db->update(self::schema, array(
                'Id' => $this->id,
                'Username' => $this->username,
                'PasswordHash' => $this->passwordHash,
                'Nome' => $this->nome,
                'Cognome' => $this->cognome,
                'DataNascita' => sqlDateFromDateTime($this->dataNascita),
                'Genere' => $this->genere->value,
                'Email' => $this->email,
                'Telefono' => $this->telefono,
                'UrlImmagine' => $this->urlImmagine,
            ), array(
                'Id' => $this->id
            ));
        }

        public static function from(UtenteDTO $dto) {
            return new UtenteUpdateDTO(
                $dto->id,
                $dto->username,
                $dto->passwordHash,
                $dto->nome,
                $dto->cognome,
                $dto->dataNascita,
                $dto->genere,
                $dto->email,
                $dto->telefono,
                $dto->urlImmagine
            );
        }
    }
?>