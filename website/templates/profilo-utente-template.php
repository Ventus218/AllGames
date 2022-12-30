        <?php
            $utente = $templateParams["utente-of-profile"];
            $numberOfPosts = sizeof($templateParams["posts_data"]);
            $follows = $templateParams["follow"];
            $followers = $templateParams["followers"];
            $followsNumber = sizeof($follows);
            $followersNumber = sizeof($followers);
            $communities = $templateParams["communities"];
        ?>
        <div class="row mb-4 gap-1">
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
                        <div class="col-auto text-center">
                            <a href="#" class="border border-lightgray rounded text-white border-2 btn px-2">
                                <strong> <?php echo $numberOfPosts; ?> </strong> Post
                            </a>
                        </div>
                        <div class="col-auto text-center">
                            <a href="#" class="border border-lightgray rounded text-white border-2 btn px-2">
                                <strong> <?php echo $followsNumber; ?> </strong> Follow
                            </a>
                        </div>
                        <div class="col-auto text-center">
                            <a href="#" class="border border-lightgray rounded text-white border-2 btn px-2">
                                <strong> <?php echo $followersNumber; ?> </strong> Follower
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php if ($templateParams["is-current-user-profile"] === true): ?>
                                <a href="#" class="btn btn-warning w-100">
                                    <strong> Modifica profilo </strong>
                                </a>
                            <?php else: ?>
                                <form action="#" method="post">
                                    <input type="hidden" name="follow" value="<?php echo ($templateParams["is-followed"] === true ? "0" : "1"); ?>" />
                                    <button class="btn btn-warning w-100" type="submit">
                                        <strong>
                                        <?php echo ($templateParams["is-followed"] === true ? "Non seguire più" : "Segui"); ?>
                                        </strong>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-12">
                <section class="p-3 bg-gray rounded border border-2">
                    <div class="row mb-1">
                        <header>
                            <h2 class="m-0"> Communities </h2>
                        </header>
                    </div>
                    <div class="row d-flex justify-content-evenly gap-1 overflow-auto communities-height">
                        <?php  if(sizeof($communities) == 0): ?>
                        <div class="row">
                            <a href="#" class="col-auto text-warning text-decoration-none d-flex flex-row align-items-center">
                                <p class="m-0"> Non segui alcuna community </p>
                            </a>
                        </div>
                        <?php else:
                            foreach($communities as $community):
                        ?>
                        <div class="row">
                            <a href="<?php echo "community.php?community=".$community->nome; ?>" class="col-auto text-warning text-decoration-none d-flex flex-row align-items-center">
                                <img src="<?php echo (isset($community->urlImmagine) ? $community->urlImmagine : "inc/img/people.png"); ?>" alt="Immagine della community <?php echo $community->nome; ?>" class="post-profile-pic me-2">
                                <p class="m-0"> <?php echo $community->nome; ?> </p>
                            </a>
                        </div>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </div>
                </section>
            </div>
        </div>
        <?php require("templates/feed.php"); ?>
