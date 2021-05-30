<?php
    onlyForMin(User::ASSURE);
    $menu = array(
        array(),
        array(
            array(
                "title" => "Accueil",
                "url" => "/"
            ),
            array(
                "title" => "Contrats",
                "url" => "/view"
            ),
            array(
                "title" => "Constater",
                "url" => "/constater"
            ),
            array(
                "title" => "Vendre",
                "url" => "/declarer"
            ),
            array(
                "title" => "Contact",
                "url" => "/contact"
            )
        ),
        array(
            array(
                "title" => "Accueil",
                "url" => "/"
            ),
            array(
                "title" => "Contact",
                "url" => "/contact"
            )
        ),
        array(
            array(
                "title" => "Accueil",
                "url" => "/"
            ),
            array(
                "title" => "Contrats",
                "url" => "/view"
            ),
            array(
                "title" => "Assurés",
                "url" => "/gestionnaire"
            ),
            array(
                "title" => "Vérifications",
                "url" => "/verifications"
            ),
            array(
                "title" => "Sinistres",
                "url" => "/sinistres"
            ),
            array(
                "title" => "Ventes",
                "url" => "/declarations"
            ),
            array(
                "title" => "Contact",
                "url" => "/contact"
            )
        ),
        array(
            array(
                "title" => "Accueil",
                "url" => "/"
            ),
            array(
                "title" => "Admin",
                "url" => "/admin"
            )
        )
    );

    foreach ($menu[getPermissions()] as $e) {
        echo '<li class="nav-item">';
        echo '<a class="nav-link nav-btn" href="' . $e["url"] . '"><span class="userbtn_txt">'. $e["title"] .'</span></a>';
        echo '</li>';
    }

?>