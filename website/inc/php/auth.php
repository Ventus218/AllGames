<?php

    require_once(__DIR__."/../../db/Database.php");
    require_once(__DIR__."/../../db/model/Utente.php");

    function registerUtente(
        Database $db,
        string $username,
        string $password,
        string $nome,
        string $cognome,
        DateTime $dataNascita,
        GenereUtente $genere,
        string $email,
        string $telefono,
        ?string $urlImmagine,
        ?int $id = null,
        ): int {
        $u = new UtenteCreateDTO($username, password_hash($password, PASSWORD_BCRYPT), $nome, $cognome, $dataNascita, $genere, $email, $telefono, $urlImmagine, $id);
        return $u->createOn($db);
    }
    
    function authenticateUtente(string $username, string $password, Database $db): ?UtenteDTO {
        $user = UtenteDTO::getOneByUsername($db, $username);

        if (is_null($user)) {
            return null;
        }

        return password_verify($password, $user->passwordHash) ? $user : null;
    }

    function updateUtente(
        Database $db, 
        string $username,
        string $password,
        string $nome,
        string $cognome,
        DateTime $dataNascita,
        GenereUtente $genere,
        string $email,
        string $telefono,
        ?string $urlImmagine,
        UtenteDTO $utente,
        ) {
            $update = UtenteUpdateDTO::from($utente);

            $update->username = $username;
            $update->passwordHash = $password === "" ? $update->passwordHash : password_hash($password, PASSWORD_BCRYPT);
            $update->nome = $nome;
            $update->cognome = $cognome;
            $update->dataNascita = $dataNascita;
            $update->genere = $genere;
            $update->email = $email;
            $update->telefono = $telefono;
            $update->urlImmagine = $urlImmagine;

            $update->updateOn($db);
        }

?>
