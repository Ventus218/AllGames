<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AllGames <?php echo (isset($templateParams["page-title"]) ? "- ".$templateParams["page-title"] : "" ); ?> </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="inc/css/style.css" />
</head>
<body class="bg-black text-white">

    <div class="container-fluid p-0 px-4 overflow-hidden">

        <!--Top bar of the page-->
        <div class="row p-2 fixed-top bg-blur">
            <div class="col ps-4">
                <header>
                    <h1>AllGames</h1>
                </header>
            </div>

            <?php if (isset($templateParams["show-top-bar-buttons"]) && $templateParams["show-top-bar-buttons"] === true): ?>
            <!--Menu with create post button, create community button and notifications-->
            <div class="col-6">
                <ul class="nav nav-pills mt-2"> 
                    <!--Create a community button-->
                    <li class="col-4 nav-item">
                        <a class="nav-link border border-lightgray text-center text-white p-0 pb-1 border-2" id="plus-community-image" href="#">
                            +
                            <img src="inc/img/demo.png" alt="Crea community" id="crea-community" />
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
                    <li class="col-3 nav-item">
                        <div class="dropdown dropdown-menu-end">
                            <a role="button" class="nav-link p-0 position-relative" data-bs-toggle="dropdown" id="dropdownNotificationsButton" href="#" aria-expanded="false" data-bs-auto-close="false">
                                <img id="notifiche" src="inc/img/demo_2.png" alt="Notifiche" />
                                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill bg-danger p-1">
                                    <!--Number of new notifications-->
                                    1299
                                    <!--For screen readers-->
                                    <span class="visually-hidden">Nuove notifiche</span>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-dark bg-blur pb-1" aria-labelledby="dropdownMenuLink" role="notificationLists">
                                <li class="mb-2">
                                    <span class="dropdown-item-text clearfix">
                                        <a href="#" class="text-decoration-none d-flex item-align-center ">
                                            <img src="inc/img/profile-pic.png" alt="" class="profile-pic rounded-circle float-start me-3"/>
                                            <span class="text-white"> 
                                                <strong><span class="text-warning">Draco4ever</span> ha messo mi piace ad un tuo post</strong>
                                            </span>
                                        </a>
                                        <span class="text-danger float-end"><strong>Non letto</strong></span>
                                    </span>
                                </li>
                                <li><hr class="mb-2 mt-0 mx-5 border-white border-3 border rounded opacity-100"></li>
                                <li class="mb-2">
                                    <span class="dropdown-item-text clearfix">
                                        <a href="#" class="text-decoration-none text-light d-flex item-align-center">
                                            <img src="inc/img/profile-pic.png" alt="" class="profile-pic rounded-circle float-start me-3"/>
                                            <span> 
                                                <strong><span class="text-warning">YOU_DIED</span> ha pubblicato un nuovo post in una community che segui</strong>
                                            </span>
                                        </a>
                                    </span>
                                </li>
                                <li><hr class="mb-2 mt-0 mx-5 border-white border-3 border rounded opacity-100"></li>
                                <li class="mb-2">
                                    <span class="dropdown-item-text clearfix">
                                        <a href="#" class="text-decoration-none text-light d-flex item-align-center">
                                            <img src="inc/img/profile-pic.png" alt="" class="profile-pic rounded-circle float-start me-3"/>
                                            <span> 
                                                <strong><span class="text-warning">Draco4ever</span> ha commentato un tuo post</strong>
                                            </span>
                                        </a>
                                        <span class="text-danger float-end"><strong>Non letto</strong></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <?php endif; ?>

        </div>
        <?php
        if(isset($templateParams["content"])){
            require($templateParams["content"]);
        }
        ?>
    </div>

    <?php if(isset($templateParams["show-footer"]) && $templateParams["show-footer"] === true): ?>
        <!--Footer of the page, with Home, Search, User and Settings buttons.-->
        <div class="row fixed-bottom bg-black">
            <hr class="mb-1">
            <div class="col-12 mb-1">
                <footer>
                    <ul class="nav nav-pills"> 
                        <!--Home-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="#">
                                <img src="inc/img/demo.png" alt="Home" />
                            </a>
                        </li>
                        <!--Searh-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="#">
                                <img src="inc/img/demo.png" alt="Search" />
                            </a>
                        </li>
                        <!--User-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="#">
                                <img src="inc/img/demo.png" alt="User" />
                            </a>
                        </li>
                        <!--Settings-->
                        <li class="col-3 nav-item">
                            <a class="nav-link text-center" href="#">
                                <img src="inc/img/demo.png" alt="Settings" />
                            </a>
                        </li>
                    </ul>
                </footer>
            </div>  
        </div>
    <?php endif; ?>
    <?php
    if(isset($templateParams["js"])):
        foreach ($templateParams["js"] as $script): ?>
        <script src=" <?php echo $script; ?> "></script>
    <?php
        endforeach;
    endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
