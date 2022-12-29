        <div class="row">
            <div class="col-12 text-center">
                <form action="" method="post">
                    <header>
                        <h2>Bentornato!</h2>
                        <p>Effettua il login</p>
                    </header>

                    <div class="row">
                        <div class="col-12">
                            <input class="form-control mb-3" type="text" name="username" id="username" placeholder="Inserisci il tuo username" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <input class="form-control mb-4" type="password" name="password" id="password" placeholder="Inserisci la tua password" required>
                        </div>
                    </div>

                    <?php if (isset($templateParams["login-error"])): ?>
                    <div class="row">
                        <div class="col-12 text-start">
                            <p class="text-danger"> <?php echo $templateParams["login-error"]; ?> </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-warning w-100" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <section>
                <div class="col-12">
                    <p class="m-0">Non hai ancora un account su AllGames?</p>
                </div>
                <div class="col-12">
                    <a href="registrazione.php" class="text-warning text-decoration-none">Creane uno ora!</a>
                </div>
            </section>
        </div>
