        <?php
            $tag = $templateParams["tag"];
        ?>
        <div class="row mb-4">
            <div class="col-12">
                <section class="p-3 bg-gray rounded border border-2">
                    <div class="row">
                        <header>
                            <h2> Pagina del tag <strong> <?php echo $tag->nome ?> </strong> </h2>
                        </header>
                    </div>
                </section>
            </div>
        </div>
        <?php require("templates/feed.php"); ?>
