<?php include get_path('partials', 'head.php'); ?>
<!DOCTYPE html>
<html>

    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/parseUsers.js"></script>
        <script charset="utf-8" src="/static/js/manageMessages.js"></script>
        <title>Chat</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <form action="" method="POST" accept-charset="utf-8">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" value="" name="email" id="username"
                            placeholder="Example@example.com">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" value="" name="password" id="password">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6" style="margin-top: 30px">
                        <button type="submit" class="btn btn-primary" name="signin">Sign In</button>
                        <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                    </div>
                </div>

            </form>
        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>
