<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <base href= "<?php echo __DIR__."/"; ?>">
    <link rel="stylesheet" href="../inc/css/style.css" />
    <title>AllGames - Home</title>
</head>
<body class="bg-black text-white">
    <!--Container of all the page-->
    <div class="container-fluid p-0 overflow-hidden">

        <!--Top bar of the page-->
        <div class="row p-2 fixed-top bg-blur">
            <div class="col-6 ps-4">
                <header>
                    <h1 class="text-center">AllGames</h1>
                </header>
            </div>

            <!--Menu with create post button, create community button and notifications-->
            <div class="col-6">
                <ul class="nav nav-pills mt-2"> 
                    <!--Create a community button-->
                    <li class="col-4 nav-item">
                        <a class="nav-link border border-lightgray text-center text-white p-0 pb-1 border-2" id="plus-community-image" href="#">
                            +
                            <img src="../inc/img/demo.png" alt="Crea community" id="crea-community" />
                        </a>
                    </li>
                    <li class="col-1"></li>
                    <!--Create a post button-->
                    <li class="col-3 nav-item">
                        <a class="nav-link border border-lightgray text-center text-white p-0 pb-1 border-2" href="#">
                            +
                        </a>
                    </li>
                    <li class="col-1"></li>
                    <!--Notifications button-->
                    <li class="col-2 nav-item">
                        <a class="nav-link p-0 position-relative" href="#">
                            <img id="notifiche" src="../inc/img/demo_2.png" alt="Notifiche" />
                            <span class="position-absolute top-100 start-100 translate-middle badge rounded-pill bg-danger p-1">
                                <!--Number of new notifications-->
                                1299
                                <!--For screen readers-->
                                <span class="visually-hidden">Nuove notifiche</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row my-6 gap-3">
        <!--Template post-->

            <?php foreach($templateParams["posts_data"] as $postData):
                $post = $postData["post"];
                $utente = $postData["utente"];
                $tags = $postData["tags"];
                $multim = $postData["c_multimediali"];
                $commenti = $postData["commenti"];
                $miPiace = $postData["mi_piace"];
            ?>
            <div class="col-12 d-flex">
                <article class="mx-auto">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="row">
                                <div class="col clearfix">
                                    <img class="profile-pic rounded-circle float-start me-2" src=" <?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "../inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $utente->username; ?>" />
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
                                    <a class="text-warning text-decoration-none" href="#">
                                        <img class="community-img" src="../inc/img/people.png" alt="" />
                                        <strong> <?php echo $post->community; ?> </strong>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </header>

                        <section>
                            <!--Text of the post-->
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
                                            <img src="../inc/img/play.png" alt="" />
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
                                    <img src="../inc/img/demo.png" alt="Like"> <strong> <?php echo $miPiace ?> </strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        
        <!--Footer of the page, with Home, Search, User and Settings buttons.-->
        <div class="row fixed-bottom bg-black">
            <hr class="mb-1">
            <div class="col-12 mb-1">
                <footer>
                    <ul class="nav nav-pills"> 
                        <!--Home-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="#">
                                <img src="../inc/img/demo.png" alt="Home" />
                            </a>
                        </li>
                        <!--Searh-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="#">
                                <img src="../inc/img/demo.png" alt="Search" />
                            </a>
                        </li>
                        <!--User-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="#">
                                <img src="../inc/img/demo.png" alt="User" />
                            </a>
                        </li>
                        <!--Settings-->
                        <li class="col-3 nav-item">
                            <a class="nav-link text-center" href="#">
                                <img src="../inc/img/demo.png" alt="Settings" />
                            </a>
                        </li>
                    </ul>
                </footer>
            </div>  
        </div>
    </div>

    <!--JS script for the image/videos slider (or carousel) on the posts-->
    <script src="../inc/js/slider.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>