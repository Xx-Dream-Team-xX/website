<?php
    http_response_code(404);
?>
<!-- Oh non, une erreur s'est produite. -->
<?php
    http_response_code(404);
?>
<html>
    <head>
        <?php include(get_path("partials", "head.php")); ?>
        <script src="/static/js/manageLogin.js" charset="utf-8"></script>
    </head>
    <body>
        <div class="top"></div>
        <img src="https://imgs.xkcd.com/comics/not_available.png" alt="404"/>
        <div class="bottom"></div>
    </body>
    <style type="text/css" media="screen">
        div {
            width: 100vw;
            height: 50vh;
        }

        img {
            position: absolute;
            width: 300px;
            height: 300px;
            top: calc(50vh - 230px);
            left: calc(50vw - 150px);
        }

        .top {
            background-color: black !important;
        }
        .botton {
            background-color: white !important;
        }
    </style>
</html>
