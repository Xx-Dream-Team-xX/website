function getNameFromId(cache, id, f=null) {

    if (id in cache) {
        return f(cache[id]);
    };

    r = new XMLHttpRequest();
    d = new FormData();
    d.append("id", id);
    r.open("POST", "/users/get");
    r.send(d);
    r.onreadystatechange = function() {
        if (this.status === 200 && this.readyState === 4) {
            cache[id] = JSON.parse(this.responseText) ?? null;
            if (f) {
                f(cache[id]);
            }
        }
        
    }
}