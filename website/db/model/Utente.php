<?php

    require_once(__DIR__."/../../inc/php/utils.php");

    class UtenteKeys {
        public const id = 'Id';
        public const username = 'Username';
        public const passwordHash = 'PasswordHash';
        public const nome = 'Nome';
        public const cognome = 'Cognome';
        public const dataNascita = 'DataNascita';
        public const genere = 'Genere';
        public const email = 'Email';
        public const telefono = 'Telefono';
        public const urlImmagine = 'UrlImmagine';
    }

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

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(UtenteDTO::schema) as $row) {
                array_push($arr, UtenteDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $id): ?self {
            $row = $db->getOneByID(self::schema, array(
                UtenteKeys::id => $id
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByUsername(Database $db, string $username): ?self {
            $rows = $db->select(self::schema, array(
                UtenteKeys::username => $username
            ));

            if (sizeof($rows) === 0) {
                return null;
            } else if (sizeof($rows) === 1) {
                return self::fromDBRow($rows[0]);
            } else {
                internalServerError("Sembra esistano più utenti con lo stesso username. Questo implica una violazione precedentemente avvenuta dei vincoli del database.");
            }
        }

        public static function fromDBRow(array $row): UtenteDTO {
            return new UtenteDTO(
                $row[UtenteKeys::id],
                $row[UtenteKeys::username],
                $row[UtenteKeys::passwordHash],
                $row[UtenteKeys::nome],
                $row[UtenteKeys::cognome],
                dateTimeFromSQLDate($row[UtenteKeys::dataNascita]),
                GenereUtente::from($row[UtenteKeys::genere]),
                $row[UtenteKeys::email],
                $row[UtenteKeys::telefono],
                $row[UtenteKeys::urlImmagine]
            );
        }

        public function getFullUrlImmagine(): string {
            return "multimedia-db/".$this->urlImmagine;
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

        /**
         * @throws DatabaseException
         */
        public function createOn(Database $db): ?int {
            return $db->create(self::schema, array(
                UtenteKeys::id => $this->id,
                UtenteKeys::username => $this->username,
                UtenteKeys::passwordHash => $this->passwordHash,
                UtenteKeys::nome => $this->nome,
                UtenteKeys::cognome => $this->cognome,
                UtenteKeys::dataNascita => sqlDateFromDateTime($this->dataNascita),
                UtenteKeys::genere => $this->genere->value,
                UtenteKeys::email => $this->email,
                UtenteKeys::telefono => $this->telefono,
                UtenteKeys::urlImmagine => $this->urlImmagine,
            ));
        }
    }

    class UtenteDeleteDTO {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private int $id
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                UtenteKeys::id => $this->id
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

        /**
         * @throws DatabaseException
         */
        public function updateOn(Database $db) {
            return $db->update(self::schema, array(
                UtenteKeys::id => $this->id,
                UtenteKeys::username => $this->username,
                UtenteKeys::passwordHash => $this->passwordHash,
                UtenteKeys::nome => $this->nome,
                UtenteKeys::cognome => $this->cognome,
                UtenteKeys::dataNascita => sqlDateFromDateTime($this->dataNascita),
                UtenteKeys::genere => $this->genere->value,
                UtenteKeys::email => $this->email,
                UtenteKeys::telefono => $this->telefono,
                UtenteKeys::urlImmagine => $this->urlImmagine
            ), array(
                UtenteKeys::id => $this->id
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