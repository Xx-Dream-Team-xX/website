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
        <div class="container-xl main">

            <?php if (getPermissions() > User::POLICE) {?><div class="col-sm-4 d-flex align-items-center flex-column my-3 container-xl">
                <a class="btn btn-primary" href="/inscription" role="button">Ajouter un utilisateur</a>
            </div><?php }?>
            <div class="row mt-3 d-flex justify-content-between">
                <div class="col-sm-8">
                    <div class="table-responsive table-dark">
                        <div id="tables">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>

