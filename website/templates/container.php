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
