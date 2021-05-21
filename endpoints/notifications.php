<?php
    /**
     * List notifications, clear notifications, remove notifications.
     */
    include_once get_path('utils', 'types_utils/users.php');

    /**
     * Gets available recipients for messaging.
     */

    if (isLoggedIn()) {
        $user = getUpdatedUser();

        switch (get_final_point()) {
            case 'list':
                send_json($user["notifications"]);
                break;

            case 'read':
                $user = User::createUserByType($user);
                $user->markNotificationsAsRead(isset($_POST['id']) ? $_POST["id"] : null);
                DB::setObject(get_path("database", "users.json"), $user->getAll());
                send_json(($_SESSION["user"]["notifications"] !== $user->getNotifications()));
                break;

            case 'clear':
                $user = User::createUserByType($user);
                $user->clearNotification(isset($_POST['id']) ? $_POST["id"] : null);
                DB::setObject(get_path("database", "users.json"), $user->getAll());
                send_json(($_SESSION["user"]["notifications"] !== $user->getNotifications()));
                break;

            default:
                notfound();

                break;
        }
    }

?>