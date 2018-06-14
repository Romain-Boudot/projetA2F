class Dropdown {

    static load() {

        // --------- dropdown -----------

        var triggers = document.querySelectorAll(".dropdownTrigger")

        triggers.forEach(trigger => {

            // close div.dropdownBack
            document.getElementById("ddc" + trigger.id.slice(3)).style.height = "0px";


            trigger.addEventListener("click", (e) => {

                // current id of the foreach 
                if (typeof e.target.trigger === "undefined") return;

                let id = e.target.trigger.id.slice(3);

                let c = document.getElementById("ddc" + id);

                if (c.style.height == "0px") {

                    c.style.height = c.scrollHeight + "px";
                    setTimeout(() => {
                        c.style.height = "auto";
                    }, 300);

                } else {

                    c.style.height = c.scrollHeight + "px";
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

            // close div.ongletBack
            document.getElementById("oc" + trigger.id.slice(2)).style.height = "0px";
            document.getElementById("oc" + trigger.id.slice(2)).style.color = "rgba(0, 0, 0, 0)";

            trigger.addEventListener("click", (e) => {

                // current id of the foreach 
                let id = e.target.trigger.id.slice(2);

                let c = document.getElementById("oc" + id);

                if (c.style.height == "0px") {

                    if (document.getElementById("onglets-wrapper"))
                        document.getElementById("onglets-wrapper").classList.add("shadow");
                    document.querySelectorAll(".ongletTrigger").forEach(trig => {

                        if (trig != trigger) {
                            trig.style.backgroundColor = "rgba(0, 0, 0, .1)";
                            //document.getElementById("oc" + trig.id.slice(2)).style.color = "rgba(0, 0, 0, 0)";
                        } else {
                            trig.style.backgroundColor = "unset";
                        }

                        setTimeout(() => {


                            if (trig != trigger && document.getElementById("oc" + trig.id.slice(2)).style.height != "0px") {

                                document.getElementById("oc" + trig.id.slice(2)).style.height = document.getElementById('oc' + trig.id.slice(2)).scrollHeight + "px";
                                setTimeout(() => {
                                    document.getElementById("oc" + trig.id.slice(2)).style.height = "0px";
                                }, 50);

                            } else {

                                setTimeout(() => {

                                    c.style.height = document.getElementById('oc' + id).scrollHeight + "px";

                                    setTimeout(() => {

                                        c.style.height = "auto";
                                        c.style.color = "inherit";

                                    }, 300);

                                }, 50);

                            }

                        }, 150);

                    })

                } else {

                    e.target.trigger.style.backgroundColor = "rgba(0, 0, 0, .1)";
                    //c.style.color = "rgba(0, 0, 0, 0)";
                    c.style.height = document.getElementById('oc' + id).scrollHeight + "px";
                    if (document.getElementById("onglets-wrapper"))
                        document.getElementById("onglets-wrapper").classList.remove("shadow");

                    setTimeout(() => {

                        c.style.height = "0px";

                    }, 150);

                }

            });

            trigger.trigger = trigger;

        });

    }

    constructor() {

    }

}