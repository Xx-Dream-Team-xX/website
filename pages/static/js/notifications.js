function requestNotification(url, f, id=null) {
    r = new XMLHttpRequest();
    r.open("POST", '/notifications/' + url);
    if (id) {
        r.send((new FormData).append("id"), id)
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

function loadNotifications() {
    let list = document.getElementById("notifications");
    requestNotification("list", (r) => {
        // list.innerHTML = "";
        r.forEach(n => {
            console.log(n);
        });
    });
}

function markNotification(id) {
    requestNotification("read")
}

function markAllNotifications() {

}

function clearNotification() {

}

function clearAllNotifications() {

}