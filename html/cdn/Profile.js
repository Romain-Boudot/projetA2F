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