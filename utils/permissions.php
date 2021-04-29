<?php
/**
 * Permissions manager
 */
    function getPermissions($user = null) {
        $perm = 0;
        if (isset($_SESSION) && isset($_SESSION["user"])) {
            $perm = $_SESSION["user"]["status"];
        }
        return $perm; 
    }
?>