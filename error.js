window.onerror = (function (server_script) {
    "use strict";

    return function (error, file, line) {
        var err, params, script;

        if (typeof jQuery !== 'undefined') {
            params = {
                error : error,
                file  : file,
                line  : line
            };

            jQuery.get(server_script, params);
        } else {
            err     = document.createElement('script');
            err.src = server_script + '?line=' + line + '&file=' + encodeURIComponent(file) + '&error=' + encodeURIComponent(error);

            script = document.getElementsByTagName('script')[0];
            script.parentNode.insertBefore(err, script);
        }

        return false;
    };
}('/report-errors.php'));
