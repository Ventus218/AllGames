
<?php

$utente = $templateParams["utente"];

?>

<div class="row">
    <div class="row">
        <div class="col ps-2">
            <h2 class="fw-bold">Gestione account</h2>
        </div>
        <hr class="opacity-75 border border-1 rounded">
    </div>

    <div class="row">
        <div class="col">
            <div class="d-flex">
                <img class="mx-auto change-profile-pic <?php echo (isset($utente->urlImmagine) ? "rounded-circle" : ""); ?>" src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?>" alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>">
            </div>
        </div>
    </div>
</div>