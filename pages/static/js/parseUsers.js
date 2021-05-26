function getNameFromId(cache, id, f=null) {
    if (typeof cache !== "object") cache = {};
    if (typeof cache[id] !== "array") cache[id] = {};
    if (cache[id].length > 0) return cache[id];
    r = new XMLHttpRequest();
    d = new FormData();
    d.append("id", id);
    r.open("POST", "/users/get");
    r.send(d);
    r.onreadystatechange = function() {
        if (this.status === 200 && this.readyState === 4) {
            cache[id] = JSON.parse(this.responseText) ?? null;
            if (typeof f !== undefined) {
                f(cache[id]);
            }
        }
        
    }
}