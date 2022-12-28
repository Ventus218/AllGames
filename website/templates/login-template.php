<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AllGames - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="inc/css/style.css" />
</head>
<body class="bg-black text-white">

    <div class="container-fluid p-0 px-4 overflow-hidden">
        <div class="row p-2 fixed-top bg-blur">
            <div class="col-12 ps-4">
                <header>
                    <h1>AllGames</h1>
                </header>
            </div>
        </div>

        <div class="row mt-6">
            <div class="col-12 text-center">
                <form action="" method="post">
                    <header>
                        <h2>Bentornato!</h2>
                        <p>Effettua il login</p>
                    </header>

                    <div class="row">
                        <div class="col-12">
                            <input class="form-control mb-3" type="text" name="username" id="username" placeholder="Inserisci il tuo username" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <input class="form-control mb-4" type="password" name="password" id="password" placeholder="Inserisci la tua password" required>
                        </div>
                    </div>

                    <?php if (isset($templateParams["login-error"])): ?>
                    <div class="row">
                        <div class="col-12 text-start">
                            <p class="text-danger"> <?php echo $templateParams["login-error"]; ?> </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-warning w-100" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <section>
                <div class="col-12">
                    <p class="m-0">Non hai ancora un account su AllGames?</p>
                </div>
                <div class="col-12">
                    <a href="registrazione.php" class="text-warning text-decoration-none">Creane uno ora!</a>
                </div>
            </section>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
