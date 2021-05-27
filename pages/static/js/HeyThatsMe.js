let me = [];

function updateMe(somethingtodo=null) {
    r = new XMLHttpRequest();
    r.open("GET", "/account/get");
    r.send();
    r.onreadystatechange = function() {
        if (this.status === 200 && this.readyState === 4) {
            me = JSON.parse(this.responseText) ?? null;
            if (typeof somethingtodo !== null) {
                somethingtodo();
            }
        }
    }
}