class Admin {

    static addDaughter(id, parentid) {

        var parent = document.querySelector("#ddc" + parentid)

        var input = document.createElement("input");

        if (document.getElementById("addDaughter") != null) {
            document.getElementById("addDaughter").remove();
        }

        input.id = "addDaughter";
        input.type = "text";
        input.onkeypress = function(e) {
            if (e.keyCode == 13) {
                Post.send("/admin/traitement.php", {
                    "nom" : document.getElementById("addDaughter").value,
                    "id" : id,
                    "action" : "add"
                });
            }
        }
        parent.appendChild(input);
    }

}