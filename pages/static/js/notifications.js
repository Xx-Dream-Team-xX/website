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
            <span class="material-icons grow grow-2">${c2}</span>
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
                <div class="del_msg grow grow-2" onclick='${c4}("${id}")'>
                    <span class="material-icons">${c3}</span>
                </div>
            </div>
        </div>
    </div>`
}

function loadNotifications() {
    // to notify the user on notification change
    //document.getElementById("notif-led").classList.add("appear");
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
                list.innerHTML = lazyHtmlInsertion("non-lu", "mark_email_unread", "mark_email_unread" , "markNotification", n.id, n.title, n.content, n.url) + list.innerHTML;
            } else {
                list.innerHTML = lazyHtmlInsertion("lu", "mark_email_read", "delete", "clearNotification", n.id, n.title, n.content, n.url) + list.innerHTML;
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

//Fonction: Ouvre la fen??tre modal si on click sur la cloche de notification
//Param??tre: n/a 
function ouvrirModal() {
    var modal = document.getElementById("modal_notif");
    modal.style.display = "block";
    loadNotifications();
}

//Fonction: Ferme la fen??tre si l'utilisateur appuit sur la croix
//Param??tre: n/a 
function fermerModal() {
    var modal = document.getElementById("modal_notif");
    modal.style.display = "none";
}

//Fonction: Si l'utilisateur clique en-dehors du div de class "modal-content" et donc dans le div class "modal", ferme la fen??tre
//Param??tre: Clique
window.onclick = function clickDehors(event) {
    var modal = document.getElementById("modal_notif");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}



//Fonction: Fait apparaitre le menu dropdown associ?? au boutton
//Param??tre: Le dropdown menu qui est cach?? si le boutton n'a pas ??t?? appuyer
function dropdown_fnc(menu){
    document.getElementById(menu).classList.toggle("show");
}

//Fonction: Si un menu dropdown est ouverte, si l'utilisateur clique en dehors du menu dropdown, ferme ce menu
//Param??tre: Clique de la page
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
