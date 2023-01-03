        <?php
            $community = $templateParams["community"];
            $fondatore = $templateParams["fondatore"];
        ?>
        <div class="row mb-4">
            <div class="col-12">
                <section class="p-3 bg-gray rounded border border-2">
                    <div class="row">
                        <header>
                            <div class="row align-items-center">
                                <div class="col-auto pe-0">
                                    <img class="profile-pic rounded-circle" src="<?php echo $community->getFullUrlImmagine(); ?>" alt="Immagine della community" />
                                </div>
                                <div class="col">
                                    <h2 class="m-0"> <?php echo $community->nome; ?> </h2>
                                </div>
                            </div>
                        </header>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <p class="mb-0">
                                Fondatore: <a class="text-warning text-decoration-none" href=" <?php echo "profilo-utente.php?utente=".escapeSpacesForURIParam($fondatore->id); ?> "> <strong> <?php echo $fondatore->username; ?> </strong> </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>
                                Partecipanti: <strong> <?php echo $templateParams["partecipanti"]; ?> </strong>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="#" method="post">
                                <input type="hidden" name="partecipa" value="<?php echo ($templateParams["already-partecipa"] === true ? "0" : "1"); ?>" />
                                <button class="btn btn-warning w-100" type="submit">
                                    <strong> <?php echo ($templateParams["already-partecipa"] === true ? "Lascia la community" : "Unisciti alla community" ); ?> </strong>
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php require("templates/feed.php"); ?>
