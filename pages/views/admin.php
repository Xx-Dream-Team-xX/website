<?php
    onlyFor(User::ADMIN);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include(get_path('partials','head.php'));?>
    <title>Panneau Admin</title>
    <script src="/static/js/manageDates.js" charset="utf-8"></script>
    <script src="/static/js/addUser.js" charset="utf-8"></script>
</head>
<body>
    <?php include(get_path('partials','navbar.php'));?>
    <!-- MAIN (FORM) -->

    <div class="row main center">
        
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check nohover" name="btnradio" id="btnradio1" autocomplete="off"<?php if (!isset($_GET["type"])) echo "checked";?>>
            <label class="btn btn-outline-primary" for="btnradio1">Logs (last)</label>

            <input type="radio" class="btn-check nohover" name="btnradio" id="btnradio2" autocomplete="off"<?php if (isset($_GET["type"]) && $_GET["type"] === "smart") echo "checked";?>>
            <label class="btn btn-outline-primary" for="btnradio2">Logs (smart)</label>

            <input type="radio" class="btn-check nohover" name="btnradio" id="btnradio3" autocomplete="off"<?php if (isset($_GET["type"]) && $_GET["type"] === "full") echo "checked";?>>
            <label class="btn btn-outline-primary" for="btnradio3">Logs (full)</label>
        </div>

        <pre><?php
            if (isset($_GET['type']) && $_GET["type"] === "full") {
                htmlspecialchars(readfile($_SERVER["logger"]->today_file()));
            } else if (isset($GET['type']) && $_GET["type"] === "smart") {

            } else {

            }
            ?>
        </pre>
    </div>
    

    <!-- MAIN (FORM) -->
    <?php include(get_path('partials','footer.php'));?>
</body>

</html>
