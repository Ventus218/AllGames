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
                                    <img class="profile-pic rounded-circle" src="<?php echo $community->urlImmagine; ?>" alt="Immagine della community">
                                </div>
                                <div class="col">
                                    <h2 class="m-0"> <?php echo $community->nome; ?> </h2>
                                </div>
                            </div>
                        </header>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <p>
                                Fondatore: <a class="text-warning text-decoration-none" href="#"> <strong> <?php echo $fondatore->username; ?> </strong> </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="#" method="post">
                                <button class="btn btn-warning w-100" type="submit">
                                    <strong> <?php echo ($templateParams["utente-partecipa"] === true ? "Lascia la community" : "Unisciti alla community" ); ?> </strong>
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php require("templates/feed.php"); ?>
