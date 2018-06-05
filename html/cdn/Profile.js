class Competence {

    static send() {

        var arr = [];

        document.querySelectorAll(".compJs").forEach(e => {

            if (e.dataset.lvl != e.value) {
                
                arr.push({
                    "oldLvl": e.dataset.lvl,
                    "lvl": e.value,
                    "id": e.dataset.id
                })
                
            }

        })

        Post.send("/consultant/modifier", {
            "comp" : encodeURI(JSON.stringify(arr)),
            "modif" : "comp"
        });

    }

}

class Intervention {

    static del(id) {

        Post.send("/consultant/modifier", {
            "action" : "delete",
            "modif" : "int",
            "id" : id
        })

    }

}

class Qualification {

    static del(id) {

        Post.send("/consultant/modifier", {
            "action" : "delete",
            "modif" : "qual",
            "id" : id
        })

    }

}

class Graph {

    constructor() {

        this.g1 = {
            includes : function(id) {
                for (var a in this) {if (this[a] == id) return true;} return false;
            },
            push : function(item) {

            },
            array : []
        };
        this.g2 = {
            includes : function(id) {
                for (var a in this) {if (this[a] == id) return true;} return false;
            }
        };
        this.g3 = {
            includes : function(id) {
                for (var a in this) {if (this[a] == id) return true;} return false;
            }
        };

    }

    addG1(id) {

        if (this.g1.includes(id)) return;

        this.g1;

    }

}