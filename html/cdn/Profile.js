class Arr {

    static arr() {
        return {
            includes : function(id) {
                for (var a in this.values) {if (a == id) return true;} return false;
            },
            push : function(id, niveau) {
                if (!this.includes(id)) {this.values[id] = niveau; return true;} return false;
            },
            del : function(id) {
                if (this.includes(id)) {
                    let t = Arr.arr();
                    for (var a in this.values) {
                        if (a != id) t.push(a, this.values[a]);
                    }
                    this.values = t.values;
                    return true;
                } return false;
            },
            values : {}
        }

    }

}



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

        Post.send("/consultant/modifier/", {
            "comp" : encodeURI(JSON.stringify(arr)),
            "modif" : "comp"
        });

    }

}

class Intervention {

    static del(id) {

        Post.send("/consultant/modifier/", {
            "action" : "delete",
            "modif" : "int",
            "id" : id
        })

    }

    static del_candidat(id) {

        Post.send("/candidat/modifier/", {
            "action" : "delete",
            "modif" : "int",
            "id" : id
        })

    }
}

class Qualification {

    static del(id) {

        Post.send("/consultant/modifier/", {
            "action" : "delete",
            "modif" : "qual",
            "id" : id
        })

    }

    static del_candidat(id) {

        Post.send("/candidat/modifier/", {
            "action" : "delete",
            "modif" : "qual",
            "id" : id
        })

    }
}

class Graph {

    constructor() {

        this.g1 = Arr.arr();
        this.g2 = Arr.arr();
        this.g3 = Arr.arr();

    }

    addG1(id, niveau, name) {
        if (this.g1.push(id, niveau)) {
            document.querySelector('.graph1').innerHTML += '<div class="graphComp" data-id="' + id + '" data-lvl="' + niveau + '">' + name +
            "<div onclick='g.delG1(" + id + ")' class='del'>&times;</div></div>";
        }
    }
    delG1(id) {
        if (this.g1.del(id)) {
            document.querySelector('.graph1 .graphComp[data-id="' + id + '"').remove();
        }
    }
    addG2(id, niveau, name) {
        if (this.g2.push(id, niveau)) {
            document.querySelector('.graph2').innerHTML += '<div class="graphComp" data-id="' + id + '" data-lvl="' + niveau + '">' + name +
            "<div onclick='g.delG2(" + id + ")' class='del'>&times;</div></div>";
        }
    }
    delG2(id) {
        if (this.g2.del(id)) {
            document.querySelector('.graph2 .graphComp[data-id="' + id + '"').remove();
        }
    }
    addG3(id, niveau, name) {
        if (this.g3.push(id, niveau)) {
            document.querySelector('.graph3').innerHTML += '<div class="graphComp" data-id="' + id + '" data-lvl="' + niveau + '">' + name +
            "<div onclick='g.delG3(" + id + ")' class='del'>&times;</div></div>";
        }
    }
    delG3(id) {
        if (this.g3.del(id)) {
            document.querySelector('.graph3 .graphComp[data-id="' + id + '"').remove();
        }
    }

    load() {

        document.querySelectorAll('.graph1 .graphComp').forEach(e => {
            this.g1.push(e.dataset.id, e.dataset.id);
        });
        document.querySelectorAll('.graph2 .graphComp').forEach(e => {
            this.g2.push(e.dataset.id, e.dataset.id);
        });
        document.querySelectorAll('.graph3 .graphComp').forEach(e => {
            this.g3.push(e.dataset.id, e.dataset.id);
        });

    }

    send() {

        Post.send("/consultant/modifier/", {
            "modif": "graph",
            "graph1": encodeURI(JSON.stringify(this.g1.values)),
            "graph2": encodeURI(JSON.stringify(this.g2.values)),
            "graph3": encodeURI(JSON.stringify(this.g3.values)),
        })

    }

}
