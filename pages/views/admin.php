<?php
    onlyFor(User::ADMIN);
?>

<!DOCTYPE html>
<html>

    <head>
        <?php include get_path('partials', 'head.php'); ?>
        <title>Panneau Admin</title>
        <script src="/static/js/manageDates.js" charset="utf-8"></script>
        <script src="/static/js/addUser.js" charset="utf-8"></script>
        <script>
            function updateLogType(button) {
                window.location.href = `/admin?type=${button.value}`;
            }

            function gotopage(button) {
                window.location.href = `/${button.value}`;
            }

            function updateScroll() {
                var element = document.getElementById("logBox");
                element.scrollTop = element.scrollHeight;
            }

            function waitRefresh() {
                setTimeout(function() {
                    window.location.reload(1);
                }, 5000);
            }
        </script>
    </head>

    <body onload="updateScroll()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="row g-3 mb-3">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="button" class="btn-check nohover" value="gestionnaire" name="gestionnaire" id="gestionnaire" onclick="gotopage(this)" autocomplete="off">
                <label class="btn btn-outline-primary" for="gestionnaire">Liste des Utilisateurs</label>
                <input type="button" class="btn-check nohover" value="creation" name="creation" id="creation" onclick="gotopage(this)" autocomplete="off">
                <label class="btn btn-outline-primary" for="creation">Créer un utilisateur privilégié</label>
                <input type="button" class="btn-check nohover" value="assurances" name="assurances" id="assurances" onclick="gotopage(this)" autocomplete="off">
                <label class="btn btn-outline-primary" for="assurances">Gestion des Assurances</label>
                <input type="button" class="btn-check nohover" value="tickets" name="tickets" id="tickets" onclick="gotopage(this)" autocomplete="off">
                <label class="btn btn-outline-primary" for="tickets">Tickets</label>
                <input type="button" class="btn-check nohover" value="config" name="config" id="config" onclick="gotopage(this)" autocomplete="off">
                <label class="btn btn-outline-primary" for="config">Configuration du Serveur</label>
            </div>
        </div>
        <div class="container-xl main center">
            <div class="row g-3 bg-dark text-white border border-2 rounded m-3 mh-100 overflow-scroll" id="logBox" style="height: 65vh;" <?php if (!isset($_GET['type'])) echo "hidden";?>>
                <pre class="mt-2"><?php
            if (isset($_GET['type']) && 'full' === $_GET['type']) {
                htmlspecialchars(readfile($_SERVER['logger']->today_file()));
            } elseif (isset($_GET['type']) && 'smart' === $_GET['type']) {
                $file = file($_SERVER['logger']->today_file());
                for ($i = max(0, count($file) - 50); $i < count($file); ++$i) {
                    $spLine = htmlspecialchars($file[$i]);
                    preg_match('/(?<=\[)([0-9])+?(?=\])/', $spLine, $matches);
                    switch ($matches[0]) {
                        case '2':
                            $color = 'text-secondary';

                            break;
                        case '3':
                            $color = 'text-info';

                            break;
                        case '4':
                            $color = 'text-white';

                            break;
                        case '5':
                            $color = 'text-danger';

                            break;
                        default:
                            $color = 'text-primary';

                            break;
                    }
                    echo '<spawn class="' . $color . '">' . $spLine;
                }
            } elseif (isset($_GET['type']) && 'last' === $_GET['type']) {
                $file = file($_SERVER['logger']->today_file());
                for ($i = max(0, count($file) - 50); $i < count($file); ++$i) {
                    echo htmlspecialchars($file[$i]);
                }
                echo ' <script>waitRefresh()</script>';
            }

            ?>
        </pre>
            </div>
            <div class="row g-3 mb-3">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check nohover" value="last" name="btnradio" id="btnradio1" onclick="updateLogType(this)" autocomplete="off" <?php if (isset($_GET['type']) && 'smart' === $_GET['type']) {
                echo 'checked';
            }?>>
                    <label class="btn btn-outline-primary" for="btnradio1">Logs (realtime)</label>

                    <input type="radio" class="btn-check nohover" value="smart" name="btnradio" id="btnradio2" onclick="updateLogType(this)" autocomplete="off" <?php if (isset($_GET['type']) && 'smart' === $_GET['type']) {
                echo 'checked';
            }?>>
                    <label class="btn btn-outline-primary" for="btnradio2">Logs (smart)</label>

                    <input type="radio" class="btn-check nohover" value="full" name="btnradio" id="btnradio3" onclick="updateLogType(this)" autocomplete="off" <?php if (isset($_GET['type']) && 'full' === $_GET['type']) {
                echo 'checked';
            }?>>
                    <label class="btn btn-outline-primary" for="btnradio3">Logs (raw)</label>
                </div>
            </div>
            <div class="row g-3 mb-3 text-center">
                <h5>Légende</h5>
                <p class="h6 "><span class="text-primary p-3">Accès</span><span class="text-secondary p-3">Basiques</span><span class="text-info p-3">Actions</span><span class="text-dark p-3">Admin</span><span class="text-danger p-3">Erreurs</span></p>
            </div>
        </div>


        <!-- MAIN (FORM) -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>
