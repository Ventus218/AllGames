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
                                    <img class="profile-pic rounded-circle" src=" <?php echo (isset($utente->urlImmagine) ? $utente->getFullUrlImmagine() : "inc/img/profile-pic.png"); ?> " alt="Immagine di profilo dell'utente <?php echo $utente->username; ?>" />
                                </div>
                                <div class="col">
                                    <h2 class="m-0"> <?php echo $utente->username; ?> </h2>
                                </div>
                            </div>
                        </header>
                    </div>
                    <div class="row d-flex justify-content-evenly my-3">
                        <div class="col-auto text-center">
                            <div class="border border-lightgray rounded text-white border-2 btn px-2">
                                <strong> <?php echo $numberOfPosts; ?> </strong> Post
                            </div>
                        </div>
                        <div class="col-auto text-center">
                            <!--Click to open the modal-->
                            <a href="#" class="border border-lightgray rounded text-white border-2 btn px-2" data-bs-toggle="modal" data-bs-target="#follows">
                                <strong> <?php echo $followsNumber; ?> </strong> Follow
                            </a>

                            <!-- The follows modal -->
                            <div class="modal fade" id="follows">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered w-75 mx-auto">
                                    <div class="modal-content bg-black">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h3 class="modal-title">Tutti i follow</h3>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <?php if($followsNumber == 0): ?>

                                                <div class="row text-start">
                                                    <span>Non ci sono follow</span>
                                                </div>

                                            <?php else: 
                                            for($i = 0; $i < $followsNumber; $i++): 
                                                $follow = $follows[$i];
                                            ?>

                                                <div class="row text-start <?php if($i < $followsNumber-1) echo "mb-3"; ?>">
                                                    <a href="profilo-utente.php?utente=<?php echo escapeSpacesForURIParam($follow->id) ?>" class="text-decoration-none text-white">
                                                        <img class="ricerca-pic" src="<?php echo (isset($follow->urlImmagine) ? $follow->getFullUrlImmagine() : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $follow->username; ?>" />
                                                        <span><?php echo $follow->username; ?></span>
                                                    </a>
                                                </div>

                                            <?php endfor; 
                                                endif; 
                                            ?>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-center">
                            <!--Click to open the modal-->
                            <a href="#" class="border border-lightgray rounded text-white border-2 btn px-2" data-bs-toggle="modal" data-bs-target="#followers">
                                <strong> <?php echo $followersNumber; ?> </strong> Follower
                            </a>

                            <!-- The follows modal -->
                            <div class="modal fade" id="followers">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered w-75 mx-auto">
                                    <div class="modal-content bg-black">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h3 class="modal-title">Tutti i follower</h3>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <?php if($followersNumber == 0): ?>

                                                <div class="row text-start">
                                                    <span>Non ci sono follower</span>
                                                </div>

                                            <?php else:
                                                for($i = 0; $i < $followersNumber; $i++): 
                                                    $follower = $followers[$i];
                                            ?>

                                                <div class="row text-start <?php if($i < $followersNumber-1) echo "mb-3"; ?>">
                                                    <a href="profilo-utente.php?utente=<?php echo escapeSpacesForURIParam($follower->id) ?>" class="text-decoration-none text-white">
                                                        <img class="ricerca-pic" src="<?php echo (isset($follower->urlImmagine) ? $follower->getFullUrlImmagine() : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $follower->username; ?>" />
                                                        <span><?php echo $follower->username; ?></span>
                                                    </a>
                                                </div>

                                            <?php endfor; 
                                                endif;
                                            ?>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php if ($templateParams["is-current-user-profile"] === true): ?>
                                <a href="gestione-account.php" class="btn btn-warning w-100">
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
                            <a href="<?php echo "community.php?community=".escapeSpacesForURIParam($community->nome); ?>" class="col-auto text-warning text-decoration-none d-flex flex-row align-items-center">
                                <img src="<?php echo (isset($community->urlImmagine) ? $community->getFullUrlImmagine() : "inc/img/people.png"); ?>" alt="Immagine della community <?php echo $community->nome; ?>" class="post-profile-pic me-2" />
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
