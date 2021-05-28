<?php
    /**
     * Verification submission, approval, list
     */

    include_once(get_path("utils", "types_utils/verification.php"));
    
    if (isLoggedIn() && (getPermissions() !== User::POLICE)) {
        switch (get_final_point()) {
            case 'list':
                $verifications = DB::getAll(get_path("database", "verifications.json"));

                $filter = null;

                switch (getPermissions()) {
                    case User::GESTIONNAIRE:
                        $filter = function($v) {
                            return ($v['assurance'] === $_SESSION["user"]["assurance"]);
                        };
                        break;
                    case User::ASSURE:
                        $filter = function($v) {
                            return ($v["owner"] === getID());
                        };
                    default:
                        break;
                }

                send_json(array_values(array_filter($verifications, $filter)));
                break;
            case 'get':
                if (isset($_POST['id'])) {
                    $v = DB::getFromID(get_path("database", "verifications.json"), $_POST['id']);
                    if ($v && $v = new Verification($v)) {
                        switch (getPermissions()) {
                            case User::GESTIONNAIRE:
                                if ($v->getAssurance() === $_SESSION["user"]["assurance"]) {
                                    send_json($v->getAll());
                                }
                                break;
                            case User::ASSURE:
                                if ($v->getOwner() === getID()) {
                                    send_json($v->getAll());
                                }
                                break;
                            case User::ADMIN:
                                send_json($v->getAll());
                            default:
                                break;
                        }
                    }
                }
                break;
            case 'reject':
            case 'accept':
                if (isset($_POST['id'])) {
                    $allowed = false;

                    $v = DB::getFromID(get_path("database", "verifications.json"), $_POST['id']);
                    if ($v && $v = new Verification($v)) {
                        switch (getPermissions()) {
                            case User::GESTIONNAIRE:
                                $allowed = ($v->getAssurance() === $_SESSION["user"]["assurance"]);
                                break;
                            case User::ADMIN:
                                $allowed = true;
                            default:
                                break;
                        }

                        if ($allowed && ($v->getStatus() === Verification::PENDING)) {
                            $user = DB::getFromID(get_path("database", "users.json"), $v->getOwner());
                            if ($user) {
                                if (get_final_point() === 'accept') {

                                    $user = new UserAssure(array_merge($user, $v->getContent()["raw"]));
                                    $v->accept(getID());
                                    $user->pushNotification('Compte mis à jour', 'Vos informations personnelles ont été mises à jour', "/me");

                                    DB::setObject(get_path("database", "users.json"), $user->getAll());
                                    DB::setObject(get_path("database", "verifications.json"), $v->getAll());
                                } else {
                                    $user = new UserAssure($user);

                                    $v->reject(getID(), $_POST["comment"] ?? null);
                                    $user->pushNotification('Vérification rejetée', "Votre demande de changement d'informations a été rejetée: " . ((isset($_POST["comment"])) ? htmlspecialchars($_POST["comment"]) : "Documents invalides"), "/me");

                                    DB::setObject(get_path("database", "users.json"), $user->getAll());
                                    DB::setObject(get_path("database", "verifications.json"), $v->getAll());
                                    
                                }

                                send_json(true);
                            }
                        }
                    }
                }
                break;
            default:
                break;
        }
    }
?>