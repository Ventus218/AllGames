        <div class="row">
            <div class="col-12">
                <form action="#" method="post" enctype="multipart/form-data">
                    <section>
                        <header>
                            <h2 class="fw-bold">Fondazione community</h2>
                        </header>

                        <hr class="opacity-75 border border-1 rounded">

                        <div class="row">
                            <div class="row text-center mb-2">
                                <p class="fs-5 m-0"> Scegli un'immagine per la community </p>
                                <p class="fs-6 m-0 text-danger"> Non potrà essere modificata in futuro </p>
                            </div>
                            <div class="col mb-3">
                                <div class="d-flex">
                                    <label for="immagine-community" class="mx-auto cursor-pointer border rounded">
                                        <img id="previewImg" class="change-profile-pic rounded-circle" src="inc/img/plus.png" alt="Immagine di profilo della community"/>
                                    </label>

                                    <input class="d-none" type="file" accept="image/jpeg, image/png" name="immagine-community" id="immagine-community" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-2">
                                <label class="visually-hidden" for="nome-community"> Inserisci nome community </label>
                                <input class="form-control" type="text" name="nome-community" id="nome-community" placeholder="Nome community" required />
                            </div>
                        </div>
                    </section>

                    <div class="row">
                        <div id="error-list" class="col-12 text-start">
                            <?php if (isset($templateParams["errors"])): ?>
                                <?php foreach ($templateParams["errors"] as $error): ?>
                                <p class="mb-1 text-danger"> <?php echo $error; ?> </p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            <input class="btn btn-warning w-100" type="submit" value="Fonda" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
