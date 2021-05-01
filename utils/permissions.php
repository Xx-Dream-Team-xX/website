<?php
/**
 * Permissions manager.
 *
 * @param null|mixed $user
 */
    function getPermissions($user = null) {
        $perm = 0;
        if (isset($_SESSION, $_SESSION['user'])) {
            $perm = $_SESSION['user']['status'];
        }

        return $perm;
    }
?>
