<?php
/**
 * Permissions manager.
 *
 * @param null|mixed $user
 */

    include_once get_path('utils', 'types_utils/users.php');

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

    function getUpdatedUser() {
        $user = DB::getFromID(get_path("database", "users.json"), getID());
        if ($user) $_SESSION["user"] = (User::createUserByType($user))->getPublic();
        return isLoggedIn() ? $user : null;
    }

    /**
         * Gets interactionnable users list callbacks for map and filter
         *
         * @return array [filter, map] callbacks
         */
        function getInteractions() {
            $filter = null;
            $map = null;

            switch (getPermissions()) {
                case User::GESTIONNAIRE:

                    $filter = function($u) {

                        return (($u["type"] === User::ASSURE) && ($u["assurance"] === $_SESSION["user"]["assurance"]));
                    };

                    $map = function($u) {

                        return array(
                            'id' => $u["id"],
                            'name' => $u["last_name"] . " " . $u["first_name"],
                            'mail' => $u["mail"],
                            'type' => $u["type"],
                            'birth' => $u["birth"],
                            'declarations' => sizeof($u["declarations"]),
                            'contracts' => sizeof($u["contracts"]),
                            'sinisters' => sizeof($u["sinisters"]),
                            'actions' => sizeof($u["actions"])
                        );
                    };
                    break;
                case User::ADMIN:
                    $filter = function($u) {
                        return ($u["type"] !== User::ADMIN);
                    };
                    $map = function($u) {
                        $u = (User::createUserByType($u))->getPublic();
                        return ;
                    };
                    break;
                case User::ASSURE:
                    $filter = function($u) {
                        return (($u["type"] === User::GESTIONNAIRE) && ($u["assurance"] === $_SESSION["user"]["assurance"]));
                    };
                    $map = function($u) {
                        return array(
                            'id' => $u['id'],
                            'name' => $u["last_name"] . " " . $u["first_name"],
                            'mail' => ($u["id"]===$_SESSION["user"]["rep"]) ? $u["mail"] : false
                        );
                    };
                    break;
                default:
                $filter = function($u) {
                    return false;
                };
                    break;
            }

            return [$filter, $map];
        }
?>
