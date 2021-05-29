function toggleModal() {
    let m = document.getElementById("modal");
    if (m.classList.contains("show")) {
        m.classList.remove("show");
        m.setAttribute("style", "display: none;");
    } else {
        m.classList.add("show");
        m.setAttribute("style", "display: block;");
    }
}

function showError(error) {
    document.getElementById("error").innerText = error;
}

function removeError() {
    document.getElementById("error").innerText = "";
}

function onLoad() {
    let r = new XMLHttpRequest()
    r.open("GET", "/assurance/list");
    r.send();
    r.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let r = JSON.parse(this.responseText);
            let t = document.getElementById("table");
            t.innerHTML = "";
            r.forEach(a => {
                t.innerHTML += `<td><img src="/useruploadedcontent/${a.logoPath}" class="img-fluid img-thumbnail img-responsive smol"></td><td>${a.name}</td><td>${a.phone}</td><td>${a.id}</td>`;
            });
        }
    }
}

function testValue(r, v, e){
    let p = new RegExp(r);
    if (!(p.test(v))){
        showError(e);
    } else {
        removeError();
    }
}

function check(ele, type, error) {
    switch (type) {
        case 'phone':
            testValue("^[0-9]{9,14}", ele.value, error);
            break;
        case 'name':
            testValue(".*", ele.value, error);
            break;
        default:
            break;            
    }
}

function send() {
    let r = new XMLHttpRequest()
    let d = new FormData();

    d.append("name", document.getElementById("name").value);
    d.append("phone", document.getElementById("phone").value);

    let files = document.getElementById("files").files;
    if (files.length !== 1) {
        return showError("Veuillez chosir un logo pour la prochaine assurance");
    }

    d.append("file", files[0], files[0].length);

    r.open("POST", "/assurance/add");
    r.send(d);
    r.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            window.location.reload();
        }
    }
}