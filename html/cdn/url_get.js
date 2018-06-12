class url_get {

    static $_GET() {

        var get = {}
    
        var a = location.search.replace("?", "").split("&")
    
        for (var e in a) {
    
            e = a[e].split("=");
            get[e[0]] = e[1];
    
        }
    
        return get;
        
    }

}