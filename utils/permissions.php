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
        $perm = 0;
        if (isLoggedIn()) {
            $perm = (int) $_SESSION['user']['type'];
        }

        return $perm;
    }

    function getId() {
        if (isLoggedIn()) {
            return $_SESSION['user']['id'];
        } else {
            return false;
        }
    }

    function getMail() {
        if (isLoggedIn()) {
            return $_SESSION['user']['mail'];
        } else {
            return false;
        }
    }
?>
