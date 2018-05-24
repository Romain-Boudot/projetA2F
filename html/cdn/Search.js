function find(arr, val) {
    arr.findIndex(function(e) {
        return e == val;
    })
}

class Search {

    constructor() {

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
                "nom":""
            }
        };
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

        if (!this.arr.competences.id_competence.includes(e.dataset.id)) {

            this.arr.competences.id_competence.push(e.dataset.id);
            console.log("ajout de la competence " + e.dataset.id); // debug
            console.log(this.arr); // debug
            
            document.querySelector(".divCompList").innerHTML += "<div onclick=\"search.delComp(this)\" data-id=\"" + e.dataset.id + "\" class=\"comp\">" + e.dataset.name + "<div class=\"closeBtn\">&times;</div></div>";        
            document.querySelector(".divCompListS").innerHTML += "<div onclick=\"search.delComp(this)\" data-id=\"" + e.dataset.id + "\" class=\"compSelected\">" + e.dataset.name + "<div class=\"closeBtn\">&times;</div></div>";
            
        }

    }

    addClient(e) {

        if (!this.arr.clients.id_client.includes(e.dataset.id)) {

            this.arr.clients.id_client.push(e.dataset.id);
            console.log("ajout du client " + e.dataset.id); // debug
            console.log(this.arr); // debug
            
            document.querySelector(".divClientList").innerHTML += "<div onclick=\"search.delClient(this)\" data-id=\"" + e.dataset.id + "\" class=\"comp\">" + e.dataset.name + "<div class=\"closeBtn\">&times;</div></div>";
            document.querySelector(".divClientListS").innerHTML += "<div onclick=\"search.delClient(this)\" data-id=\"" + e.dataset.id + "\" class=\"clientSelected\">" + e.dataset.name + "<div class=\"closeBtn\">&times;</div></div>";
            
        }

    }

    delClient(e) {

        if (this.arr.clients.id_client.includes(e.dataset.id)) {

            console.log(find(this.arr.clients.id_client, e.dataset.id));
            return;

            this.arr.clients.id_client.push(e.dataset.id);
            console.log("ajout du client " + e.dataset.id); // debug
            console.log(this.arr); // debug
            
            document.querySelector(".divClientList").innerHTML += "<div onclick=\"search.delClient(this)\" data-id=\"" + e.dataset.id + "\" class=\"comp\">" + e.dataset.name + "<div class=\"closeBtn\">&times;</div></div>";
            document.querySelector(".divClientListS").innerHTML += "<div onclick=\"search.delClient(this)\" data-id=\"" + e.dataset.id + "\" class=\"clientSelected\">" + e.dataset.name + "<div class=\"closeBtn\">&times;</div></div>";
            
        }

    }

    send() {

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
            }
        }

        return encodeURI(JSON.stringify(arr));

    }

}