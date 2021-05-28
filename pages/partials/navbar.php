<script src="/static/js/manageLogin.js" charset="utf-8"></script>
<script src="/static/js/notifications.js" charset="utf-8"></script>
<script charset="utf-8">
    function dropdown_fnc(menu){
        document.getElementById(menu).classList.toggle("show");
    }
</script>
<!-- logged in -->
<?php if(isLoggedIn()) : ?>
<div class="navbar navbar-expand-lg">
    <div class="navbar_left">
        <a href="/"><img class="navlogo " src="/static/images/logo.png" alt="logo"></a>
        <a class="navtitle hidden-mobile" id="title" href="/"><?php echo SETTINGS['name']; ?></a>
    </div>
    
    <nav class="nav_options">
        <div class="nav_links" id="links">
            
        </div>
    </nav>
    <div class="buttons d-flex align-items-center">
        <div class="notifications d-flex justify-content-end align-items-center">
            <span onclick="ouvrirModal()" class="modalbtn">
                <span class="material-icons nav-btn">notifications</span>
                <div id="notif-led" class="notif-dot"></div>
            </span>
        </div>
        <div class="profile">
            <span onclick="dropdown_fnc('drop_profile')" class="dropbtn nav-btn">
                <span class="material-icons">account_circle</span>
                <span class="userbtn_txt">Utilisateur</span>
            </span>
            <div id="drop_profile" class="drop-content">
                <div class="drop_item">
                    <a href="/messages"><span class="material-icons">chat</span>Messages</a>
                </div>
                <div class="drop_item">
                    <a href="/me"><span class="material-icons">settings</span>Paramètres</a>
                </div>
                <div class="drop_item">
                    <a href="/auth/logoff"><span class="material-icons">logout</span>Se déconnecter</a>
                </div>
            </div>
        </div>
    </div>
    <!--<a class="nav_ep" id="logoutButton" role="button" onclick='logout();'>
        <button>Logout</button>
    </a>-->
</div>

<div id="modal_notif" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col">
            <span class="modal-titre text-dark">Notifications</span>
            </div>
            <div class="col">
                <span onclick="fermerModal()" class="material-icons close-btn">close</span>
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
<div class="navbar navbar-expand-lg">
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
            <form class="form-horizontal" method="post" accept-charset="UTF-8" id="loginForm">
                <li><input class="form-control login" type="email" name="email" placeholder="Email.."><br></li>
                <li><input class="form-control login" type="password" name="password" placeholder="Password.."><br></li>
                <div id='passwordHelpBlock' class='form-text is-invalid text-danger p-1'></div>
                <li><input class="btn btn-success" type="button" name="submit" value="Login" onclick="doLogin()"></li>
            </form>
        </ul>
</div>
<?php endif; ?>

