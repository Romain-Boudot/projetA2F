function arr_delete(arr = [], val) {
    var a = [];
    for (var key in arr) {
        if (val != arr[key]) {
            a.push(arr[key]);
        }
    }
    return a;
}

class Search {

    constructor() {

        this.comp = [];
        this.clients = [];
        this.arr = {};
        this.select = "<select style=\"background:\"><option selected>1 ou plus</option><option>2 ou plus</option><option>3</option><option>3 ou moins</option><option>2 ou moins</option><option>1 ou moins</option><option>0</option></select>"
        this.table = {
            "1 ou plus" : ">= 1",
            "2 ou plus" : ">= 2",
            "3" : "= 3",
            "3 ou moins" : "<= 3",
            "2 ou moins" : "<= 2",
            "1 ou moins" : "<= 1",
            "0" : "= 0"
        }
        Search.load();

    }

    static load() {

        console.log("loading search")

        document.querySelectorAll('.competence').forEach(e => {

            e.addEventListener("click", function(a) {

                search.addComp(a.target.e);

            })
            e.e = e;

        });

        document.querySelectorAll('.client').forEach(e => {

            e.addEventListener("click", function(a) {

                search.addClient(a.target.e);

            })
            e.e = e;

        })

    }

    addComp(e) {

        if (!this.comp.includes(e.dataset.id)) {

            this.comp.push(e.dataset.id);

            console.log(this.comp);
                    
            document.querySelector(".divCompListS").innerHTML += "<div data-name=\"" + e.dataset.name + "\" data-id=\"" + e.dataset.id + "\" class=\"compSelected\">" + e.dataset.name + "&nbsp;&nbsp;|&nbsp;&nbsp;niveau : " + this.select + "<div onclick=\"search.delComp('" + e.dataset.id + "')\" class=\"closeBtn\">&times;</div></div>";
            
        } else {

            console.log("allready in array");

        }

    }

    addClient(e) {

        if (!this.clients.includes(e.dataset.id)) {

            this.clients.push(e.dataset.id);
            
            console.log(this.clients);
            
            document.querySelector(".divClientList").innerHTML += "<div data-id=\"" + e.dataset.id + "\" class=\"clientS\">" + e.dataset.name + "<div onclick=\"search.delClient('" + e.dataset.id + "')\" class=\"closeBtn\">&times;</div></div>";
            document.querySelector(".divClientListS").innerHTML += "<div data-id=\"" + e.dataset.id + "\" class=\"clientSelected\">" + e.dataset.name + "<div onclick=\"search.delClient('" + e.dataset.id + "')\" class=\"closeBtn\">&times;</div></div>";
            
        } else {

            console.log("allready in array");

        }

    }

    delClient(e) {

        if (this.clients.includes(e)) {

            console.log('pass'); // debug

            this.clients = arr_delete(this.clients, e);

            console.log(this.clients);

            document.querySelector(".clientS[data-id='" + e + "']").remove();
            document.querySelector(".clientSelected[data-id='" + e + "']").remove();
            
        } else {

            console.log("not in array");
        
        }

    }

    delComp(e) {

        if (this.comp.includes(e)) {

            this.comp = arr_delete(this.comp, e);

            console.log(this.comp);

            document.querySelector(".competenceS[data-id='" + e + "']").remove();
            document.querySelector(".compSelected[data-id='" + e + "']").remove();
            
        } else {

            console.log("not in array");
        
        }

    }

    send() {

        this.arr = {
            "competences":{
                "id_competence":[],
                "niveau":[]
            },
            "poles":{
                "id_pole":[]
            },
            "clients":{
                "id_client":[]
            },
            "disponibilites":{
                "id_disponibilite":[]
            },
            "consultant":{
                "nom":null
            },
            "archive": null
        }

        var archive = document.getElementById('archive');
        var poleIndus = document.getElementById('poleIndus');
        var poleDatabase = document.getElementById('poleDatabase');
        var poleSi = document.getElementById('poleSi');

        var dispMtn = document.getElementById('dispMtn');
        var disp1M = document.getElementById('disp1M');
        var disp2M = document.getElementById('disp2M');
        var disp3M = document.getElementById('disp3M');

        (archive != null ? (archive.checked ? this.arr.archive = 1 : this.arr.archive = 0 ) : this.arr.archive = 0 )
        (poleIndus.checked ? this.arr.poles.id_pole.push(1) : 1+1)
        (poleDatabase.checked ? this.arr.poles.id_pole.push(3) : 1+1)
        (poleSi.checked ? this.arr.poles.id_pole.push(2) : 1+1)

        (dispMtn.checked ? this.arr.disponibilites.id_disponibilite.push(1) : 1+1)
        (disp1M.checked ? this.arr.disponibilites.id_disponibilite.push(2) : 1+1)
        (disp2M.checked ? this.arr.disponibilites.id_disponibilite.push(3) : 1+1)
        (disp3M.checked ? this.arr.disponibilites.id_disponibilite.push(4) : 1+1)

        for (var comp in this.comp) {
            if (!this.arr.competences.id_competence.includes(comp)) {
                this.arr.competences.id_competence.push(comp);
                var a = document.querySelector(".compSelected[data-id='" + comp + "']>select");
                var id = a.options[a.selectedIndex].text;
                this.arr.competences.niveau.push(this.table[id]);
            }
        }

        for (var client in this.client) {
            if (!this.arr.competences.id_competence.includes(client)) {
                this.arr.competences.id_competence.push(client);
            }
        }

        return this.arr;

    }

    onPopupClose() {

        document.querySelectorAll('.competenceS').forEach(e => {
            e.remove();
        })

        document.querySelectorAll('.compSelected').forEach(e => {
            var a = document.querySelector(".compSelected[data-id='" + e.dataset.id + "']>select");
            var id = a.options[a.selectedIndex].text;
            console.log(id);
            document.querySelector(".divCompList").innerHTML += "<div data-id=\"" + e.dataset.id + "\" class=\"competenceS\">" + e.dataset.name + "&nbsp;&nbsp;|&nbsp;&nbsp;niveau : " + id + "<div onclick=\"search.delComp('" + e.dataset.id + "')\" class=\"closeBtn\">&times;</div></div>";
        })


    }

    static test() {

        var arr = {
            "competences":{
                "id_competence":[192,193,194],
                "niveau":[2,1,3]
            },
            "poles":{
                "id_pole":[1,2]
            },
            "clients":{
                "id_client":[1,2]
            },
            "disponibilites":{
                "id_disponibilite":[1]
            },
            "consultant":{
                "nom":"corfa"
            },
            "archive": 0
        }

        return encodeURI(JSON.stringify(arr));

    }

}


// note l'ajout d'une comp reset le select des autres