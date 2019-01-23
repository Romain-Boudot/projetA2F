class Consultant {

    static delFile(div) {

        Ajax.get("/consultant/traitement.php?action=gettoken", function(e) {

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
                    Ajax.post("/consultant/traitement.php?action=pdfdel", "token=" + token + "&filename=" + div.dataset.servername, function(e) {

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

        var inputimg = document.getElementById("uploadPhoto");
        var fileInput = document.getElementById("fileInput");

        if (inputimg) inputimg.onchange = function() {   
            var img = new FormData();
            img.append('file', inputimg.files[0]);
            Ajax.file("/consultant/traitement.php?action=img", img, function(data) {
                console.log(data);
                data = JSON.parse(data);
                if (data.code == 1) {
                    document.querySelector("#image-profile img").setAttribute("src" , "/images/profil/" + data.name);
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

        if (fileInput) fileInput.onchange = function() {   
            var pdf = new FormData();
            pdf.append('file', fileInput.files[0]);
            Ajax.file("/consultant/traitement.php?action=pdfadd", pdf, function(data) {
                console.log(data);
                data = JSON.parse(data);
                if (data.code == 1) {

                    var div = document.createElement("div")
                    
                    div.classList.add("file");
                    div.innerHTML = '<a href="/?file=' + data.infos.servername + '" target="_blank" class="clickable">'+
                    '<img src="/images/pdf.svg" alt="svg pdf" height="20">' + data.infos.truename + '</a>'+
                    '<i onclick="Consultant.delFile(this)" data-servername="' + data.infos.servername + '" class="material-icons floatRight clickable">delete</i>'+
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