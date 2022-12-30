
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

    <form action="#" method="post">
        <div class="row">
            <div class="col">
                <div class="d-flex">
                    <label for="profile-image" class="mx-auto cursor-pointer">
                        <img id="previewImg" class="change-profile-pic rounded-circle" src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?>" alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>">
                    </label>

                    <input class="d-none" type="file" accept="image/jpeg, image/png" name="profile-image" id="profile-image">
                </div>
            </div>
        </div>
    </form>
</div>