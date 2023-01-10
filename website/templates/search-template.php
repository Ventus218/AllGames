<div class="row">
    <form action="#" method="post" class="px-2 mt-2">
    <div class="row me-1">
        <div class="col-11 pe-0">
            <label for="search" class="visually-hidden">Cerca un username o una community</label>
            <input class="form-control mb-3" type="text" name="search" id="search" placeholder="Cerca un username o una community" required />
        </div>
        <div class="col-1 ps-0">
            <label class="visually-hidden" for="search-button">Tasto per cercare</label>
            <input type="image" class="opacity-50 search-img" alt="Tasto per cercare" src="inc/img/search.png" id="search-button"/>
        </div>
    </div>
    </form>
    
    <div class="row">
        <?php if (isset($templateParams["searchedUsers"]) && sizeof($templateParams["searchedUsers"]) != 0): ?>
        <!--Utenti-->
        <div class="row mb-2">
            <hr class="mb-2 rounded opacity-50" />
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
                <a href="profilo-utente.php?utente=<?php echo escapeSpacesForURIParam($utente->id) ?>" class="text-decoration-none text-white">
                    <img class="ricerca-pic me-1 <?php echo (isset($utente->urlImmagine) ? "rounded-circle" : ""); ?>" src="<?php echo (isset($utente->urlImmagine) ? getMultimediaURL($utente->urlImmagine) : "inc/img/profile-pic.png"); ?> " alt="Immagine profilo di <?php echo $utente->username; ?>" />
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
        <div class="row mb-2">
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
                <a href="<?php echo "community.php?community=".escapeSpacesForURIParam($community->nome); ?>" class="text-decoration-none text-white">
                    <img class="ricerca-pic me-1 <?php echo (isset($community->urlImmagine) ? "rounded-circle" : ""); ?>" src="<?php echo (isset($community->urlImmagine) ? getMultimediaURL($community->urlImmagine) : "inc/img/people.png"); ?> " alt="Immagine della community <?php echo $community->nome; ?>" />
                    <span><?php echo $community->nome; ?></span>
                </a>
            </div>
            <?php endfor; ?>
        </div>
        <?php 
        
        endif; 
        
        if (isset($templateParams["searchedTags"]) && sizeof($templateParams["searchedTags"]) != 0):

        ?>
        <!--Tags-->
        <div class="row">
            <hr class="mb-2 rounded opacity-50" />
            <div class="col-12">
                <header>
                    <h2><strong>Tag</strong></h2>
                </header>
            </div>

            <?php 
                for($i = 0; $i < sizeof($templateParams["searchedTags"]); $i++): 
                    $tag = $templateParams["searchedTags"][$i];
            ?>
            <div class="col-12 mb-2">
                <a href="<?php echo "tag.php?tag=".escapeSpacesForURIParam($tag->nome); ?>" class="text-decoration-none text-white">
                    <img class="ricerca-pic me-1" src="inc/img/tag.png" alt="" />
                    <span><?php echo $tag->nome; ?></span>
                </a>
            </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>