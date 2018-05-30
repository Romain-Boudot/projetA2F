class Popup {

    static open(id, ...triggers) {

        document.querySelectorAll(".popup").forEach(e => {
            e.style.visibility = "hidden";
        })

        document.getElementById(id).style.visibility = "visible";

        triggers.forEach(e => {
            if (e.onPopupOpen) {
                e.onPopupOpen();
            }
        })

    }

    static close(id, ...triggers) {

        document.getElementById(id).style.visibility = "hidden";

        triggers.forEach(e => {
            if (e.onPopupClose) {
                e.onPopupClose();
            }
        })

    }

}