class Dropdown {

    // status = true -> show
    // status = false -> hide

    constructor(trigger, target, status) {
        this.trigger = trigger;
        this.target = target;
        this.status = status;
        this.toHide = [];

        if (this.status == true) {
            this.show();
        } else {
            this.hideText();
            this.hideDiv();
        }

    }

    set toHideElem(toHide) {
        this.toHide = toHide;
    }

    set statusVal(status) {
        this.status = status;
    }

    get statusVal() {
        return this.status;
    }

    switch_status() {
        if (this.status == true) {
            this.hide();
        } else if (this.status == false) {
            this.show();
        }
    }

    hideText() {
        this.target.style.color = "rgba(0, 0, 0, 0)";
    }

    hideDiv() {
        this.target.style.height = "0px";
    }

    hideColor() {
        this.trigger.style.backgroundColor = "unset";
    }

    hide() {
        this.status = false;
        this.trigger.style.backgroundColor = "unset";
        this.target.style.color = "rgba(0, 0, 0, 0)";
        setTimeout(() => {
            this.target.style.height = "0px";
        }, 200);
    }

    show() {
        this.status = true;
        this.trigger.style.backgroundColor = "rgba(0, 0, 0, 0.144)";
        let check = false;
        let timeout = 0;
        this.toHide.forEach(elem => {
            if (elem.statusVal) check++;
        });
        if (check > 0) {
            this.toHide.forEach(elem => {
                elem.hideText();
                elem.hideColor();
                elem.statusVal = false;
            });
            timeout = 200;
        }
        setTimeout(() => {
            this.target.style.height = this.target.scrollHeight + "px";
            this.toHide.forEach(elem => {
                elem.hideDiv();
            });
            setTimeout(() => {
                this.target.style.color = "inherit";
            }, 300);
        }, timeout);

    }

}