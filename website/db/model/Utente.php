<?php

    class Utente {
        private readonly int $id;
        private readonly string $username;
        private readonly string $passwordHash;
        private readonly string $nome;
        private readonly string $cognome;
        private readonly string $dataNascita;
        private readonly string $genere;
        private readonly string $email;
        private readonly string $telefono;
        private readonly string $urlImmagine;

        public function __construct(int $id, string $username, string $passwordHash, string $nome, string $cognome, string $dataNascita, string $genere, string $email, string $telefono, string | null $urlImmagine) {
            $this->$id = $id;
            $this->$username = $username;
            $this->$passwordHash = $passwordHash;
            $this->$nome = $nome;
            $this->$cognome = $cognome;
            $this->$dataNascita = $dataNascita;
            $this->$genere = $genere;
            $this->$email = $email;
            $this->$telefono = $telefono;
            $this->$urlImmagine = $urlImmagine;
        }

        public static function createFromDBRow(array $row) {
            return new Utente(  $row["Id"],
                                $row["Username"],
                                $row["PasswordHash"],
                                $row["Nome"],
                                $row["Cognome"],
                                $row["DataNascita"],
                                $row["Genere"],
                                $row["Email"],
                                $row["Telefono"],
                                $row["UrlImmagine"]
                            );
        }
    }
?>