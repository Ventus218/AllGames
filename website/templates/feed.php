        <div class="row gap-3">
        <!--Template post-->

            <?php foreach($templateParams["posts_data"] as $postData):
                $post = $postData["post"];
                $utente = $postData["utente"];
                $tags = $postData["tags"];
                $multim = $postData["c_multimediali"];
                $commenti = $postData["commenti"];
                $miPiace = $postData["mi_piace"];
            ?>
            <div class="col-12 d-flex justify-content-center">
                <article class="">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="row">
                                <div class="col clearfix">
                                    <img class="post-profile-pic rounded-circle float-start me-2" src=" <?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $utente->username; ?>" />
                                    <h2> <?php echo $utente->username; ?> </h2>
                                </div>
                                <div class="col-auto">
                                    <p class="timestamp text-white-50"> <?php echo $post->timestamp->format('d/m/o H:i'); ?> </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col align-self-center">
                                    <?php foreach($tags as $tag): ?>
                                    <a class="btn btn-warning rounded-pill p-1 py-0 clearfix" href="#"><strong> <?php echo $tag->tag; ?> </strong></a>
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
                            <?php if(sizeof($multim) > 0): ?>
                            <div class="slider carousel">
                                <div class="carousel-inner">
                                    <?php foreach($multim as $m): ?>
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
                                    <strong> <?php echo $commenti ?> </strong> <?php echo ($commenti === 1) ? "Commento" : "Commenti"; ?>
                                </a>
                                <a class="btn btn-outline-light border-lightgray border-2 p-1 pe-3" href="#">
                                    <img src="inc/img/liked.png" alt="Like"> <strong> <?php echo $miPiace ?> </strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        