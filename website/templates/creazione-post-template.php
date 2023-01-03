<?php

$utente = $templateParams["utente"];
$communities = $templateParams["communities"];
$tags = $templateParams["tags"];

?>

<div class="row">
    <div class="col-12 text-start">
        <form action="#" method="post">
            <header>
                <h2 class="fw-bold">Creazione post</h2>
            </header>
            <hr class="opacity-75 border border-1 rounded">

            <section>
                <header>
                    <h3 class="visually-hidden">Campi obbligatori</h2>
                </header>

                <div class="row">
                    <div class="col mb-3">
                        <label for="testo" class="fw-bold fs-5 form-label"> Aggiungi un testo </label>
                        <textarea class="form-control text-white bg-transparent border-2 border-lightgray rounded-2" name="testo" id="testo" rows="3" placeholder="Scrivi.." required></textarea>
                    </div>
                </div>
            </section>
            <hr class="opacity-75 border border-1 rounded">

            <section>
                <header>
                    <h3 class="text-secondary fs-5">Non obbligatori</h3>
                </header>

                <div class="row">
                    <div class="col mb-5">
                        <label for="multimedia" class="fw-bold fs-5 form-label"> Aggiungi contenuti multimediali </label>
                        <input type="file" name="multimedia" id="multimedia" accept="image/*, video/*" multiple/>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="tags" class="fw-bold fs-5 form-label"> Lista dei tag </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-4">
                        <select name="tags[]" id="tags" class="form-select w-100 bg-transparent text-white" multiple>
                            <?php foreach($tags as $tag): ?>
                            <option value="<?php echo $tag->nome; ?>"><?php echo $tag->nome; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#tagsInfo">
                            <img class="info-pic" src="inc/img/info.png" alt="Info riguardo i tag">
                        </a>

                        <!-- The Modal -->
                        <div class="modal" id="tagsInfo">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-gray">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Informazioni sui tag</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <p> Un tag serve a dare una maggiore visibilità al tuo post in generale, 
                                            poichè se un tuo post contiene un determinato tag allora sarà trovato da un utente nel momento 
                                            in cui accede alla pagina di quel tag. Per esempio se un tuo post contiene il tag "Dark souls",
                                            nella pagina del tag corrispondente sarà possibile trovare quel tuo post
                                        </p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Chiudi</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-5">
                        <label for="nuoviTag" class="fw-bold fs-5 form-label"> Aggiungi uno o più tag (separati da spazi)</label>
                        <input class="form-control text-white" name="nuoviTag" id="nuoviTag" placeholder="Scrivi.." />
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="community" class="fw-bold fs-5 form-label"> Scegli una community </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-4">
                        <select name="community" id="community" class="form-select w-100 bg-transparent text-white">
                            <option class="bg-black" value="" disabled selected>Scegli una community</option>

                            <?php foreach($communities as $community): ?>

                            <option class="bg-black" value="<?php echo $community->nome; ?>"><?php echo $community->nome; ?></option>

                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="col-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#communityInfo">
                            <img class="info-pic" src="inc/img/info.png" alt="Info riguardo le community">
                        </a>

                        <!-- The Modal -->
                        <div class="modal" id="communityInfo">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-gray">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Informazioni sulle community</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <p> Le community possono essere create da qualsiasi utente e funzionano come un gruppo in cui non c'è
                                            qualcuno con dei privilegi particolari. Ognuno può guardare i post di una community se accede alla pagina della community,
                                            ma solo chi la segue può publicarci post o avere i post della community nel feed della Home.
                                        </p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Chiudi</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <hr class="opacity-75 border border-1 rounded">

            <div class="row">
                <div class="col-12">
                    <input class="btn btn-warning w-100" type="submit" value="Pubblica" />
                </div>
            </div>
        </form>
    </div>
</div>