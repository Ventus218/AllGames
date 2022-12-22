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

        <!--All of the posts-->
        <div class="row mb-6">
            <div class="col-12 mt-6 d-flex">
                <article class="mx-auto">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="clearfix">
                                <img class="float-start me-2" src="../inc/img/demo.png" alt="Immagine profilo di Th3 Pr0K1ll3r" />
                                <h2>Th3 Pr0K1ll3r</h2>
                            </div>
                            <a class="btn btn-warning rounded-pill p-1 py-0 clearfix" href="#"><strong>DarkSouls</strong></a>
                        </header>

                        <section>
                            <!--Text of the post-->
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ../incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>

                            <!-- Image/video carousel -->
                            <div class="slider carousel">
                                <div class="carousel-inner">
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev d-none" type="button">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next d-none" type="button">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        </section>
                    </div>

                    <div class="bg-gray rounded-bottom p-2 mt-1">
                        <footer class="d-flex">
                            <div class="mx-auto">
                                <a class="btn btn-outline-light border-lightgray border-2" href="#">
                                    <strong>1056</strong> Commenti
                                </a>
                                <a class="btn btn-outline-light border-lightgray border-2 p-1 pe-3" href="#">
                                    <img src="../inc/img/demo.png" alt="Like"> <strong>30600</strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>
            <div class="col-12 mt-4 d-flex">
                <article class="mx-auto">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="clearfix">
                                <img class="float-start me-2" src="../inc/img/demo.png" alt="Immagine profilo di Th3 Pr0K1ll3r" />
                                <h2>Th3 Pr0K1ll3r</h2>
                            </div>
                            <a class="btn btn-warning rounded-pill p-1 py-0 clearfix" href="#"><strong>DarkSouls</strong></a>
                        </header>

                        <section>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ../incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>

                            <!-- Carousel -->
                            <div class="slider carousel">
                                <div class="carousel-inner">
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev d-none" type="button">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next d-none" type="button">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>

                        </section>
                    </div>

                    <div class="bg-gray rounded-bottom p-2 mt-1">
                        <footer class="d-flex">
                            <div class="mx-auto">
                                <a class="btn btn-outline-light border-lightgray border-2" href="#">
                                    <strong>1056</strong> Commenti
                                </a>
                                <a class="btn btn-outline-light border-lightgray border-2 p-1 pe-3" href="#">
                                    <img src="../inc/img/demo.png" alt="Like"> <strong>30600</strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>

            <div class="col-12 mt-4 d-flex">
                <article class="mx-auto">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="clearfix">
                                <img class="float-start me-2" src="../inc/img/demo.png" alt="Immagine profilo di Th3 Pr0K1ll3r" />
                                <h2>Th3 Pr0K1ll3r</h2>
                            </div>
                            <a class="btn btn-warning rounded-pill p-1 py-0 clearfix" href="#"><strong>DarkSouls</strong></a>
                        </header>

                        <section>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ../incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>

                            <!-- Carousel -->
                            <div class="slider carousel">
                                <div class="carousel-inner">
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev d-none" type="button">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next d-none" type="button">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>

                        </section>
                    </div>

                    <div class="bg-gray rounded-bottom p-2 mt-1">
                        <footer class="d-flex">
                            <div class="mx-auto">
                                <a class="btn btn-outline-light border-lightgray border-2" href="#">
                                    <strong>1056</strong> Commenti
                                </a>
                                <a class="btn btn-outline-light border-lightgray border-2 p-1 pe-3" href="#">
                                    <img src="../inc/img/demo.png" alt="Like"> <strong>30600</strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>

            <div class="col-12 mt-4 d-flex">
                <article class="mx-auto">
                    <div class="bg-gray rounded-top p-3">
                        <header>
                            <div class="clearfix">
                                <img class="float-start me-2" src="../inc/img/demo.png" alt="Immagine profilo di Th3 Pr0K1ll3r" />
                                <h2>Th3 Pr0K1ll3r</h2>
                            </div>
                            <a class="btn btn-warning rounded-pill p-1 py-0 clearfix" href="#"><strong>DarkSouls</strong></a>
                        </header>

                        <section>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ../incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>

                            <!-- Carousel -->
                            <div class="slider carousel">
                                <div class="carousel-inner">
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                    <img src="../inc/img/demo.png" alt="" />
                                    <img src="../inc/img/demo_2.png" alt="" />
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev d-none" type="button">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next d-none" type="button">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>

                        </section>
                    </div>

                    <div class="bg-gray rounded-bottom p-2 mt-1">
                        <footer class="d-flex">
                            <div class="mx-auto">
                                <a class="btn btn-outline-light border-lightgray border-2" href="#">
                                    <strong>1056</strong> Commenti
                                </a>
                                <a class="btn btn-outline-light border-lightgray border-2 p-1 pe-3" href="#">
                                    <img src="../inc/img/demo.png" alt="Like"> <strong>30600</strong>
                                </a>
                            </div>
                        </footer>
                    </div>
                </article>
            </div>
        </div>
        
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