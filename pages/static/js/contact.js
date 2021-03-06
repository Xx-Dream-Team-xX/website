function parse(id) {
    let r = new XMLHttpRequest();
    let d = new FormData();
    d.append("id", id);
    r.open("POST", "/assurance/get");
    r.send(d);
    r.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            a = JSON.parse(this.responseText);
            document.getElementById("table").innerHTML += `<td><img src="/useruploadedcontent/${a.logoPath}" class="img-fluid img-thumbnail img-responsive smol"></td><td>${a.name}</td><td><a class="link-secondary" href="tel:${a.phone}">+${a.phone}</a></td>`;
        }
    }
}

function onLoad() {
    if (me.id && me.type === 1) {
        document.getElementById("a_info").hidden = false;
        parse(me.assurance);
    }
}