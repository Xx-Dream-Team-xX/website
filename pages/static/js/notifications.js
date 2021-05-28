function requestNotification(url, f, id=null) {
    r = new XMLHttpRequest();
    r.open("POST", '/notifications/' + url);
    if (id) {
        d = new FormData()
        d.append("id", id);
        r.send(d);
    } else {
        r.send();
    }
    r.onreadystatechange = function() {
        if (this.status === 200 && this.readyState === 4) {
            if (f) {
                f(JSON.parse(this.responseText));
            }
        }
    }
}

function lazyHtmlInsertion(c, c2, c3, c4, id, title, content, url) {
    return `
    <div class="modal_item ${c} row">
        <div class="left-side small-break-remove" onclick="markNotification('${id}'); window.open('${url}', '_blank');">
            <span class="material-icons">${c2}</span>
        </div>
        
        <div id="${id}" class="right-side small-break-container">
            <div class="top-side row mouse-cursor" onclick="markNotification('${id}'); window.open('${url}', '_blank');">
                <div class="msg_title">
                    <span>${title}</span>
                </div>
            </div>
            <div class="bottom-side d-flex flex-row">
                <div class="user_msg mouse-cursor" onclick="markNotification('${id}'); window.open('${url}', '_blank');">
                    <span>${content}</span>
                </div>
                <div class="del_msg" onclick='${c4}("${id}")'>
                    <span class="material-icons">${c3}</span>
                </div>
            </div>
        </div>
    </div>`
}

function loadNotifications() {
    let list = document.getElementById("notifications");
    requestNotification("list", (r) => {
        list.innerHTML = "";
        r = r.sort(
            (a, b) => {
                return (b.seen) - (a.seen)
            }
        )
        r.forEach(n => {

            if (!n.seen) {
                list.innerHTML = lazyHtmlInsertion("non-lu", "mark_email_read", "mark_email_read" , "markNotification", n.id, n.title, n.content, n.url) + list.innerHTML;
            } else {
                list.innerHTML = lazyHtmlInsertion("lu", "mark_email_unread", "delete", "clearNotification", n.id, n.title, n.content, n.url) + list.innerHTML;
            }
        });
    });
}

function markNotification(id) {
    requestNotification("read", loadNotifications , id)
}

function clearNotification(id) {
    requestNotification("clear", loadNotifications, id)
}

//Fonction: Ouvre la fenêtre modal si on click sur la cloche de notification
//Paramètre: n/a 
function ouvrirModal() {
    var modal = document.getElementById("modal_notif");
    modal.style.display = "block";
    loadNotifications();
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
