        <div class="row">
            <div class="col-12 text-start">
                <form action="" method="post">
                    <header class="text-center">
                        <h2>Benvenuto!</h2>
                        <p>Inserisci i dati per registrarti</p>
                    </header>
                    <section>
                        <header>
                            <h3 class="text-start"> Dati account </h3>
                        </header>
                        
                        <div class="row">
                            <div class="col mb-3">
                                <input class="form-control" type="email" name="email" id="email" placeholder="Inserisci la tua e-mail" required>
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
                                <input class="form-control" type="text" name="username" id="username" placeholder="Inserisci il tuo username" required>
                                <div class="invalid-feedback pb-0">
                                    Username già in uso
                                </div>
                            </div>
                            <div id="username-spinner" class="spinner-border spinner-border-sm p-2 me-3 d-none" role="status">
                                <span class="visually-hidden">Controllando se l'username è gia utilizzato...</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-3" type="tel" pattern="[0-9]{1,}" name="telefono" id="telefono" placeholder="Inserisci il tuo numero di telefono" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="password" name="password" id="password" placeholder="Inserisci la password" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="password" name="conferma-password" id="conferma-password" placeholder="Inserisci nuovamente la password" required>
                            </div>
                        </div>
                    </section>

                    <section>
                        <header>
                            <h3 class="text-start"> Dati anagrafici </h3>
                        </header>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="text" name="nome" id="nome" placeholder="Inserisci il tuo nome" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="text" name="cognome" id="cognome" placeholder="Inserisci il tuo cognome" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="date" name="data-nascita" id="data-nascita" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <header>
                                    <h4 class="text-start">Genere</h4>
                                </header>
                            </div>
                            <div class="col d-flex justify-content-between">
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genere" id="maschio" value="M" required>
                                        <label class="form-check-label" for="maschio"> Maschio </label>
                                </div>
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genere" id="femmina" value="F" required>
                                        <label class="form-check-label" for="femmina"> Femmina </label>
                                </div>
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genere" id="non-definito" value="U" required>
                                        <label class="form-check-label" for="non-definito"> Non definito </label>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="row">
                        <div id="error-list" class="col-12 text-start">
                            <p id="passw-error" class="mb-1 text-danger d-none"> Le password non coincidono </p>
                            <?php if (isset($templateParams["registrazione-errors"])): ?>
                                <?php foreach ($templateParams["registrazione-errors"] as $error): ?>
                                <p class="mb-1 text-danger"> <?php echo $error; ?> </p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-warning w-100" value="Registrati">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <section>
                <header class="visually-hidden">
                    <h2>Riferimenti</h2>
                </header>
                <div class="col-12">
                    <p class="m-0">Possiedi già un account su AllGames?</p>
                </div>
                <div class="col-12">
                    <a href="login.php" class="text-warning text-decoration-none">Effettua l'accesso ora!</a>
                </div>
            </section>
        </div>
    </div>
