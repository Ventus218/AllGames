<div class="row">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    <header>
        <h2>Ricerca</h2>
    </header>
    <div class="row">
        <div class="col-12">
            <input class="form-control mb-3" type="text" name="search" id="search" placeholder="Cerca un username o una community" required>
        </div>
    </div>
    </form>
</div>