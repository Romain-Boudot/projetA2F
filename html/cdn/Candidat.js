class C {

    static ajust_tm(lvl) {

        Ajax.get("/candidat/traitement.php?action=timeline&id=" + url_get.$_GET().id + "&lvl=" + lvl, C.resize_tm);
        
    }

    static resize_tm(dataText) {

        var lvl = JSON.parse(dataText);

        var line = document.querySelector(".line .coloredLine");
        line.classList.remove("step1", "step2", "step3", "step4")
        line.classList.add("step" + lvl);

        var points = document.querySelectorAll(".line .point");
                    
        for (var key in points) {
            
            var value = points[key];
            
            if ((key + 1) <= lvl) {
                value.classList.add("colored");
            } else {
                value.classList.remove("colored");
            }
            
        }

    }

}