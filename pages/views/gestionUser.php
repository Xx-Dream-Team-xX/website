<?php include(get_path('partials','head.php'));?> 
<html>
    <script charset="utf-8" src="/static/js/manageUser.js"></script>
    <body onload="onLoad()">
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="row mt-3"><div class="col-4">
                <div class="table-responsive table-dark">
                    <table class="table table-borderless">
                        <thead id="userInfo">
                        </thead>
                    </table>
                </div>
            </div></div>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>

