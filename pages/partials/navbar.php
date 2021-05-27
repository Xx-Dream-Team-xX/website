<script src="/static/js/manageLogin.js" charset="utf-8"></script>
<script src="/static/js/notifications.js" charset="utf-8"></script>

<!-- logged in -->
<?php if(isLoggedIn()) : ?>
<div class="navbar navbar-xpand-lg">
    <div class="navbar_left">
        <img class="navlogo hidden-mobile" src="/static/images/logo.png" alt="logo">
        <a class="navtitle" id="title" href="#">CAR-A-OK</a>
    </div>

    <div class="notifications">
        <span onclick="ouvrirModal()" class="modalbtn">
            <span class="material-icons">notifications</span>
        </span>
    </div>
    <nav class="nav_options">
        <div class="nav_links" id="links">
        </div>
    </nav>
    <a class="nav_ep" id="logoutButton" role="button" onclick='window.location.href="/auth/logoff"';>
        <button>Logout</button>
    </a>
</div>

<div id="modal_notif" class="modal">
    <div class="modal-content">

        <span class="modal-titre">Notifications</span>
        <span onclick="fermerModal()" class="material-icons close">close</span>

        <hr style="margin-top:15px; margin-bottom:15px; border: 2px solid #aaaaaa;">

        <div class="modal-buttons">
            <span class="btn_modal mark-read">
                <span href="#">
                    <span class="material-icons">mark_email_read</span>
                    <span class="btn-text">Tous marquer comme lu</span>
                </span>
            </span>
            <span class="btn_modal mark-not-read">
                <span href="#">
                    <span class="material-icons">mark_email_unread</span>
                    <span class="btn-text">Tous marquer comme non lu</span>
                </span>
            </span>
            <span class="btn_modal mark-delete">
                <span href="#">
                    <span class="material-icons">delete</span>
                    <span class="btn-text">Tous supprimer</span>
                </span>
            </span>
        </div>
        
        <hr style="margin-top:15px; margin-bottom:15px; border: 2px solid #aaaaaa;">

        <div class="notifs-content">

            <div class="modal_item lu">
                <div class="left-side">
                    <span class="material-icons">mark_email_read</span>
                </div>
                <div class="right-side">
                    <div class="top-side">
                        <div class="msg_title">
                            <span>Titre1</span>
                        </div>
                    </div>
                    <div class="bottom-side">
                        <div class="user_msg">
                            <span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                        </div>
                        <div class="del_msg">
                            <span class="material-icons">delete</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal_item non-lu">
                <div class="left-side">
                    <span class="material-icons">mark_email_unread</span>
                </div>
                <div class="right-side">
                    <div class="top-side">
                        <div class="msg_title">
                            <span>Titre2</span>
                        </div>
                    </div>
                    <div class="bottom-side">
                        <div class="user_msg">
                            <span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                        </div>
                        <div class="del_msg">
                            <span class="material-icons">delete</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal_item non-lu">
                <div class="left-side">
                    <span class="material-icons">mark_email_unread</span>
                </div>
                <div class="right-side">
                    <div class="top-side">
                        <div class="msg_title">
                            <span>Titre2</span>
                        </div>
                    </div>
                    <div class="bottom-side">
                        <div class="user_msg">
                            <span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                        </div>
                        <div class="del_msg">
                            <span class="material-icons">delete</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal_item non-lu">
                <div class="left-side">
                    <span class="material-icons">mark_email_unread</span>
                </div>
                <div class="right-side">
                    <div class="top-side">
                        <div class="msg_title">
                            <span>Titre2</span>
                        </div>
                    </div>
                    <div class="bottom-side">
                        <div class="user_msg">
                            <span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                        </div>
                        <div class="del_msg">
                            <span class="material-icons">delete</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal_item lu">
                <div class="left-side">
                    <span class="material-icons">mark_email_read</span>
                </div>
                <div class="right-side">
                    <div class="top-side">
                        <div class="msg_title">
                            <span>Titre1</span>
                        </div>
                    </div>
                    <div class="bottom-side">
                        <div class="user_msg">
                            <span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                        </div>
                        <div class="del_msg">
                            <span class="material-icons">delete</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- not logged in -->
<?php else : ?>
<div class="navbar navbar-expand-lg">
    <div class="navbar_left">
        <img class="navlogo" src="/static/images/logo.png" alt="logo">
        <a class="navtitle" id="title" href="/">CAR-A-OK</a>
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

