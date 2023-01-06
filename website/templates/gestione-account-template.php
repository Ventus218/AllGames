
<?php

$utente = $templateParams["utente"];

?>

<div class="row">
    <div class="col-12 text-start">
        <form action="#" method="post" enctype="multipart/form-data">
            <section>
                <header>
                    <h2 class="fw-bold">Gestione account</h2>
                </header>

                <hr class="opacity-75 border border-1 rounded">

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="d-flex">
                            <label for="immagineProfilo" class="mx-auto cursor-pointer">
                                <img id="previewImg" class="change-profile-pic rounded-circle" src="<?php echo (isset($utente->urlImmagine) ? getMultimediaURL($utente->urlImmagine) : "inc/img/profile-pic.png"); ?>" alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>">
                            </label>

                            <input class="d-none" type="file" accept="image/jpeg, image/png" name="immagineProfilo" id="immagineProfilo" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col mb-3">
                                <input class="form-control" type="email" name="email" id="email" placeholder="Inserisci l'email" required value="<?php echo $utente->email?>"/>
                                <div class="invalid-feedback pb-0">
                                    E-mail già in uso 
                                </div>
                            </div>
                            <div id="email-spinner" class="spinner-border spinner-border-sm p-2 me-3 d-none" role="status">
                                <span class="visually-hidden">Controllando se l'e-mail è gia utilizzata...</span>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col mb-3">
                                <input class="form-control" type="text" name="username" id="username" placeholder="Inserisci l'username" required value="<?php echo $utente->username?>"/>
                                <div class="invalid-feedback pb-0">
                                    Username già in uso 
                                </div>
                            </div>
                            <div id="username-spinner" class="spinner-border spinner-border-sm p-2 me-3 d-none" role="status">
                                <span class="visually-hidden">Controllando se l'username è gia utilizzato...</span>
                            </div>                    
                        </div>

                        <div class="row">
                            <div class="col d-flex align-items-end">
                                <div class="col-6">
                                    <input class="form-control w-90 mb-3" type="tel" pattern="[0-9]{1,}" name="telefono" id="telefono" placeholder="Inserisci il numero di telefono" required value="<?php echo $utente->telefono; ?>"/>
                                </div>
                                <div class="col-6">
                                    <input class="form-control w-90 ms-auto mb-3" type="date" name="data-nascita" id="data-nascita" required value="<?php echo $utente->dataNascita->format("Y-m-d")?>"/>
                                </div>
                            </div>
                        </div>      
                     
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-3" type="text" name="nome" id="nome" placeholder="Inserisci il tuo nome" required value="<?php echo $utente->nome; ?>"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="text" name="cognome" id="cognome" placeholder="Inserisci il tuo cognome" required value="<?php echo $utente->cognome; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-md-6">
                        <div class="col-12 mt-3">
                            <header>
                                <h3 class="text-start">Genere</h3>
                            </header>
                        </div>
                        <div class="col d-flex flex-md-column justify-content-between">
                            <div class="col-auto col-md-12 form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genere" id="maschio" value="M" required <?php echo ($utente->genere === GenereUtente::MASCHIO ? "checked" : ""); ?> />
                                    <label class="form-check-label" for="maschio"> Maschio </label>
                            </div>
                            <div class="col-auto col-md-12 form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genere" id="femmina" value="F" required <?php echo ($utente->genere === GenereUtente::FEMMINA ? "checked" : ""); ?> />
                                    <label class="form-check-label" for="femmina"> Femmina </label>
                            </div>
                            <div class="col-auto col-md-12 form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genere" id="non-definito" value="U" required <?php echo ($utente->genere === GenereUtente::NON_DEFINITO ? "checked" : ""); ?> />
                                    <label class="form-check-label" for="non-definito"> Non definito </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-12 mt-3">
                            <header>
                                <h3 class="text-start">Password</h3>
                            </header>
                        </div>

                        <div class="row">
                            <div class="col-6 col-md-12">
                                <input class="form-control" type="password" pattern=".{8,}" name="password" id="password" placeholder="Nuova password" title="Minimo 8 caratteri"/>
                            </div>
                            <div class="col-6 col-md-12">
                                <input class="form-control ms-auto ms-md-0" type="password" name="conferma-password" id="conferma-password" placeholder="Conferma password"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="error-list" class="col-12 text-start">
                        <p id="passw-error" class="mb-1 text-danger d-none"> Le password non coincidono </p>
                        <?php if (isset($templateParams["change-errors"])): ?>
                            <?php foreach ($templateParams["change-errors"] as $error): ?>
                            <p class="mb-1 text-danger"> <?php echo $error; ?> </p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </section>

            <hr class="opacity-75 my-4 border border-1 rounded">
            
            <div class="row">
                <div class="col d-flex align-items-end">
                    <div class="col-6">
                        <input class="form-control w-90" type="password" name="oldPassword" id="oldPassword" placeholder="Password attuale" required />
                    </div>
                    <div class="col-6">
                        <input class="w-90 ms-auto btn btn-warning d-block p-1" type="submit" value="Conferma" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>