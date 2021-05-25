<?php

    /**
     * List conversations, show conversation, get messages, send messages.
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/conversation.php');

    ConversationManager::setFolderPath(get_path('database', 'messages/'));

    /**
     * Gets available recipients for messaging.
     */
    function getRecipients() {
        $users = array_filter(DB::getAll(get_path('database', 'users.json')), function($u) {
            return ($u['id'] !== getID());
        });
        $filter = null;

        switch (getPermissions()) {
            case User::ASSURE:
                $filter = function($u) {
                    return (User::GESTIONNAIRE === $u['type']) && ($u['assurance'] === $_SESSION['user']['assurance']);
                };
                break;
            case User::GESTIONNAIRE:
                $filter = function($u) {
                    return (((User::ASSURE === $u['type']) || (User::GESTIONNAIRE === $u['type'])) && ($u['assurance'] === $_SESSION['user']['assurance'])) || (User::ADMIN === $u['type']);
                };
                break;
            case User::POLICE:
                $filter = function($u) {
                    return User::ADMIN === $u['type'];
                };
                break;
            default:
                break;
        }
        $users = array_values(array_filter($users, $filter));
        return array_map(function($u) {
            return array(
                'id' => $u['id'],
                'name' => $u['last_name'] . ' ' . $u['first_name'],
                'type' => $u['type'],
            );
        }, $users);
    }

    /**
     * Sends push notification to conversation subscribers
     *
     * @param array $send Sender data
     * @param array $dest Array of recipients id
     * @param string $id Conversation id
     * @return void
     */
    function messageNotification(array $send, array $dest, string $id) {
        $send = User::createUserByType($send);

        foreach ($dest as $d) {

            if ($d === $send->getID()) continue;

            $d = User::createUserByType(DB::getFromID(get_path("database", "users.json"), $d));

            $d->pushNotification('Nouveau message', $send->getName()[0] . " vous a envoyé un message", SETTINGS["url"] . "/messages/" . $id );
            $d->addConversation($id);
            DB::setObject(get_path("database", "users.json"), $d->getAll());
        }
    }

    if (isLoggedIn()) {

        switch (get_final_point()) {
            case 'list':
                $user = getUpdatedUser();
                send_json(array_map(function($m) {
                    return array_merge($m, array(
                        'unread' => in_array($m["id"], $_SESSION["user"]["conversations"])
                    ));
                }, array_values(array_filter(DB::getAll(get_path('database', 'conversations.json')), function($m) {
                    return in_array($_SESSION['user']['id'], $m['people']);
                }))));

                break;

            case 'send':
                if (isset($_POST['id'], $_POST['content'])) {
                    $c = DB::getFromID(get_path('database', 'conversations.json'), $_POST['id']);
                    $user = getUpdatedUser();
                    if ($c && ($c = new Conversation($c))) {

                        if (!in_array(getID(), $c->getPeople())) return;

                        $m = new Message(array(
                            'sender' => $user['id'],
                            'content' => $_POST['content'],
                        ));

                        $c->setLastMessage($m);

                        DB::setObject($c->getPath(), $m->getAll(), true);
                        DB::setObject(get_path('database', 'conversations.json'), $c->getAll());

                        messageNotification($user, $c->getPeople(), $c->getID());

                        send_json($m->getAll());
                    }
                }

                break;
            case 'new':
                if (isset($_POST['recipient'], $_POST['content'])) {
                    $user = getUpdatedUser();
                    $found = false;
                    foreach (getRecipients() as $r) {
                        if ($_POST['recipient'] === $r['id']) {
                            $found = true;
                        }
                    }

                    if ($found) {
                        $c = new Conversation(array(
                            "people" => array(
                                getID(),
                                $_POST['recipient']
                            ),
                            "message" => (new Message(array(
                                'sender' => getID(),
                                'content' => "Nouvelle conversation"
                            )))->getAll(),
                            "title" => $_POST['title'] ?? null
                        ));

                        DB::setObject(get_path("database", "conversations.json"), $c->getAll(), true);
                        DB::setObject($c->getPath(), (new Message(array(
                            'sender' => getID(),
                            'content' => $_POST['content']
                        )))->getAll(), true);

                        messageNotification($user, $c->getPeople(), $c->getID());

                        send_json($c->getAll());
                    }
                }

                break;
            case 'add':

                if (isset($_POST["conv"], $_POST["dest"])) {

                    $c = DB::getFromID(get_path('database', 'conversations.json'), $_POST['conv']);
                    if ($c && $c = new Conversation($c)) {
                        $user = getUpdatedUser();
                        if (!in_array(getID(), $c->getPeople())) return;

                        if (!in_array($_POST["dest"], $c->getPeople())) {
                            $found = false;
                            foreach (getRecipients() as $r) {
                                if ($_POST['dest'] === $r['id']) {
                                    $found = true;
                                }
                            }
                            if ($found) {
                                
                                $c->addPeople($_POST["dest"]);

                                $d = User::createUserByType(DB::getFromID(get_path("database", "users.json"), $_POST["dest"]));

                                $d->pushNotification('Nouvelle conversation', "Vous avez été ajouté.es à un groupe", SETTINGS["url"] . "/messages/" . $_POST["conv"]);
                                $d->addConversation($_POST["conv"]);

                                DB::setObject(get_path("database", "users.json"), $d->getAll());
                                DB::setObject(get_path('database', 'conversations.json'), $c->getAll());

                                send_json($c->getAll());
                            }
                        }
                    }
                    
                }
                break;

            case 'recipients':
                send_json(getRecipients());
                break;
            case 'get':
                if (isset($_POST["id"])) {
                    $c = DB::getFromID(get_path('database', 'conversations.json'), $_POST['id']);
                    if ($c && $c = new Conversation($c)) {
                        $user = getUpdatedUser();
                        if (!in_array(getID(), $c->getPeople())) return;

                        $user = User::createUserByType($user);
                        $user->removeConversation($c->getID());

                        DB::setObject(get_path("database", "users.json"), $user->getAll());
                        return send_json(DB::getAll($c->getPath()));
                    }
                }
                send_json(array());
                break;
            default:
                notfound();

                break;
        }
    }

?>
