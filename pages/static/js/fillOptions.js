function fill(input, data, filter="") {
    let types = [
        "Utilisateur supprimé",
        "Assuré",
        "Gestionnaire",
        "Administrateur"
    ];
    data.sort((a, b) => {
        if (a.featured) {
            return 1
        }
        return (a < b)
    })
    data.filter(a => (a.name.includes(filter)));
    input.innerHTML = "";
    data.forEach(user => {
        el = document.createElement("option");
        el.textContent = `${user.name} (${types[user.type]})`;
        el.value = user.id;
        input.appendChild(el);

    });
}
