function getData() {
    let r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            console.log(JSON.parse(this.responseText));
        } else {
            console.log("Server Error");
        }
    }
    r.open("POST", "/users/list", true);
    r.send();
}
