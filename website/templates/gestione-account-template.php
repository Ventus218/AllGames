
<?php

$utente = $templateParams["utente"];

?>

<div class="row">
    <div class="col-12 text-start">
        <form action="#" method="post">
            <section>
                <header>
                    <h2 class="fw-bold">Gestione account</h2>
                </header>

                <hr class="opacity-75 border border-1 rounded">

                <div class="row">
                    <div class="col mb-3">
                        <div class="d-flex">
                            <label for="immagineProfilo" class="mx-auto cursor-pointer">
                                <img id="previewImg" class="change-profile-pic rounded-circle" src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?>" alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>">
                            </label>

                            <input class="d-none" type="file" accept="image/jpeg, image/png" name="immagineProfilo" id="immagineProfilo" />
                        </div>
                    </div>
                </div>

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
                            <input class="form-control w-90" type="tel" pattern="[0-9]{1,}" name="telefono" id="telefono" placeholder="Inserisci il numero di telefono" required value="<?php echo $utente->telefono; ?>"/>
                        </div>
                        <div class="col-6">
                            <input class="form-control w-90 ms-auto" type="date" name="data-nascita" id="data-nascita" required/>
                        </div>
                    </div>     
                </div>   

                <div class="row">
                    <div class="col-12 mt-3">
                        <header>
                            <h3 class="text-start">Genere</h3>
                        </header>
                    </div>
                    <div class="col d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genere" id="maschio" value="M" required />
                                <label class="form-check-label" for="maschio"> Maschio </label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genere" id="femmina" value="F" required />
                                <label class="form-check-label" for="femmina"> Femmina </label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genere" id="non-definito" value="U" required />
                                <label class="form-check-label" for="non-definito"> Non definito </label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 mt-3">
                        <header>
                            <h3 class="text-start">Password</h3>
                        </header>
                    </div>

                    <div class="col d-flex">
                        <div class="col-6">
                            <input class="form-control w-90" type="password" name="password" id="password" placeholder="Nuova password" required />
                        </div>
                        <div class="col-6">
                            <input class="form-control w-90 ms-auto" type="password" name="conferma-password" id="conferma-password" placeholder="Conferma password" required/>
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