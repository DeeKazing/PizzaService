//ECMA
var warenkorb = [];
var gesamtPreis = 0.0;
//Beim hinzufuegen einer Pizza in den Warenkorb...
function hinzufuegenWarenkorb(pizza) {
    "use strict";
    var pJSON = JSON.parse(pizza),
        wk = document.getElementById("warenkorb"),
        newWkOption = document.createElement("option"); //erstelle neue option
    /*Die Methode JSON.parse() 
    erzeugt aus einem JSON-formatierten Text 
    ein entsprechendes Javascript-Objekt. */
    warenkorb.push(pJSON);//brauchst du, damit du später löschen kannst 
    newWkOption.nodeValue = pJSON.pizzaname;
    newWkOption.innerText = pJSON.pizzaname;
    wk.append(newWkOption);

    updateGesamtPreis();
}
//...muss sofort der Gesamtpreis berechnet werden
function updateGesamtPreis() {
    "use strict";
    gesamtPreis = 0.0;
    warenkorb.forEach(WarenkorbRechner);
    /*Für jede option im Wk, werden in der Methode "WarenkorbRechner"
    die Preise Addiert*/
    var summeSite = document.getElementById("gesamtPreis");
    //aktualisiere innerText mit neuem Preis
    summeSite.innerText = "Gesamtpreis: " + gesamtPreis.toFixed(2) + "€";
}


function WarenkorbRechner(element) {
    "use strict";
    //addiere alten gesamtpreis, mit dem preis der neuen Pizza(neue 'element' : any-parameter)
    gesamtPreis = gesamtPreis + parseFloat(element.preis);
}

function WarenkorbLeeren() {
    "use strict";
    var wkSite = document.getElementById("warenkorb"),
        i;
    for (i = wkSite.options.length - 1; i >= 0; i -= 1) {
        wkSite.remove(i);
        warenkorb.splice(i, 1);
    }
    updateGesamtPreis();
}

function entfernenWarenkorb() {
    "use strict";
    var wkSite = document.getElementById("warenkorb"),
        i;
    for (i = wkSite.options.length - 1; i >= 0; i -= 1) {
        if (wkSite.options[i].selected) {
            wkSite.remove(i);
            warenkorb.splice(i, 1);
        }
    }
    updateGesamtPreis();
}

