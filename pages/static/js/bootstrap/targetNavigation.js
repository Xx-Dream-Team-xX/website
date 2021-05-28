function getTarget(original) {
    let current = window.location.pathname;
    current = current.replace(original, "");
    current = current.split("/")[0];
    return current;
}

function isID(original) {
    return (getTarget(original).length === 13);
}

function setFakeURL(url, title) {
    history.pushState({}, title, url);
}