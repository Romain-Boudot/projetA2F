class Alert {

    static get_alert_size() {

        return 50;

    }

    static open(elem) {

        elem.id = "AlertOpened";

        if (document.getElementById("AlertOpened") != null) {
            Alert.close(elem);
            return;
        }

        elem.style.opacity = "0";
        elem.style.transition = "0.3s opacity ease";
        document.body.appendChild(elem);
        setTimeout(() => {
            elem.style.opacity = "1";
        }, 500);

    }

    static popup(obj = {
        title: "Erreur",
        text: "Erreur inconnue",
        showCancelButton: false,
        cancelText: "Cancel",
        confirmColor: "#bbbbbb",
        confirmText: "Retour",
        confirm: function() {
            Alert.close();
        }
    }) {

        var back = document.createElement("div");
        var block = document.createElement("div");
        var title = document.createElement("div");
        var content = document.createElement("div");
        var confirm = document.createElement("div");

        back.style.backgroundColor = "rgba(0, 0, 0, .3)";
        back.style.fontFamily = "Roboto, sans-serif";
        back.style.position = "fixed";
        back.style.width = "100vw";
        back.style.height = "100vh";
        back.style.top = "0";
        back.style.left = "0";
        back.style.zIndex = "10000";
        back.appendChild(block);

        title.innerText = obj.title;
        title.style.fontSize = "27px";
        title.style.fontWeight = "600";
        //title.style.textAlign = "center";
        title.style.margin = "20px 0";
        block.appendChild(title);

        content.innerText = obj.text;
        //content.style.textAlign = "center";
        content.style.marginBottom = "20px";
        block.appendChild(content);

        confirm.style.marginBottom = "20px";
        confirm.style.padding = "10px 15px";
        confirm.style.display = "inline-block";
        confirm.style.borderRadius = "7px";
        confirm.style.cursor = "pointer";
        confirm.style.backgroundColor = obj.confirmColor;
        confirm.innerText = obj.confirmText;
        confirm.onclick = obj.confirm;

        if (obj.showCancelButton) {
            var cancel = confirm.cloneNode(true);
            cancel.innerText = "Annuler";
            cancel.style.backgroundColor = "#bbbbbb";
            cancel.style.marginRight = "20px";
            cancel.onclick = Alert.close;
            block.appendChild(cancel);
        }

        block.appendChild(confirm);

        block.style.backgroundColor = "white";
        block.style.position = "absolute";
        block.style.top = "10%";
        block.style.borderRadius = "10px";
        block.style.width = "500px";
        block.style.textAlign = "center";
        block.style.left = "calc(50% - " + (parseInt(block.style.width.slice(0, -2)) / 2) + "px)";

        Alert.open(back);

    }

    static load_page(url, callback = null) {

        Ajax.get(url, function(e) {

            var back = document.createElement("div");
            var block = document.createElement("div");

            block.innerHTML = e;
            block.style.backgroundColor = "white";
            block.style.position = "absolute";
            block.style.top = "10%";
            block.style.borderRadius = "10px";
            block.style.width = "80vw";
            block.style.left = "10vw";
            
            back.style.backgroundColor = "rgba(0, 0, 0, .3)";
            back.style.fontFamily = "Roboto, sans-serif";
            back.style.position = "fixed";
            back.style.width = "100vw";
            back.style.height = "100vh";
            back.style.top = "0";
            back.style.left = "0";
            back.style.zIndex = "10000";
            back.appendChild(block);

            Alert.open(back);

            if (callback != null) callback();

        })

    }

    static close(elem = null) {

        var opened = document.getElementById("AlertOpened")
        opened.style.opacity = "0";
        setTimeout(() => {
            opened.remove();
        }, 500);

        if (elem != null) Alert.open(elem);

    }

}