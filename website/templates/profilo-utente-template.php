        <?php
            $utente = $templateParams["utente"];
            $numberOfPosts = sizeof($templateParams["posts_data"]);
            $follow = $templateParams["follow"];
            $followers = $templateParams["followers"];
            $communities = $templateParams["communities"];
        ?>
        <div class="row mb-4">
            <div class="col-12">
                <section class="p-3 bg-gray rounded border border-2">
                    <div class="row">
                        <header>
                            <div class="row align-items-center">
                                <div class="col-auto pe-0">
                                    <img class="profile-pic <?php echo (isset($utente->urlImmagine) ? "rounded-circle" : ""); ?>" src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/people.png"); ?>" alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>">
                                </div>
                                <div class="col">
                                    <h2 class="m-0"> <?php echo $utente->username; ?> </h2>
                                </div>
                            </div>
                        </header>
                    </div>
                    <div class="row d-flex justify-content-evenly my-3">
                        <div class="col-auto border border-lightgray rounded text-center text-white border-2">
                            <p class="m-0"> <strong> <?php echo $numberOfPosts; ?> </strong> Post </p>
                        </div>
                        <div class="col-auto border border-lightgray rounded text-center text-white border-2">
                            <p class="m-0"> <strong> <?php echo $follow; ?> </strong> Follow </p>
                        </div>
                        <div class="col-auto border border-lightgray rounded text-center text-white border-2">
                            <p class="m-0"> <strong> <?php echo $followers; ?> </strong> Follower </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="#" method="post">
                                <input type="hidden" name="follow" value="<?php echo ($templateParams["is-followed"] === true ? "0" : "1"); ?>" />
                                <button class="btn btn-warning w-100" type="submit">
                                    <strong>
                                    <?php
                                        if ($templateParams["is-current-user-profile"] === true) {
                                            echo("Modifica profilo");
                                        } else {
                                            echo ($templateParams["is-followed"] === true ? "Non seguire più" : "Segui");
                                        }
                                    ?>
                                    </strong>
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php require("templates/feed.php"); ?>
