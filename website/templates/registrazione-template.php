<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AllGames - Registrazione</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="inc/css/style.css" />
</head>
<body class="bg-black text-white">

    <div class="container-fluid p-0 overflow-hidden px-4">
        <div class="row p-2 fixed-top bg-blur">
            <div class="col-12 px-4">
                <header>
                    <h1>AllGames</h1>
                </header>
            </div>
        </div>

        <div class="row mt-6">
            <div class="col-12 text-start">
                <form action="" method="post">
                    <header class="text-center">
                        <h2>Benvenuto!</h2>
                        <p>Inserisci i dati per registrarti</p>
                    </header>
                    <section>
                        <header>
                            <h3 class="text-start"> Dati account </h3>
                        </header>
                        
                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-3" type="text" name="email" id="email" placeholder="Inserisci la tua e-mail" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-3" type="text" name="username" id="username" placeholder="Inserisci il tuo username" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-3" type="text" name="telefono" id="telefono" placeholder="Inserisci il tuo numero di telefono" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="password" name="password" id="password" placeholder="Inserisci la password" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="password" name="conferma-password" id="conferma-password" placeholder="Inserisci nuovamente la password" required>
                            </div>
                        </div>
                    </section>

                    <section>
                        <header>
                            <h3 class="text-start"> Dati anagrafici </h3>
                        </header>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="text" name="nome" id="nome" placeholder="Inserisci il tuo nome" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="text" name="cognome" id="cognome" placeholder="Inserisci il tuo cognome" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input class="form-control mb-4" type="date" name="data-nascita" id="data-nascita" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <header>
                                    <h4 class="text-start">Genere</h4>
                                </header>
                            </div>
                            <div class="col">
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genere" id="maschio" value="M" required>
                                        <label class="form-check-label" for="maschio"> Maschio </label>
                                </div>
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genere" id="femmina" value="F" required>
                                        <label class="form-check-label" for="femmina"> Femmina </label>
                                </div>
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genere" id="non-definito" value="U" required>
                                        <label class="form-check-label" for="non-definito"> Non definito </label>
                                </div>
                            </div>
                        </div>
                    </section>

                    <?php if (isset($templateParams["registrazione-error"])): ?>
                    <div class="row">
                        <div class="col-12 text-start">
                            <p class="text-danger"> I dati sono incorretti <?php // echo $templateParams["registrazione-error"]; ?> </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-warning w-100" value="Registrati">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <section>
                <header class="visually-hidden">
                    <h2>Riferimenti</h2>
                </header>
                <div class="col-12">
                    <p class="m-0">Possiedi già un account su AllGames?</p>
                </div>
                <div class="col-12">
                    <a href="login.php" class="text-warning text-decoration-none">Effettua l'accesso ora!</a>
                </div>
            </section>
        </div>
    </div>

    <?php foreach ($templateParams["js"] as $script): ?>
    <script src=" <?php echo $script; ?> "></script>
    <?php endforeach; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
