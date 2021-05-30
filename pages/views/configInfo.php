<?php include get_path('partials', 'head.php'); ?>
<!DOCTYPE html>
<html>

    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/targetNavigation.js"></script>
        <title>Configuration Serveur</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <?php if (User::ADMIN == getPermissions()) { ?>
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">

                <div class="row pb-3 g-3">
                    <h5>Configuration</h5>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Nom du service</p>
                        <input class="form-control p-1" id="start" value="<?php echo SETTINGS['name']; ?>" disabled>
                    </div>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Version</p>
                        <input class="form-control p-1" id="start" value="<?php echo SETTINGS['version']; ?>" disabled>
                    </div>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Adresse du service</p>
                        <input class="form-control p-1" id="start" value="<?php echo SETTINGS['url']; ?>" disabled>
                    </div>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Derrière un proxy</p>
                        <input class="form-control p-1" id="start" value="<?php echo boolval(SETTINGS['proxy']) ? 'true' : 'false'; ?>" disabled>
                    </div>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Niveau de log</p>
                        <input class="form-control p-1" id="start" value="<?php echo SETTINGS['logger']; ?>" disabled>
                    </div>
                </div><?php include get_path('partials', 'head.php'); ?>
            </div>
            <?php } ?>
        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>
