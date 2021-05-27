<?php include(get_path('partials','head.php'));?> 
<html>
    <head>
        <script charset="utf-8" src="script.js"></script>
    </head>
    <body>
        <!-- NAVBAR -->
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div style="padding: 30px"></div>
            <h1>Login</h1>
            <form action="" method="POST" accept-charset="utf-8">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control"  value="" name="email" id="username" placeholder="Example@example.com">                    
                    </div>
                    <div class="col-sm-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control"  value="" name="password" id="password">                    
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6" style="margin-top: 30px">
                        <button type="submit" class="btn btn-primary" name="signin">Sign In</button>
                        <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                    </div>
                </div> 

            </form>
            <div style="padding: 30px"></div>
            <h1>Change  Address</h1> 
            <form>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Address..">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputVille" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="inputVille" placeholder="Pau..">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputCP" class="form-label">Code Postal</label>
                        <input type="number" class="form-control" id="inputCodePostal">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6" style="margin-top: 30px">
                        <button type="submit" class="btn btn-primary" name="change">Change Address</button>
                        <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                    </div>
                </div>
            <div style="padding: 30px"></div>
            <h1>Change Password</h1>
            <form action="" method="POST" accept-charset="utf-8">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inputNewPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control"  value="" name="password1" id="password_check" onkeyup="check();">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputPassword2" class="form-label">Comfirm Password</label>
                        <input type="password" class="form-control"  value="" name="password2" id="password_confirm" onkeyup="check();">
                    </div>
                    <div id='passwordHelpBlock' class='form-text is-invalid'></div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6" style="margin-top: 30px">
                        <button id="password-change-button" type="submit" class="btn btn-primary" name="change">Change</button>
                        <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                    </div>
                </div>
            </form>
            <div style="padding: 30px"></div>
        </form>
        </div>


        <!-- MAIN (FORM) -->
        <!-- FOOTER-->
        <?php include(get_path('partials','footer.php'));?> 
        <!-- FOOTER-->
    </body>
</html>

