class Popup {

    static open(id) {

        document.getElementById(id).style.visibility = "visible";

    }

    static close(id) {

        document.getElementById(id).style.visibility = "hidden";

    }

}