<?php
/**
 * Permissions manager.
 *
 * @param null|mixed $user
 */

    function isLoggedIn() {
        return (isset($_SESSION, $_SESSION['user']));
    }

    function getPermissions($user = null) {
        return isLoggedIn() ? (int) $_SESSION['user']['type'] : 0;
    }

    function getID() {
        return isLoggedIn() ? $_SESSION['user']['id'] : null;
    }

    function getMail() {
        return isLoggedIn() ? $_SESSION['user']['mail'] : null;
    }

    function getIP() {
        return $_SERVER['REMOTE_ADDR'];
    }

    function whois() {
        return "[" . implode(" - ", [
            getIP(),
            session_id(),
            getID()
        ]) . "] ";
    }
?>
