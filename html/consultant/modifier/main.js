function $(query) {
    return document.querySelector(query);
}

function $$(query) {
    return document.querySelectorAll(query);
}

function clientReplace(str) {

    var input = $("[name='client']");
    showClientSuggest('{"code": -1, "arr": []}');
    input.value = str;

}

function entrepriseReplace(str) {

    var input = $("[name='entreprise']");
    showClientSuggest('{"code": -1, "arr": []}');
    input.value = str;

}

function showClientSuggest(array) {

    var list = JSON.parse(array).arr;
    var parent = $("[name='client']").parentElement;
    var divSuggest = $(".suggestion.clientSuggestion");

    if (divSuggest == null) {
        divSuggest = document.createElement("div");
        divSuggest.classList.add("suggestion", "clientSuggestion");
        parent.appendChild(divSuggest);
    }

    divSuggest.innerHTML = "";

    if (list.length == 0) {
        divSuggest.style.display = "none";
        return;
    } else {
        divSuggest.style.display = "block";
    }

    for (var key in list) {
        if (key == 30) return;
        var elem = list[key];
        var client = document.createElement("div");
        client.innerText = elem.entreprise;
        client.onmousedown = function(event) {
            clientReplace(event.target.innerText);
        }
        divSuggest.appendChild(client);
    };

}

function showEntrepriseSuggest(array) {

    var list = JSON.parse(array).arr;
    var parent = $("[name='entreprise']").parentElement;
    var divSuggest = $(".suggestion.entrepriseSuggestion");

    if (divSuggest == null) {
        divSuggest = document.createElement("div");
        divSuggest.classList.add("suggestion", "entrepriseSuggestion");
        parent.appendChild(divSuggest);
    }

    divSuggest.innerHTML = "";

    if (list.length == 0) {
        divSuggest.style.display = "none";
        return;
    } else {
        divSuggest.style.display = "block";
    }

    for (var key in list) {
        if (key == 30) return;
        var elem = list[key];
        var entreprise = document.createElement("div");
        entreprise.innerText = elem.nom;
        entreprise.onmousedown = function(event) {
            entrepriseReplace(event.target.innerText);
        }
        divSuggest.appendChild(entreprise);
    };

}

function clientSugest(dir) {
    
    var selected = $(".clientSuggestion .selected");

    if (selected == null) {
        $(".clientSuggestion *:first-child").classList.add("selected");
    } else if (selected.nextElementSibling && dir == "down") {
        selected.classList.remove("selected");
        selected.nextElementSibling.classList.add("selected");
    } else if (selected.previousElementSibling && dir == "up") {
        selected.classList.remove("selected");
        selected.previousElementSibling.classList.add("selected");
    } else if (dir == "enter") {
        clientReplace(selected.innerText);
    }

}

function entrepriseSugest(dir) {
    
    var selected = $(".entrepriseSuggestion .selected");

    if (selected == null) {
        $(".entrepriseSuggestion *:first-child").classList.add("selected");
    } else if (selected.nextElementSibling && dir == "down") {
        selected.classList.remove("selected");
        selected.nextElementSibling.classList.add("selected");
    } else if (selected.previousElementSibling && dir == "up") {
        selected.classList.remove("selected");
        selected.previousElementSibling.classList.add("selected");
    } else if (dir == "enter") {
        entrepriseReplace(selected.innerText);
    }

}

window.onload = function() {

    $("[name='client']").onkeydown = function(event) {

        if (event.keyCode == 13) {
            
            clientSugest('enter')
            return false;
            
        }

    }

    $("[name='entreprise']").onkeydown = function(event) {

        if (event.keyCode == 13) {
            
            entrepriseSugest('enter')
            return false;
            
        }

    }

    $("[name='client']").onkeyup = function(event) {

        if (event.keyCode <= 40 && event.keyCode >= 37) {

            if (event.keyCode == 40) {
                // key_down
                clientSugest('down');
            }
            if (event.keyCode == 38) {
                // key_up
                clientSugest('up');
            }

        } else if (event.keyCode != 13) {

            if (event.target.value == "") {
                showClientSuggest('{"code": -1, "arr": []}');
                return;
            };
            Ajax.post("/consultant/modifier/suggest.php", "table=client&input=" + event.target.value, showClientSuggest);

        }

    }

    $("[name='entreprise']").onkeyup = function(event) {

        if (event.keyCode <= 40 && event.keyCode >= 37) {

            if (event.keyCode == 40) {
                // key_down
                entrepriseSugest('down');
            }
            if (event.keyCode == 38) {
                // key_up
                entrepriseSugest('up');
            }

        } else if (event.keyCode != 13) {

            if (event.target.value == "") {
                showEntrepriseSuggest('{"code": -1, "arr": []}');
                return;
            };
            Ajax.post("/consultant/modifier/suggest.php", "table=entreprise&input=" + event.target.value, showEntrepriseSuggest);

        }

    }

    $("[name='client']").onfocus = function(event) {
        if ($(".suggestion.clientSuggestion"))
            if ($(".suggestion.clientSuggestion").innerHTML != "") {
                $(".suggestion.clientSuggestion").style.display = "block";
            }
    }

    $("[name='client']").onblur = function(event) {
        if ($(".suggestion.clientSuggestion"))
            $(".suggestion.clientSuggestion").style.display = "none";
    }

    $("[name='entreprise']").onfocus = function(event) {
        if ($(".suggestion.entrepriseSuggestion"))
            if ($(".suggestion.entrepriseSuggestion").innerHTML != "") {
                $(".suggestion.entrepriseSuggestion").style.display = "block";
            }
    }

    $("[name='entreprise']").onblur = function(event) {
        if ($(".suggestion.entrepriseSuggestion"))
            $(".suggestion.entrepriseSuggestion").style.display = "none";
    }

}