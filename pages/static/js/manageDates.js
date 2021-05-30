

function getDate(timestamp = null) {

    let d = timestamp ? new Date(timestamp * 1000) : new Date();
    let a = d.toJSON();
    return a.split('T')[0];
}


function getChangedDate(dy, dm, dd) {
    let date = new Date();
    let d = date.getDate() - dd;
    let m = date.getMonth() - dm;
    let y = date.getFullYear() - dy;

    date = new Date(y, m, d);
    let a = date.toJSON();
    return a.split('T')[0];
}



function addMaxDate(ele) {
    if (ele.id == "inputBirthdate") {
        ele.setAttribute("min", getChangedDate(100, 0, 0));
        ele.setAttribute("max", getChangedDate(18, 0, 0));
        ele.setAttribute("value", getChangedDate(30, 0, 0));
    } else {
        ele.setAttribute("max", getDate());
    }
}
