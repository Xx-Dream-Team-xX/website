//Fonction: Ouvre la fenêtre modal si on click sur la cloche de notification
//Paramètre: n/a 
function ouvrirModal() {
    var modal = document.getElementById("modal_notif");
    modal.style.display = "block";
}

//Fonction: Ferme la fenêtre si l'utilisateur appuit sur la croix
//Paramètre: n/a 
function fermerModal() {
    var modal = document.getElementById("modal_notif");
    modal.style.display = "none";
}

//Fonction: Si l'utilisateur clique en-dehors du div de class "modal-content" et donc dans le div class "modal", ferme la fenêtre
//Paramètre: Clique
window.onclick = function clickDehors(event) {
    var modal = document.getElementById("modal_notif");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}



//Fonction: Fait apparaitre le menu dropdown associé au boutton
//Paramètre: Le dropdown menu qui est caché si le boutton n'a pas été appuyer
function dropdown_fnc(menu){
    document.getElementById(menu).classList.toggle("show");
}

//Fonction: Si un menu dropdown est ouverte, si l'utilisateur clique en dehors du menu dropdown, ferme ce menu
//Paramètre: Clique de la page
window.onclick = function close_drop(event) {
    if (!event.target.matches('.dropbtn') && !event.target.matches('.dropbtn span')) {
        var dropdowns = document.getElementsByClassName("drop-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDrop = dropdowns[i];
            if (openDrop.classList.contains("show")) {
                openDrop.classList.remove("show");
            }
        }
    }
}