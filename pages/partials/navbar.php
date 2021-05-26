<script src="/static/js/manageLogin.js" charset="utf-8"></script>

<!-- logged in -->
<?php if(isLoggedIn()) : ?>
<div class="navbar navbar-expand-lg">
    <div class="navbar_left">
        <img class="navlogo" src="/static/images/logo.png" alt="logo">
        <a class="navtitle" id="title" href="#">CAR-A-OK</a>
    </div>
    <nav class="nav_options">
        <div class="nav_links" id="links">
        </div>
    </nav>
    <a class="nav_ep" id="logoutButton" role="button" onclick='window.location.href="/auth/logoff"';>
        <button>Logout</button>
    </a>
</div>
<!-- not logged in -->
<?php else : ?>
<div class="navbar navbar-expand-lg">
    <div class="navbar_left">
        <img class="navlogo" src="/static/images/logo.png" alt="logo">
        <a class="navtitle" id="title" href="#">CAR-A-OK</a>
    </div>
    <nav class="nav_options">
        <div class="nav_links" id="links">
        </div>
    </nav>
        <a class="nav_ep" id="navbarDropdown" role="button" data-bs-toggle="dropdown" >
            <button>Login</button>
        </a>
        <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown" id="dropDownLogin">
            <form class="form-horizontal" method="post" accept-charset="UTF-8" id="loginForm">
                <li><input class="form-control login" type="email" name="email" placeholder="Email.."><br></li>
                <li><input class="form-control login" type="password" name="password" placeholder="Password.."><br></li>
                <div id='passwordHelpBlock' class='form-text is-invalid'></div>
                <li><input class="btn btn-success" type="button" name="submit" value="Login" onclick="doLogin()"></li>
            </form>
        </ul>
</div>
<?php endif; ?>

