        <div class="row">
            <div class="col-12 text-start">
                <section>
                    <div class="row">
                        <header>
                            <h2 class="fw-bold">Informazioni</h2>
                        </header>
                    </div>

                    <hr class="opacity-75 border border-1 rounded">
        
                    <div class="row">
                        <section>
                            <header>
                                <h3 class="fs-4 fw-bold">Cos'è AllGames</h3>
                            </header>
                            <p> All Games è un social network a tema videogiochi sviluppato come progetto universitario per l'insegnamento di Tecnologie Web </p>
                        </section>
                    </div>

                    <hr class="opacity-50 mb-3 me-2 border border-1 rounded">

                    <div class="row">
                        <section>
                            <header>
                                <h3 class="fs-4 fw-bold">Sviluppatori</h3>
                            </header>
                            <ul class="list-unstyled">
                                <?php foreach($templateParams["sviluppatori"] as $sviluppatore ): ?>
                                    <li> <a class="text-warning text-decoration-none" href="<?php echo $sviluppatore["github"]; ?>"> <strong> <?php echo $sviluppatore["nome"]; ?> </strong></a> </li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                    </div>
                            
                    <hr class="opacity-50 mb-3 me-2 border border-1 rounded">

                    <div class="row">
                        <section>
                            <header>
                                <h3 class="fs-4 fw-bold">Crediti</h3>
                            </header>
                            <p>Le icone utilizzate sono state create dai seguenti autori su <a class="text-warning text-decoration-none" href="https://www.flaticon.com">flaticon.com</a>:</p>
                            <ul class="list-unstyled">
                                <?php foreach($templateParams["autori-flaticon"] as $autore ): ?>
                                <li> <a class="text-warning text-decoration-none" href="<?php echo $autore["link"]; ?>"> <strong> <?php echo $autore["nome"]; ?> </strong></a> </li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                    </div>
                </section>
            </div>
        </div>