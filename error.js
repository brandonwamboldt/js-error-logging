window.onerror = function(error, file, line) {
    if (typeof jQuery != 'undefined') {
        var error = {
            error : error,
            file  : file,
            line  : line
        }
        $.get('/report-errors.php', error);
    } else {
        var err = document.createElement('script');
        err.src = '/report-errors.php?line=' + line + '&file=' + encodeURIComponent(file) + '&error=' + encodeURIComponent(error);

       var s = document.getElementsByTagName('script')[0];
       s.parentNode.insertBefore(err, s);
    }

    return false;
}