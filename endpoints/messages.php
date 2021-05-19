<?php
    /**
     * List conversations, show conversation, get messages, send messages
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/conversation.php');

    ConversationManager::setFolderPath(get_path("database", "messages/"));

    /**
     * Gets available recipients for messaging
     *
     * @return void
     */
    function getRecipients() {
        $users = DB::getAll(get_path("database", "users.json"));
        $filter = null;

        // NIQUE
        // switch (getPermissions()) {
        //     case User::ASSURE:
        //         $filter = function($u) {
        //             return (($u["type"] === User::GESTIONNAIRE )&& ($u["assurance"] === $_SESSION["user"]["assurance"]));
        //         };
        //         break;
        //     case User::GESTIONNAIRE:
        //         $filter = function($u) {
        //             return (((($u["type"] === User::ASSURE) || ($u["type"] === User::GESTIONNAIRE)) && ($u["assurance"] === $_SESSION["user"]["assurance"])) || ($u["type"] === User::ADMIN));
        //         };
        //     case User::POLICE:
        //         $filter = function($u) {
        //             return ($u["type"] === User::ADMIN);
        //         };
        //     default:
        //         break;
        // }

        $users = array_filter($users, $filter);

        return array_map(function($u) {
            return array(
                'id' => $u['id'],
                'name' => $u["last_name"] . " " . $u["first_name"],
                'type' => $u["type"]
            );
        }, $users);
    }

    if (isLoggedIn()) {
        $user = getUpdatedUser();

        switch (get_final_point()) {
            case 'list':
                send_json(array_filter(DB::getAll(get_path("database", "conversations.json")), function($m) {
                    return in_array($_SESSION["user"]["id"], $m["people"]);
                }));
                break;

            case 'send':
                if (isset($_POST["id"], $_POST["content"])) {

                    $c = DB::getFromID(get_path("database", "conversations.json"), $_POST["id"]);

                    if ($c && ($c = new Conversation($c))) {
                        $m = new Message(array(
                            'sender' => $user['id'],
                            'content' => $_POST['content']
                        ));

                        $c->setLastMessage($m);

                        DB::setObject($c->getPath(), $m->getAll(), true);
                        DB::setObject(get_path("database", "conversations.json"), $c->getAll());

                        send_json($m->getAll());
                        // TODO : send notification to subscribers
                    }
                }
                break;
            case 'new':
                if (isset($_POST["recipient"], $_POST["content"])) {
                    
                }
                break;
            case 'add':
                break;

            case 'remove':
                break;

            case 'recipients':
                send_json(getRecipients());
                break;

            default:
                notfound();
                break;
        }
    }
    
?>