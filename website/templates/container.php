<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AllGames <?php echo (isset($templateParams["page-title"]) ? "- ".$templateParams["page-title"] : "" ); ?> </title>
    <link rel="icon" type="image/x-icon" href="inc/img/liked.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="inc/css/style.css" />
</head>
<body class="bg-black text-white">
    <div class="container-fluid pt-0 pb-2 px-4 mt-6 <?php echo (isset($templateParams["show-footer"]) && $templateParams["show-footer"]) ? "mb-6" : ""; ?> overflow-hidden">

        <!--Top bar of the page-->
        <div class="row px-2 py-3 fixed-top bg-blur align-items-center">
            <div class="col ps-4">
                <header>
                    <h1 class="m-0">AllGames</h1>
                </header>
            </div>

            <?php if (isset($templateParams["show-top-bar-buttons"]) && $templateParams["show-top-bar-buttons"] === true): ?>
            <!--Menu with create post button, create community button and notifications-->
            <div class="col-6">
                <ul class="nav nav-pills align-items-center">
                    <!--Create a community button-->
                    <li class="col-4 nav-item">
                        <a class="top-bar-button nav-link border border-lightgray text-center text-white p-0 pb-1 border-2" href="#">
                            <img src="inc/img/plus.png" alt="Crea community" />
                            <img src="inc/img/people.png" alt="Crea community" />
                        </a>
                    </li>
                    <li class="col-1"></li>
                    <!--Create a post button-->
                    <li class="col-3 nav-item">
                        <a class="top-bar-button nav-link border border-lightgray text-center text-white p-0 pb-1 border-2" href="#">
                            <img src="inc/img/new-post.png" alt="Pubblica un nuovo post" />
                        </a>
                    </li>
                    <li class="col-1"></li>
                    <!--Notifications button-->
                    <li class="col-3 nav-item">
                        <div class="dropdown dropdown-menu-end">
                            <a role="button" class="nav-link p-0 position-relative" data-bs-toggle="dropdown" id="dropdownNotificationsButton" href="#" aria-expanded="false" data-bs-auto-close="outside">
                                <img id="notifiche" src="inc/img/inventory.png" alt="Notifiche" />
                                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill bg-danger p-1">
                                    <!--Number of new notifications-->
                                    <?php                                         
                                        echo $templateParams["new_notifications"];
                                    ?>
                                    <!--For screen readers-->
                                    <span class="visually-hidden">Nuove notifiche</span>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-dark bg-blur pb-1" aria-labelledby="dropdownMenuLink" role="notificationLists">
                                <?php if ($templateParams["total_notifications"] == 0): ?>
                                <li class="mb-2">
                                    <span class="text-white dropdown-item-text"> 
                                        <strong>Non sono presenti notifiche</strong>
                                    </span>
                                </li>
                                
                                <?php else: 
                                    for($i = 0; $i < $templateParams["total_notifications"]; $i++):
                                        $notifica = $templateParams["notifications"][$i];
                                        $utente = $dbh->getSourceUserOfNotification($notifica);
                                        $testoNotifica = $notifica->getText();
                                        $linkNotifica = "notifica.php?notifica=".$notifica->id;
                                ?>

                                <!--Notification-->
                                <li class="mb-2">
                                    <span class="dropdown-item-text clearfix">
                                        <!--Link of the notification-->
                                        <a href="<?php echo $linkNotifica; ?>" class="text-decoration-none d-flex align-items-center justify-content-between">
                                            <span class="align-items-center d-flex">
                                                <img src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?>" alt="Immagine profilo di <?php echo $utente->username; ?>" class="notifica-profile-pic rounded-circle float-start me-3"/>
                                                <span class="text-white"> 
                                                    <span class="text-warning"><?php echo $utente->username; ?></span> <?php echo $testoNotifica; ?>
                                                </span>
                                            </span>
                                            
                                            <?php if($notifica->letta == 0): ?>
                                            <!--<span class="text-danger float-end"><strong>Non letto</strong></span>-->
                                            <span class="badge rounded-pill bg-warning p-1 float-right ms-2">
                                                <!--For screen readers-->
                                                <span class="visually-hidden">Non letta</span>
                                            </span>
                                            <?php endif;?>
                                        </a>
                                        
                                    </span>
                                </li>
                                <?php //Do not make the break line if this is the last notification 
                                if($i < $templateParams["total_notifications"]-1):?>
                                <!--Break Line-->
                                <li><hr class="mb-2 mt-0 mx-3 rounded opacity-100" /></li>

                                <?php   endif;
                                    endfor;
                                endif; 
                                ?>
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
                            <a class="nav-link" href="index.php">
                                <img src="inc/img/home.png" alt="Home" />
                            </a>
                        </li>
                        <!--Searh-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href="search.php">
                                <img src="inc/img/search.png" alt="Search" />
                            </a>
                        </li>
                        <!--User-->
                        <li class="col-3 nav-item border-end border-3 border-light text-center">
                            <a class="nav-link" href=" profilo-utente.php?utente=<?php echo $templateParams["utente"]->id ?> ">
                                <img src="inc/img/user.png" alt="User" />
                            </a>
                        </li>
                        <!--Settings-->
                        <li class="col-3 nav-item">
                            <a class="nav-link text-center" href="impostazioni.php">
                                <img src="inc/img/settings.png" alt="Settings" />
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
