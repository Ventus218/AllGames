        <?php
            $post = $templateParams["post"];
            $utentePost = $templateParams["utente-post"];
            $tagsInPost = $templateParams["tags-in-post"];
            $multimPost = $templateParams["c_multimediali-post"];
            $commentiPostData = $templateParams["commenti-post-data"];
            $nMiPiacePost = $templateParams["mi_piace-post"];
        ?>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <article class="rounded border border-2">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="row d-flex justify-content-between">
                                <div class="col-auto clearfix">
                                    <a href=" <?php echo "profilo-utente.php?utente=".$post->utente; ?> " class="d-flex text-white text-decoration-none">
                                        <img class="post-profile-pic rounded-circle float-start me-2" src=" <?php echo (isset($utentePost->urlImmagine) ? $utentePost->urlImmagine : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $utente->username; ?>" />
                                        <h2> <?php echo $utentePost->username; ?> </h2>
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <p class="timestamp text-white-50"> <?php echo $post->timestamp->format('d/m/o H:i'); ?> </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col align-self-center">
                                    <?php foreach($tagsInPost as $tagInPost): ?>
                                    <a class="btn btn-warning rounded-pill p-1 py-0 clearfix" href="tag.php?tag=<?php echo $tagInPost->tag; ?>"><strong> <?php echo $tagInPost->tag; ?> </strong></a>
                                    <?php endforeach; ?>
                                </div>
                                <?php if(isset($post->community)): ?>
                                <div class="col-auto pb-1 pe-1 ps-0 align-self-end">
                                    <a class="text-warning text-decoration-none" href=" <?php echo "community.php?community=".$post->community; ?> ">
                                        <img class="community-img" src="inc/img/people.png" alt="" />
                                        <strong> <?php echo $post->community; ?> </strong>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </header>

                        <section>
                            <!--Text of the post-->
                            <header class="visually-hidden">
                                <h3>Testo del post</h3>
                            </header>
                            <p class="my-2"> <?php echo $post->testo; ?> </p>

                            <!-- Image/video carousel -->
                            <?php if(sizeof($multimPost) > 0): ?>
                            <div class="slider carousel">
                                <div class="carousel-inner">
                                    <?php foreach($multimPost as $m): ?>
                                        <?php if($m->immagine): ?>
                                        <a href="<?php echo $m->url; ?>" class="text-decoration-none">
                                            <img src=" <?php echo $m->url; ?> " alt="" />
                                        </a>
                                        <?php else: ?>
                                        <a href="<?php echo $m->url; ?>" class="text-decoration-none">
                                            <img src="inc/img/play.png" alt="" />
                                        </a>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev d-none" type="button">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next d-none" type="button">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            <?php endif; ?>
                        </section>
                    </div>

                    <div class="bg-gray rounded-bottom p-2 mt-1">
                        <footer class="d-flex">
                            <div class="mx-auto">
                                <a class="btn btn-outline-light border-lightgray border-2" href="#">
                                    <strong> <?php echo sizeof($commentiPostData) ?> </strong> <?php echo (sizeof($commentiPostData) === 1) ? "Commento" : "Commenti"; ?>
                                </a>
                                <a class="btn btn-outline-light border-lightgray border-2 p-1 pe-3" href="#">
                                    <img src="inc/img/liked.png" alt="Like"> <strong> <?php echo $nMiPiacePost ?> </strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <section class="list-commenti bg-gray rounded p-3">
                    <header>
                        <h3 class="visually-hidden"> Commenti del post </h3>
                    </header>
                    <ul class="list-inline mb-0">
                        <?php foreach ($commentiPostData as $commentoData):
                            $comm = $commentoData["commento"];
                            $commentatore = $commentoData["commentatore"];
                            $risposteData = $commentoData["risposte-data"];
                        ?>
                        <li class="list-inline-item w-100 mb-3 pb-2 border-bottom border-lightgray">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-auto">
                                        <header>
                                            <a href=" <?php echo "profilo-utente.php?utente=".$commentatore->id; ?> " class="d-flex align-items-center text-white text-decoration-none">
                                                <img class="commento-profile-pic rounded-circle float-start me-2" src=" <?php echo (isset($commentatore->urlImmagine) ? $commentatore->urlImmagine : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $commentatore->username; ?>" />
                                                <h4 class="m-0 fs-6"> <?php echo $commentatore->username; ?> </h4>
                                            </a>
                                        </header>
                                    </div>        
                                </div>
                                <div class="row">
                                    <p class="ms-3 mb-0"> <?php echo $comm->testo; ?> </p>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <?php if (sizeof($risposteData) > 0): ?>
                                    <div class="col-auto">
                                        <button class="btn commento-button text-secondary fst-italic m-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#risposte-commento-<?php echo $comm->id; ?>" aria-expanded="false" aria-controls="risposte-commento-<?php echo $comm->id; ?>">
                                            --- Visualizza/Nascondi <?php echo sizeof($risposteData).(sizeof($risposteData) > 1 ? " risposte" : " risposta"); ?>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    <div class="col d-flex justify-content-end">
                                        <button class="btn commento-button text-secondary fst-italic m-0 p-0" type="button">
                                            Rispondi
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php if (sizeof($risposteData) > 0): ?>
                                <div class="collapse" id="risposte-commento-<?php echo $comm->id; ?>">
                                    <ul class="list-inline ms-5 mb-0 pe-3">
                                        <?php foreach ($risposteData as $rispostaData):
                                            $risposta = $rispostaData["risposta"];
                                            $risponditore = $rispostaData["risponditore"];
                                        ?>
                                        <li class="list-inline-item w-100 mb-2 pb-2 border-bottom border-lightgray">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <header>
                                                            <a href=" <?php echo "profilo-utente.php?utente=".$risponditore->id; ?> " class="d-flex align-items-center text-white text-decoration-none">
                                                                <img class="commento-profile-pic rounded-circle float-start me-2" src=" <?php echo (isset($risponditore->urlImmagine) ? $risponditore->urlImmagine : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $risponditore->username; ?>" />
                                                                <h4 class="m-0 fs-6"> <?php echo $risponditore->username; ?> </h4>
                                                            </a>
                                                        </header>
                                                    </div>
                                                </div>
                                                <p class="ms-3 mb-0"> <?php echo $risposta->testo; ?> </p>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </div>
            <div class="col-12 mt-1">
                <section class="bg-gray rounded px-3 py-2">
                    <form class="commenta" action="#" method="post">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <header>
                                    <h3 class="m-0"> Stai commentando / Stai rispondendo a: <strong> Tizio </strong> </h3>
                                </header>
                            </div>
                            <div class="col pe-0 mt-1">
                                <label class="visually-hidden" for="text-area-commento"> Commenta o rispondi a Tizio.. </label>
                                <textarea class="form-control text-white bg-transparent border-2 border-lightgray rounded-2" name="testo" id="text-area-commento" rows="2" placeholder="Commenta o rispondi a Tizio.." required></textarea>
                            </div>
                            <div class="col-auto px-1">
                                <button class="btn p-0" type="submit">
                                    <img src="inc/img/keyboard.png" alt="Icona dei tasti W, A, S e D per inviare il commento">
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
