<script src="/static/js/manageLogin.js" charset="utf-8"></script>
<script src="/static/js/notifications.js" charset="utf-8"></script>
<script charset="utf-8">
    function dropdown_fnc(menu){
        document.getElementById(menu).classList.toggle("show");
    }
</script>
<!-- logged in -->
<?php if(isLoggedIn()) : ?>
<nav class="navbar navbar-expand-md">
	<div class="container-fluid p-0">
		<div class="navbar-left navbar-brand px-3">
                <a href="/"><img src="/static/images/logo.png" alt="logo" class="d-inline-block align-text-top navlogo small-break-shrink"></a>
                <a class="navtitle medium-break-font" id="title" href="/"><?php echo SETTINGS['name']; ?></a> 
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02">
            <span class="material-icons nav-btn"><i class="bi bi-list"></i></span>
		</button>
		<div class="collapse navbar-collapse p-2 position-break-md" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link nav-btn" href="/messages"><span class="material-icons">chat</span><h5 class="nav-link hide-md">Messages</h5></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-btn" href="/" onclick="logout()"><span class="material-icons">logout</span><h5 class="nav-link hide-md">Se déconnecter</h5></a>
                </li>
                <li class="nav-item">
                    <div class="buttons d-flex align-items-center">
                        <span onclick="ouvrirModal()" class="modalbtn">
                            <span class="material-icons nav-btn">notifications</span>
                            <div id="notif-led" class="notif-dot"></div>
                        </span>
                        <!--<span onclick="dropdown_fnc('drop_profile')" class="dropbtn nav-btn small-break-remove-margins">-->
                        <a href="/me">
                            <span class="dropbtn nav-btn small-break-remove-margins">
                                <span class="material-icons">account_circle</span>
                                <span class="userbtn_txt"><?php echo $_SESSION['user']['last_name']?></span>
                            </span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
	</div>
</nav>

<div id="modal_notif" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col">
            <span class="modal-titre text-dark small-break-text-sm">Notifications</span>
            </div>
            <div class="col">
                <span onclick="fermerModal()" class="material-icons close-btn small-break-text-md">close</span>
            </div>
        </div>

        <hr style="margin-top:15px; margin-bottom:15px; border: 2px solid #aaaaaa;">

        <div class="modal-buttons">
            <span class="btn_modal mark-read">
                <span onclick="markNotification()">
                    <span class="material-icons">mark_email_read</span>
                    <span class="btn-text">Tout marquer comme lu</span>
                </span>
            </span>
            <span class="btn_modal mark-delete">
                <span onclick="clearNotification()">
                    <span class="material-icons">delete</span>
                    <span class="btn-text">Tout supprimer</span>
                </span>
            </span>
        </div>
        
        <hr style="margin-top:15px; margin-bottom:15px; border: 2px solid #aaaaaa;">

        <div class="notifs-content" id="notifications">

        </div>
    </div>
</div>

<!-- not logged in -->
<?php else : ?>
<div class="navbar navbar-expand-lg p-3">
    <div class="navbar_left">
        <img class="navlogo" src="/static/images/logo.png" alt="logo">
        <a class="navtitle hidden-mobile" id="title" href="/"><?php echo SETTINGS['name']; ?></a>
    </div>
    <nav class="nav_options">
        <div class="nav_links" id="links">
        </div>
    </nav>
        <a class="nav_ep" id="navbarDropdown" role="button" data-bs-toggle="dropdown" >
            <button>Login</button>
        </a>
        <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown" id="dropDownLogin">
            <form class="form-horizontal" method="post" accept-charset="UTF-8" id="loginForm" action="#">
                <li><input class="form-control login" type="email" name="email" placeholder="Email.."><br></li>
                <li><input class="form-control login" type="password" name="password" placeholder="Password.."><br></li>
                <div id='passwordHelpBlock' class='form-text is-invalid text-danger p-1'></div>
                <li><input class="btn btn-success" type="submit" name="submit" value="Login" onclick="doLogin()"></li>
            </form>
        </ul>
</div>
<?php endif; ?>

