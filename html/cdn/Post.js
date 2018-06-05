class Post {

    static send(location, arg) {

        var form = '<form id="eflqpozdkoaPDOKpzd" action="' + location + '" method="post">';
        for (var a in arg) {
            form += '<input type="hidden" name="' + a + '" value="' + arg[a] + '"/>';
        };
        form += '</form>';
        document.body.innerHTML += form;
        document.getElementById('eflqpozdkoaPDOKpzd').submit();

    }

}