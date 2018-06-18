class Candidat {

    static delFile(div) {

        Ajax.get("/consultant/traitement.php?id=" + url_get.$_GET().id + "&action=gettoken", function(e) {

            console.log(e);
            var token = JSON.parse(e).token;
            
            Alert.popup({
                title: "Attention !",
                text: "Etes-vous sûr(e) de vouloir supprimer ce fichier ?",
                showCancelButton: true,
                cancelText: "Non",
                confirmColor: "#22aa22",
                confirmText: "Oui",
                confirm: function() {
                    Alert.close();
                    Ajax.post("/candidat/traitement.php?id=" + url_get.$_GET().id + "&action=pdfdel", "token=" + token + "&filename=" + div.dataset.servername, function(e) {
                        console.log(e);
                        var data = JSON.parse(e);
                        var file = document.createElement("div");
                        file.classList.add("file");
                        if (data.code == 1) {
                            document.querySelector("[data-servername='" + data.infos.servername + "'").parentElement.remove();
                            if (document.querySelectorAll(".file").length < 5) {
                                document.querySelector('.addFile').style.display = "inline-block";
                            }
                        }
                    })
                }
            })

        })

    }

    static load() {

        var fileInput = document.getElementById("fileInput");

        fileInput.onchange = function() {   
            var pdf = new FormData();
            pdf.append('file', fileInput.files[0]);
            Ajax.file("/candidat/traitement.php?id=" + url_get.$_GET().id + "&action=pdfadd", pdf, function(data) {

                console.log(data);
                data = JSON.parse(data);

                if (data.code == 1) {

                    var div = document.createElement("div")
                    
                    div.classList.add("file");
                    div.innerHTML = '<a href="/?file=' + data.infos.servername + '" target="_blank" class="clickable">'+
                    '<img src="/images/pdf.svg" alt="svg pdf" height="20">' + data.infos.truename + '</a>'+
                    '<i onclick="Candidat.delFile(this)" data-servername="' + data.infos.servername + '" class="material-icons floatRight clickable">delete</i>'+
                    '<a class="floatRight clickable" href="/?file=' + data.infos.servername + '" target="_blank"><img src="/images/download.svg" alt="svg pdf" height="20"></a>'

                    document.querySelector(".fileUpload").insertBefore(div, document.querySelector(".addFile"));

                    if (document.querySelectorAll(".file").length >= 5) {
                        document.querySelector('.addFile').style.display = "none";
                    }

                } else if (data.code < -1) {
                    Alert.popup({
                        title: "Erreur",
                        text: data.message,
                        showCancelButton: false,
                        confirmColor: "#bbbbbb",
                        confirmText: "Retour",
                        confirm: function() {
                            Alert.close();
                        }
                    })
                }
            });
        }

    }

}