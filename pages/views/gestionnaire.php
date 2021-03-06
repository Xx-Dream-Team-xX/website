<?php onlyForMin(User::ASSURE);?>
<!DOCTYPE html>
<html>
    <head>
        <?php include(get_path('partials','head.php'));?> 
        <title>Paneau d'intéraction</title>
        <script charset="utf-8" src="/static/js/types.js"></script>
        <script charset="utf-8" src="/static/js/manageGestionTable.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
    </head>
    <body onload="getData()">
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main d-flex justify-content-center">
            <div class="row p-5">
                <div class="col d-flex justify-content-center">
                <?php if (getPermissions() === User::GESTIONNAIRE) {?>
                    <a class="btn btn-success grow grow-1" href="/inscription" role="button">Ajouter un assuré</a>
                <?php } else if (getPermissions() === User::ADMIN) {?>
                    <a class="btn btn-success grow grow-1" href="/creation" role="button">Générer un utilisateur</a>
                <?php } else {?>
                    <a class="btn btn-danger grow grow-1" href="/contact" role="button">Retour</a>
                <?php }?>
                </div>
                <div class="col" id="search">
                    <input type="text" id="filter" class="form-control" placeholder="Rechercher" onkeyup="filterTable()">
                </div>
            </div>
            <div class="row p-2">
                <div class="table table-responsive-xl">
                    <div id="tables">
                    </div>
                </div>
            </div>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>

