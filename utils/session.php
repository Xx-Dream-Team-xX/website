<?php
/**
 * Permissions manager.
 *
 * @param null|mixed $user
 */
    include_once get_path('utils', 'types_utils/users.php');

    /**
     * if the current user is connected.
     *
     * @return bool
     */
    function isLoggedIn() {
        return isset($_SESSION, $_SESSION['user']);
    }

    /**
     * Extracts user type from session.
     *
     * @return bool
     */
    function getPermissions() {
        return isLoggedIn() ? (int) $_SESSION['user']['type'] : 0;
    }

    /**
     * Extracts id from session.
     *
     * @return string
     */
    function getID() {
        return isLoggedIn() ? $_SESSION['user']['id'] : null;
    }

    /**
     * Extracts email address from session.
     *
     * @return string
     */
    function getMail() {
        return isLoggedIn() ? $_SESSION['user']['mail'] : null;
    }

    /**
     * Extracts remote ip from request.
     *
     * @return string
     */
    function getIP() {
        return SETTINGS['proxy'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Fancy way for identifying request, session and user.
     *
     * @return string
     */
    function whois() {
        return '[' . implode(' - ', array(
            getIP(),
            session_id(),
            getID(),
        )) . '] ';
    }

    /**
     * Reads the database, returns an updated version of the user and updates session.
     *
     * @return array
     */
    function getUpdatedUser() {
        $user = DB::getFromID(get_path('database', 'users.json'), getID());
        if ($user) {
            $_SESSION['user'] = (User::createUserByType($user))->getProtected();
        }

        return isLoggedIn() ? $user : null;
    }

    /**
     * Gets interactionnable users list callbacks for map and filter.
     *
     * @return array [filter, map] callbacks
     */
    function getInteractions() {
        $filter = null;
        $map = null;

        switch (getPermissions()) {
            case User::GESTIONNAIRE:

                $filter = function($u) {
                    return (User::ASSURE === $u['type']) && ($u['assurance'] === $_SESSION['user']['assurance']);
                };
                $map = function($u) {
                    return array(
                        'id' => $u['id'],
                        'name' => $u['last_name'] . ' ' . $u['first_name'],
                        'mail' => $u['mail'],
                        'type' => $u['type'],
                        'birth' => $u['birth'],
                        'declarations' => sizeof($u['declarations']),
                        'contracts' => sizeof($u['contracts']),
                        'sinisters' => sizeof($u['sinisters'])
                    );
                };

                break;
            case User::ADMIN:

                $map = function($u) {
                    return (User::createUserByType($u))->getPublic();
                };

                break;
            case User::ASSURE:
                $filter = function($u) {
                    return (User::GESTIONNAIRE === $u['type']) && ($u['assurance'] === $_SESSION['user']['assurance']);
                };
                $map = function($u) {
                    return array(
                        'id' => $u['id'],
                        'name' => $u['last_name'] . ' ' . $u['first_name'],
                        'type' => $u['type'],
                        'mail' => ($u['id'] === $_SESSION['user']['rep']) ? $u['mail'] : false,
                    );
                };

                break;
            default:
            $filter = function($u) {
                return false;
            };

                break;
        }

        return array($filter, $map);
    }
?>
