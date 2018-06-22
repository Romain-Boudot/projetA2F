class Admin {

    static addDaughter(id, parentid) {

        var parent = document.querySelector("#ddc" + parentid)

        var trigger = document.querySelector("#ddt" + parentid)
        
        trigger.nextElementSibling.style.height = trigger.nextElementSibling.scrollHeight + "px";
        setTimeout(() => {
            trigger.nextElementSibling.style.height = "auto";
        }, 300);

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