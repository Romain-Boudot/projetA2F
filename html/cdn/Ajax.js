class Ajax {

    static getXMLHttpRequest() {

        var xhr = null;
    
        if (window.XMLHttpRequest || window.ActiveXObject) {
    
            if (window.ActiveXObject) {
    
                try {
    
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
    
                } catch(e) {
    
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
    
                }
    
            } else {
    
                xhr = new XMLHttpRequest(); 
    
            }
    
        } else {
    
            alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
    
            return null;
    
        }
    
        return xhr;
    
    }

    static get(url, callback) {

        var xhr = Ajax.getXMLHttpRequest();

        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

                callback(xhr.responseText);

            }

        };

        xhr.open("GET", url, true);

        xhr.send(null);

    }

    static post(url, param, callback) {

        var xhr = Ajax.getXMLHttpRequest();

        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

                callback(xhr.responseText);

            }

        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(param);

    }

    static file(url, param, callback) {

        var xhr = Ajax.getXMLHttpRequest();

        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

                callback(xhr.responseText);

            }

        };

        xhr.open("POST", url, true);

        xhr.send(param);

    }

}