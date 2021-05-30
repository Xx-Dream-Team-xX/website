<!-- Oh non, une erreur s'est produite. -->
<?php
    http_response_code(404);
?>
<html>
    <head>
        <?php include(get_path("partials", "head.php")); ?>
        <script src="/static/js/manageLogin.js" charset="utf-8"></script>
    </head>
    <script charset="utf-8">
        function move() {
            let a = document.getElementById("find-me");
            let t = document.getElementById("t").getBoundingClientRect();
            a.style.top = Math.floor(Math.random() * t.width - 50) + "px";
            a.style.left = Math.floor(Math.random() * t.width - 50) + "px";
        }
    </script> 
    <body onload="setTimeout(() => {  move(); }, 100);">
        <?php include(get_path("partials", "navbar.php")); ?>
        <a id="find-me" href="/" onclick="logout()"></a>
        <div class="here top" id="t" onclick="move()"></div>
        <img class="xkcd" src="https://imgs.xkcd.com/comics/not_available.png" alt="404"/>
        <div class="here bottom" onclick="move()"></div>
        <?php include(get_path("partials", "footer.php")); ?>
    </body>
    <style type="text/css" media="screen">
        .here {
            width: 100vw;
            height: calc(50vh - 100px);
        }

        #find-me {
            width: 50px;
            height: 50px;
            background-color: rgba(255,0,0,0);
            display: block;
            position: fixed;

        }

        .xkcd {
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
