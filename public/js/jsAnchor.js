$(document).ready(function() {

    var x = location.pathname;
    x = x.replace("/","");

    if (x > 8) {
        location.hash = 'hash';
    }

});
