class Transfer {

    constructor() {
        this.pole = "";
        this.poleName = "";
        this.divIndus = document.getElementById("Indus")
        this.divSI = document.getElementById("SI")
        this.divDatabase = document.getElementById("Database")
    }

    Indus() {
        this.pole = 1
        this.poleName = "Indus"
        this.divIndus.style.classList.add("active")
        this.divSI.style.classList.remove("active")
        this.divDatabase.style.classList.remove("active")
    }

    SI() {
        this.pole = 2
        this.poleName = "SI"
        this.divIndus.style.classList.remove("active")
        this.divSI.style.classList.add("active")
        this.divDatabase.style.classList.remove("active")
    }

    Database() {
        this.pole = 3
        this.poleName = "Database"
        this.divIndus.style.classList.remove("active")
        this.divSI.style.classList.remove("active")
        this.divDatabase.style.classList.add("active")
    }

    send() {

        if (this.pole == "" || this.poleName == "") return;

        Alert.popup({
            title: "Transfer",
            text: "Etes-vous sûr(e) de vouloir transferer ce candidat vers le pôle " + this.poleName + " ? Cette action est irreversible.",
            showCancelButton: true,
            confirmText: "Oui",
            confirmColor: "#40aa40",
            confirm : function () {
                Ajax.post("/candidat/traitement.php?id=<?php echo $_GET['id']; ?>&action=transfer", "token=<?php echo Security::gen_token(5100) ?>&pole=" + this.pole, function(e) {
                    location.href = "/consultant/?id=" + JSON.parse(e).infos.id;
                });
            }
        })

    }

}