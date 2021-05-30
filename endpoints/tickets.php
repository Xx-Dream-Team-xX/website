<?php

    /**
     * List tickets, show ticket, get messages, send messages.
     * Very similar to messages.php
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/conversation.php');
    include_once get_path("utils", "files.php");


    ConversationManager::setFolderPath(get_path('database', 'tickets/'));

    /**
     * Gets available recipients for tickets.
     */
    function getRecipients() {
        $users = array_values(array_filter(DB::getAll(get_path('database', 'users.json')), function($u) {
            return ($u['id'] !== getID());
        }));

        if (getPermissions() !== User::ADMIN) {
            $users = array_values(array_filter($users, function($u) {
                return User::ADMIN === $u['type'];
            }));
        }

        return array_map(function($u) {
            return array(
                'id' => $u['id'],
                'name' => $u['last_name'] . ' ' . $u['first_name'],
                'type' => $u['type'],
            );
        }, $users);
    }

    /**
     * Sends a notification to ticket subscribers
     *
     * @param array $send Sender data
     * @param array $dest List of recipients id
     * @param string $id Ticket id
     * @return void
     */
    function messageNotification(array $send, array $dest, string $id) {
        $send = User::createUserByType($send);

        foreach ($dest as $d) {

            if ($d === $send->getID()) continue;

            $d = User::createUserByType(DB::getFromID(get_path("database", "users.json"), $d));

            if (!in_array($id, $d->getConversations())) $d->pushNotification('Nouvelle activité', $send->getName()[0] . " a mis à jour le ticket", "/tickets/" . $id );
            DB::setObject(get_path("database", "users.json"), $d->getAll());
        }
    }

    if (isLoggedIn()) {
        

        switch (get_final_point()) {
            case 'list':
                send_json(array_values(array_filter(DB::getAll(get_path('database', 'tickets.json')), function($m) {
                    return in_array($_SESSION['user']['id'], $m['people']);
                })));
                break;

            case 'send':
                if (isset($_POST['id'], $_POST['content']) && (strlen(trim($_POST["content"])) > 0)) {
                    $c = DB::getFromID(get_path('database', 'tickets.json'), $_POST['id']);

                    if ($c && ($c = new Conversation($c))) {

                        $user = getUpdatedUser();

                        if (!in_array(getID(), $c->getPeople())) return;

                        if (checkUploadedFiles()) {
                            $files = saveUploadedFiles();
                        } else {
                            $files = [];
                        }

                        $m = new Message(array(
                            'sender' => $user['id'],
                            'content' => $_POST['content'],
                            'files' => $files
                        ));

                        $c->setLastMessage($m);
                        $c->setStatus(Conversation::TICKET_OPEN);

                        DB::setObject($c->getPath(), $m->getAll(), true);
                        DB::setObject(get_path('database', 'tickets.json'), $c->getAll());

                        messageNotification($user, $c->getPeople(), $c->getID());

                        send_json($m->getAll());
                    }
                }

                break;
            case 'new':
                if (getPermissions() < User::ADMIN && isset($_POST['recipient'], $_POST['content'], $_POST['title'])  && (strlen(trim($_POST["content"])) > 0)  && (strlen(trim($_POST["title"])) > 0)) {

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
                                $_POST['recipient'],
                                getID()
                            ),
                            "message" => (new Message(array(
                                'sender' => getID(),
                                'content' => "Nouveau ticket"
                            )))->getAll(),
                            "type" => Conversation::TICKET_OPEN,
                            "title" => $_POST['title'] ?? null
                        ));

                        DB::setObject(get_path("database", "tickets.json"), $c->getAll(), true);
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

                return send_json("disabled");
                if ((getPermissions() === User::ADMIN) && isset($_POST["ticket"], $_POST["dest"])) {

                    $c = DB::getFromID(get_path('database', 'tickets.json'), $_POST['ticket']);
                    if ($c && $c = new Conversation($c)) {

                        if (!in_array(getID(), $c->getPeople())) return;

                        if (!in_array($_POST["dest"], $c->getPeople())) {
                            $found = DB::getFromID(get_path("database", "users.json"), $_POST["dest"]);

                            if ($found) {
                                
                                $c->addPeople($_POST["dest"]);

                                $d = User::createUserByType($found);

                                $d->pushNotification('Ticket', "Vous avez été ajouté.es à un ticket", "/tickets/" . $_POST["ticket"]);

                                DB::setObject(get_path("database", "users.json"), $d->getAll());
                                DB::setObject(get_path('database', 'tickets.json'), $c->getAll());

                                send_json($c->getAll());
                            }
                        }
                    }
                    
                }
                break;
            case 'recipients':
                send_json(getRecipients());
                break;

            case 'close':
                if ((getPermissions() === User::ADMIN) && isset($_POST["id"])) {
                    
                    $c = DB::getFromID(get_path('database', 'tickets.json'), $_POST['id']);
                    if ($c && $c = new Conversation($c)) {

                        if (!in_array(getID(), $c->getPeople())) return;

                        $c->setStatus(Conversation::TICKET_CLOSED);
                        DB::setObject(get_path("database", "tickets.json"), $c->getAll());

                        send_json(true);
                    }
                }

                break;
                
            case 'get':
                if (isset($_POST["id"])) {
                    $c = DB::getFromID(get_path('database', 'tickets.json'), $_POST['id']);
                    if ($c && $c = new Conversation($c)) {

                        if (!in_array(getID(), $c->getPeople())) return;

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
