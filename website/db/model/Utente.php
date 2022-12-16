<?php

    require_once("interfaces/Entity.php");

    class UtenteDTO {
        private const schema = Schemas::UTENTE;

        public function __construct(
            public readonly int $id,
            public readonly string $username,
            public readonly string $passwordHash,
            public readonly string $nome,
            public readonly string $cognome,
            public readonly DateTime $dataNascita,
            public readonly string $genere,
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

        public static function fromDBRow(array $row): UtenteDTO {
            return new UtenteDTO(
                $row["Id"],
                $row["Username"],
                $row["PasswordHash"],
                $row["Nome"],
                $row["Cognome"],
                dateTimeFromSQLDate($row["DataNascita"]),
                $row["Genere"],
                $row["Email"],
                $row["Telefono"],
                $row["UrlImmagine"]
            );
        }
    }

    class UtenteCreateDTO implements CreatableEntity {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private string $username,
            private string $passwordHash,
            private string $nome,
            private string $cognome,
            private DateTime $dataNascita,
            private string $genere,
            private string $email,
            private string $telefono,
            private ?string $urlImmagine,
            private ?int $id = null
        ) {}

        public function createOn(Database $db): ?int {
            return $db->create($this);
        }

        public function creationPreparedStatement(mysqli $db): mysqli_stmt {
            if (is_null($this->id)) {
                $stmt = $db->prepare("INSERT INTO ".UtenteCreateDTO::schema->value."(Id, Username, PasswordHash, Nome, Cognome, DataNascita, Genere, Email, Telefono, UrlImmagine) VALUE(?,?,?,?,?,?,?,?,?,?)");
                $sqlDate = sqlDateFromDateTime($this->dataNascita);
                $stmt->bind_param("isssssssss", $this->id, $this->username, $this->passwordHash, $this->nome, $this->cognome, $sqlDate, $this->genere, $this->email, $this->telefono, $this->urlImmagine);
            } else {
                $stmt = $db->prepare("INSERT INTO ".UtenteCreateDTO::schema->value."(Username, PasswordHash, Nome, Cognome, DataNascita, Genere, Email, Telefono, UrlImmagine) VALUE(?,?,?,?,?,?,?,?,?)");
                $sqlDate = sqlDateFromDateTime($this->dataNascita);
                $stmt->bind_param("sssssssss", $this->username, $this->passwordHash, $this->nome, $this->cognome, $sqlDate, $this->genere, $this->email, $this->telefono, $this->urlImmagine);
            }
            return $stmt;
        }
    }

    class UtenteDeleteDTO implements DeletableEntity {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".UtenteDeleteDTO::schema->value." WHERE Id = ?");
            $stmt->bind_param("i", $this->id);

            return $stmt;
        }

        public static function from(UtenteDTO $dto) {
            return new UtenteDeleteDTO(
                $dto->id
            );
        }
    }

    class UtenteUpdateDTO implements UpdatableEntity {
        private const schema = Schemas::UTENTE;

        public function __construct(
            private int $id,
            public string $username,
            public string $passwordHash,
            public string $nome,
            public string $cognome,
            public DateTime $dataNascita,
            public string $genere,
            public string $email,
            public string $telefono,
            public ?string $urlImmagine,
        ) {}

        public function updateOn(Database $db) {
            return $db->update($this);
        }

        public function updatePreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("UPDATE ".UtenteUpdateDTO::schema->value." SET Username = ?, PasswordHash = ?, Nome = ?, Cognome = ?, DataNascita = ?, Genere = ?, Email = ?, Telefono = ?, UrlImmagine = ? WHERE Id = ?");
            $sqlDate = sqlDateFromDateTime($this->dataNascita);
            $stmt->bind_param("sssssssssi", $this->username, $this->passwordHash, $this->nome, $this->cognome, $sqlDate, $this->genere, $this->email, $this->telefono, $this->urlImmagine, $this->id);

            return $stmt;
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