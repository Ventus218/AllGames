<div class="row">
    <form action="#" method="post" class="px-2 mt-2">
    <div class="row me-1">
        <div class="col-11 pe-0">
            <input class="form-control mb-3" type="text" name="search" id="search" placeholder="Cerca un username o una community" required />
        </div>
        <div class="col-1 ps-0">
            <input type="image" class="opacity-50 search-img" alt="Tasto per cercare" src="inc/img/search.png" />
        </div>
    </div>
    </form>
    
    <div class="row">
        <?php if (isset($templateParams["searchedUsers"]) && sizeof($templateParams["searchedUsers"]) != 0): ?>
        <!--Utenti-->
        <div class="row mb-2">
            <div class="col-12">
                <header>
                    <h2><strong>Utenti</strong></h2>
                </header>
            </div>
            <?php 
                for($i = 0; $i < sizeof($templateParams["searchedUsers"]); $i++): 
                    $utente = $templateParams["searchedUsers"][$i];
            ?>
            <div class="col-12 mb-2">
                <a href="#" class="text-decoration-none text-white">
                    <img class="ricerca-pic" src="<?php echo (isset($utente->urlImmagine) ? $utente->urlImmagine : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $utente->username; ?>" />
                    <span><?php echo $utente->username; ?></span>
                </a>
            </div>
            <?php endfor; ?>
        </div>
        
        <?php 

        endif;

        if (isset($templateParams["searchedCommunities"]) && sizeof($templateParams["searchedCommunities"]) != 0):

        ?>
        <!--Community-->
        <div class="row">
            <hr class="mb-2 rounded opacity-50" />
            <div class="col-12">
                <header>
                    <h2><strong>Community</strong></h2>
                </header>
            </div>

            <?php 
                for($i = 0; $i < sizeof($templateParams["searchedCommunities"]); $i++): 
                    $community = $templateParams["searchedCommunities"][$i];
            ?>
            <div class="col-12 mb-2">
                <a href="<?php echo "community.php?community=".$community->nome; ?>" class="text-decoration-none text-white">
                    <img class="ricerca-pic" src="<?php echo (isset($community->urlImmagine) ? $community->urlImmagine : "inc/img/people.png"); ?> " alt="Immagine della community <?php echo $community->nome; ?>" />
                    <span><?php echo $community->nome; ?></span>
                </a>
            </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>