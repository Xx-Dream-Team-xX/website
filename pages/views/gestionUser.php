<?php onlyForMin(User::ASSURE);?>

<!DOCTYPE html>
<html>
    <head>
        <?php include(get_path('partials','head.php'));?> 
        <script charset="utf-8" src="/static/js/types.js"></script>
        <script charset="utf-8" src="/static/js/targetNavigation.js"></script>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageUser.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
    </head>

    <body onload="onLoad()">
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="table-responsive p-2">
                <div id="tables">
                </div>
                <div id="contrats_info" hidden>
                    <h6>Contrats de l'utilisateur</h6>
                    <div id="contrats"></div>
                </div>
                <div id="sinistres_info" hidden>
                    <h6>Sinistres de l'utilisateur</h6>
                    <div id="sinistres"></div>
                </div>
                <div id="declarations_info" hidden>
                    <h6>Déclarations de vente l'utilisateur</h6>
                    <div id="declarations"></div>
                </div>
            </div>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>

