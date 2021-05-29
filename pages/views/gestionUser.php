<!DOCTYPE html>
<html>
    <head>
        <?php include(get_path('partials','head.php'));?> 
        <script charset="utf-8" src="/static/js/targetNavigation.js"></script>
        <script charset="utf-8" src="/static/js/manageUser.js"></script>
    </head>

    <body onload="onLoad()">
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="row mt-3"><div class="col-4">
                <div class="table-responsive table-dark">
                    <table class="table table-borderless">
                        <thead class="table-dark" id="userInfo">
                        </thead>
                    </table>
                </div>
            </div></div>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>

