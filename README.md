JavaScript Error Logging
========================

With the amount of JavaScript typically involved in a modern website, it becomes incredibly important to have error logging for client-side JavaScript errors, not just server side errors. It makes tracking down issues a user is having much easier. 

This is a simple script that serves as a functional example of how you could do that. It provides a JavaScript error handler via `window.onerror` that sends the file an error occured in, the line number, and the error itself to a simple script on the server. It does that via jQuery or falls back to loading a `<script>` tag.

Dependencies
------------

This script has no dependencies. It will use jQuery if it's available though.

Installation/Usage
------------------ 

Load `error.js` as the first script on every page. This way it will log errors in any third party script you may load.

You must either put `report-errors.php` in the root directory of your site so it is accessible via `http://example.com/report-errors.php` or change the location of the PHP file in `error.js`.

Configuration
-------------

By default, logs are stored in the same directory as your PHP error logs (by reading the `error_log` configuration directive in PHP). You can change this in the PHP file via the constant `JS_ERROR_LOG`. 

The script also limits the maximum number of logs to keep (1000 lines) and will trim older logs. This is to prevent malicious activity from filling up your server's hard disk capacity, however, feel free to change this.

Example Logs
------------

```
127.0.0.1 [Mar 07, 2013 10:52:42] "http://localhost/js/error.js:20" "Uncaught ReferenceError: fakeFunction is not defined"
127.0.0.1 [Mar 07, 2013 10:52:42] "http://localhost/index.php:27" "Uncaught ReferenceError: noSuchFunction is not defined"
127.0.0.1 [Mar 07, 2013 11:11:42] "http://localhost/js/error.js:19" "Uncaught ReferenceError: fakeFunction is not defined"
127.0.0.1 [Mar 07, 2013 11:13:37] "http://localhost/js/error.js:19" "Uncaught ReferenceError: fakeFunction is not defined"
```