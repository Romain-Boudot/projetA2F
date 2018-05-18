class Dropdown {

    // status = true -> show
    // status = false -> hide

    constructor(trigger, target, status, parent = null, toHide = []) {

        this.trigger = document.getElementById(trigger);
        this.target = document.getElementById(target);
        this.status = status;
        this.toHide = toHide;

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
   
        this.target.style.maxHeight = "0px";
   
    }

    hideColor() {
   
        this.trigger.style.backgroundColor = "unset";
   
    }

    hide() {
        
        this.status = false;
        this.trigger.style.backgroundColor = "unset";
        this.target.style.color = "rgba(0, 0, 0, 0)";

        setTimeout(() => {
    
            this.target.style.maxHeight = "0px";
            if (this.parent != null) this.parent.update();
    
        }, 200);
    
    }

    show() {

        this.status = true;
        this.trigger.style.backgroundColor = "rgba(0, 0, 0, 0.144)";
        let check = false;
        let timeout = 0;
        this.toHide.forEach(elem => {

            if (elem.statusVal) check = true;

        });
        if (check) {

            this.toHide.forEach(elem => {

                elem.hideText();
                elem.hideColor();
                elem.statusVal = false;

            });

            timeout = 200;

        }

        setTimeout(() => {

            this.target.style.maxHeight = this.target.scrollHeight + "px";
            this.toHide.forEach(elem => {

                elem.hideDiv();

            });
            setTimeout(() => {
      
                if (this.parent != null) this.parent.update();
      
            }, 20);
            setTimeout(() => {

                this.target.style.color = "inherit";

            }, 300);

        }, timeout);

    }

}