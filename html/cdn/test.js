class Dropdown {

    static load() {

        // --------- dropdown -----------

        var triggers = document.querySelectorAll(".dropdownTrigger")

        triggers.forEach(trigger => {

            // close div.dropdownBack
            document.getElementById("ddb" + trigger.id.slice(3, 4)).style.height = "0px";


            trigger.addEventListener("click", (e) => {

                // current id of the foreach 
                let id = e.target.trigger.id.slice(3, 4);

                let c = document.getElementById("ddb" + id);
                
                if (c.style.height == "0px") {

                    c.style.height = document.getElementById('ddc' + id).scrollHeight + "px";
                    setTimeout(() => {
                        c.style.height = "auto";
                    }, 300);

                } else {
                    
                    c.style.height = document.getElementById('ddc' + id).scrollHeight + "px";
                    setTimeout(() => {
                        c.style.height = "0px";
                    }, 50);

                }

            });
            trigger.trigger = trigger;

        });

        // --------- onglet -----------        

        var triggers = document.querySelectorAll(".ongletTrigger")

        triggers.forEach(trigger => {


            document.getElementById("ob" + trigger.id.slice(3, 4)).style.height = "0px";
            document.getElementById("oc" + trigger.id.slice(3, 4)).style.color = "rgba(0, 0, 0, 0)";
            trigger.addEventListener("click", (e) => {

                let id = e.target.trigger.id.slice(3, 4);
                let c = document.getElementById("ob" + id);
                if (c.style.height == "0px") {

                    // btn background color set to dark;
                    e.target.trigger.style.backgroundColor = "rgba(0, 0, 0, 0.144)";

                    // for each other onglet set text to invisble
                    document.querySelectorAll('.ongletContainer').forEach(a => {
                        if (a.id != "oc" + id) {
                            a.style.color = "rgba(0, 0, 0, 0)";
                        }
                    });

                    // for each onglet resize them
                    document.querySelectorAll('.ongletBack').forEach(a => {
                        if (a.id != "ob" + id) {

                            a.style.height = "0px";
                        } else {
                            a.style.height = document.getElementById('oc' + id).scrollHeight + "px";
                        }
                    })
                    setTimeout(() => {
                        c.style.height = "auto";
                    }, 300);

                    
                } else { // elseeeeeeeeeeeeeeeeeeeeeeee
                    
                    e.target.trigger.style.backgroundColor = "uneset";

                    c.style.height = document.getElementById('oc' + id).scrollHeight + "px";
                    setTimeout(() => {
                        c.style.height = "0px";
                    }, 50);

                }

            });
            trigger.trigger = trigger;

        });

    }

    constructor() {

    }

}