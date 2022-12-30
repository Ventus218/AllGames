
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
        <div class="row gap-3">
            <div class="col-12">
                <div class="d-flex">
                    <label for="profile-image" class="mx-auto cursor-pointer">
                        <img id="previewImg" class="change-profile-pic rounded-circle" src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?>" alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>">
                    </label>

                    <input class="d-none" type="file" accept="image/jpeg, image/png" name="profile-image" id="profile-image">
                </div>
            </div>
            <div class="col-12">
                <input class="form-control" type="email" name="email" id="email" placeholder="<?php echo $utente->email?>" required />
                <div class="invalid-feedback pb-0">
                    E-mail già in uso 
                </div>
                <div id="email-spinner" class="spinner-border spinner-border-sm p-2 me-3 d-none" role="status">
                    <span class="visually-hidden">Controllando se l'e-mail è gia utilizzata...</span>
                </div>
            </div>
            <div class="col-12">
                <input class="form-control" type="text" name="username" id="username" placeholder="<?php echo $utente->nome?>" required />
                <div class="invalid-feedback pb-0">
                    Username già in uso 
                </div>
                <div id="username-spinner" class="spinner-border spinner-border-sm p-2 me-3 d-none" role="status">
                    <span class="visually-hidden">Controllando se l'username è gia utilizzato...</span>
                </div>
            </div>
        </div>
    </form>
</div>