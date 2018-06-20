class Transfer {

    static Indus() {
        document.getElementById("TransferBtn").dataset.pole = 1
        document.getElementById("TransferBtn").dataset.poleName = "Indus"
        document.getElementById("Indus").classList.add("active")
        document.getElementById("SI").classList.remove("active")
        document.getElementById("Database").classList.remove("active")
    }

    static SI() {
        document.getElementById("TransferBtn").dataset.pole = 2
        document.getElementById("TransferBtn").dataset.poleName = "SI"
        document.getElementById("Indus").classList.remove("active")
        document.getElementById("SI").classList.add("active")
        document.getElementById("Database").classList.remove("active")
    }

    static Database() {
        document.getElementById("TransferBtn").dataset.pole = 3
        document.getElementById("TransferBtn").dataset.poleName = "Database"
        document.getElementById("Indus").classList.remove("active")
        document.getElementById("SI").classList.remove("active")
        document.getElementById("Database").classList.add("active")
    }

    static send(btn) {

        if (btn.dataset.pole == "" || btn.dataset.poleName == "") return;

        Ajax.get("/candidat/traitement.php?id=" + url_get.$_GET().id + "&action=gettoken", function(e) {
            var token = JSON.parse(e).token;

            Alert.popup({
                title: "Transfert",
                text: "Etes-vous sûr(e) de vouloir transférer ce candidat vers le pôle " + btn.dataset.poleName + " ? Cette action est irreversible.",
                showCancelButton: true,
                confirmText: "Oui",
                confirmColor: "#40aa40",
                confirm : function () {
                    Ajax.post("/candidat/traitement.php?id=" + url_get.$_GET().id + "&action=transfer", "token=" + token + "&pole=" + btn.dataset.pole, function(e) {
                        Alert.popup({
                            title: "Erreur",
                            text: JSON.parse(e).message,
                            showCancelButton: false,
                            confirmColor: "#fff",
                            confirmText: "Retour",
                            confirm: function() {
                                Alert.close()
                            }
                        })
                        location.href = "/consultant/?id=" + JSON.parse(e).infos.id;
                    });
                }
            })
            
        })

    }

}
