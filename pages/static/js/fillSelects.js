var CAR_MANUFACTURES = [
    "Abarth",
    "Alfa Romeo",
    "Aston Martin",
    "Audi",
    "Bentley",
    "BMW",
    "Bugatti",
    "Cadillac",
    "Chevrolet",
    "Chrysler",
    "Citroën",
    "Dacia",
    "Daewoo",
    "Daihatsu",
    "Dodge",
    "Donkervoort",
    "DS",
    "Ferrari",
    "Fiat",
    "Fisker",
    "Ford",
    "Honda",
    "Hummer",
    "Hyundai",
    "Infiniti",
    "Iveco",
    "Jaguar",
    "Jeep",
    "Kia",
    "KTM",
    "Lada",
    "Lamborghini",
    "Lancia",
    "Land Rover",
    "Landwind",
    "Lexus",
    "Lotus",
    "Maserati",
    "Maybach",
    "Mazda",
    "McLaren",
    "Mercedes-Benz",
    "MG",
    "Mini",
    "Mitsubishi",
    "Morgan",
    "Nissan",
    "Opel",
    "Peugeot",
    "Porsche",
    "Renault",
    "Rolls-Royce",
    "Rover",
    "Saab",
    "Seat",
    "Skoda",
    "Smart",
    "SsangYong",
    "Subaru",
    "Suzuki",
    "Tesla",
    "Toyota",
    "Volkswagen",
    "Volvo"
]

CAR_CATEGORIES = [
    "SUV",
    "Sedan",
    "Coupe",
    "Convertible",
    "Hatchback",
    "Pickup",
    "Van",
    "Minivan",
    "Wagon"
]

VALID_COUNTRIES = [
    "A",
    "B",
    "BG",
    "CY",
    "CZ",
    "D",
    "DK",
    "E",
    "EST",
    "F",
    "FIN",
    "GB",
    "GR",
    "H",
    "HR",
    "I",
    "IRL",
    "IS",
    "L",
    "LT",
    "LV",
    "M",
    "N",
    "NL",
    "P",
    "PL",
    "RO",
    "S",
    "SK",
    "SLO",
    "CH",
    "AL",
    "AND",
    "AZ",
    "BIH",
    "BY",
    "IL",
    "IR",
    "MA",
    "MD",
    "MK",
    "MNE",
    "RUS",
    "SRB",
    "TN",
    "TR",
    "UA"
];

function fillSelectMan() {
    let select = document.getElementById("listVehicleMan");
    for ( var i = 0; i < CAR_MANUFACTURES.length; i++ ) {
        var opt = CAR_MANUFACTURES[i];
        var el = document.createElement("option");
        el.textContent = opt;
        el.value = opt;
        select.appendChild(el);
    }
}

function fillSelectCat() {
    let select = document.getElementById("listVehicleCat");
    for ( var i = 0; i < CAR_CATEGORIES.length; i++ ) {
        var opt = CAR_CATEGORIES[i];
        var el = document.createElement("option");
        el.textContent = opt;
        el.value = opt;
        select.appendChild(el);
    }
}

function fillSelectCon() {
    let select = document.getElementById("listCountry");
    for ( var i = 0; i<VALID_COUNTRIES.length; i++ ) {
        var opt = VALID_COUNTRIES[i];
        var el = document.createElement("option");
        el.textContent = opt;
        el.value = opt;
        select.appendChild(el);
    }
}




function onLoad() {
    fillSelectMan();
    fillSelectCat();
    //fillSelectCon();
}

