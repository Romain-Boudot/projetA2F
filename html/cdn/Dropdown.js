class Dropdown {

    // status = true -> show
    // status = false -> hide

    constructor(trigger, target, status) {
        this.trigger = trigger;
        this.target = target;
        this.status = status;

        if (this.status == true) {
            this.target.style.height = this.target.scrollHeight + "px";
            this.trigger.style.backgroundColor = "rgba(0, 0, 0, 0.144)";
        } else {
            this.target.style.height = "0px";
            this.trigger.style.backgroundColor = "unset";
        }

    }

    set toHideElem(toHide) {
        this.toHide = toHide;
    }

    switch_status() {
        if (this.status == true) {
            this.status = false;
            this.target.style.height = "0px";
            this.trigger.style.backgroundColor = "unset";
        } else if (this.status == false) {
            this.status = true;
            this.target.style.height = this.target.scrollHeight + "px";
            this.trigger.style.backgroundColor = "rgba(0, 0, 0, 0.144)";
            this.toHide.forEach(elem => {
                elem.hide();
            });
        }
    }

    hide() {
        this.status = false;
        this.target.style.height = "0px";
        this.trigger.style.backgroundColor = "unset";
    }

}