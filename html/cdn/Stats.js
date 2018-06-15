Element.prototype.appendAfter = function (element) {
    element.parentNode.insertBefore(this, element.nextSibling);
},false;

Element.prototype.appendBefore = function (element) {
    element.parentNode.insertBefore(this, element);
},false;

class Stats {

    static get_stats(id) {

        var wrapper = document.querySelector('.graphWrapper');
        wrapper.innerHTML = "<div class='loader'></div>";
        Ajax.get("/recherche/stats/traitement.php?id=" + id, Stats.add_stats);

    }

    static add_stats(dataText) {

        console.log(dataText);

        var data = JSON.parse(dataText);
        if (data[0] == -1) return false;

        if (document.getElementById(data.id) != null) return false;

        var wrapper = document.querySelector('.graphWrapper');
        wrapper.innerHTML = "";

        var div = document.createElement("div");
        div.id = data.id;
        div.classList.add("graph")
        wrapper.appendChild(div);

        var grid1 = document.createElement("div")
        var grid2 = document.createElement("div")

        div.appendChild(grid1);
        div.appendChild(grid2);

        var canvas1 = document.createElement("canvas")
        canvas1.id = "g1" + data.id;
        grid1.appendChild(canvas1);
        let title = document.createElement("div");
        title.innerText = "Nombre de consultants ayant un niveau supérieur ou égal à 2"
        title.appendBefore(canvas1);

        var canvas2 = document.createElement("canvas")
        canvas2.id = "g2" + data.id;
        grid2.appendChild(canvas2)
        let title2 = document.createElement("div");
        title2.innerText = "Niveau moyen des consultants"
        title2.appendBefore(canvas2);
        
        new Chart(canvas1, chartOptionBaton.test(
            data.G1.data,
            data.G1.label,
            {
                "stepSize": 1,
                "beginAtZero": true
            }
        ));

        new Chart(canvas2, chartOptionBaton.test(
            data.G2.data,
            data.G2.label,
            {
                "max": 3,
                "stepSize": 0.5,
                "beginAtZero": true
            }
        ));
    }

}