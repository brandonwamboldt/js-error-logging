<?php
// File to log JavaScript errors to. Defaults to a file in the same directory
// that PHP errors are stored in
define('JS_ERROR_LOG', dirname(ini_get('error_log')) . '/js_errors');

// Maximum number of errors to log to the file, excess logs will be trimmed 
// from the oldest entries
define('MAX_LOGS', 1000);

// Maximum length of the JavaScript error message. We use this to prevent a 
// malicious user from overwhelming our disk space with garbage
define('MAX_ERROR_LENGTH', 1000);

// Output JavaScript content type since the fallback method uses a <script> tag
// to submit the error which expects
header('Content-Type: text/javascript');

// Make sure we can actually write to the error file, otherwise just exit the
// script.
if (file_exists(JS_ERROR_LOG) && is_writable(JS_ERROR_LOG)) {
    $log = file_get_contents(JS_ERROR_LOG);
} elseif (!file_exists(JS_ERROR_LOG) && is_writable(JS_ERROR_LOG)) {
    $log = '';
} elseif (file_exists(JS_ERROR_LOG) && !is_writable(JS_ERROR_LOG)) {
    exit;
} elseif (!file_exists(JS_ERROR_LOG) && !is_writable(dirname(JS_ERROR_LOG))) {
    exit;
}

// Make sure an error was provided and it was under our max size
if (!isset($_GET['error']) || strlen($_GET['error']) > MAX_ERROR_LENGTH) {
    exit;
}

// Make sure an error was provided and it was under our max size
if (!isset($_GET['file']) || strlen($_GET['file']) > 255) {
    exit;
}

// Split the log file by newline
$entries = explode("\n", $log);

// Only allow 1000 log entries to avoid super large files
if (count($entries) > MAX_LOGS) {
    $entries = array_slice($entries, 0, -1);
}

// Variables
$file = str_replace(array("\r\n", "\n", "\t"), '', $_GET['file']);
$line = (int) $_GET['line'];

// Write the updated log file
$entries[] = sprintf(
    '%s [%s] "%s:%d" %s',
    $_SERVER['REMOTE_ADDR'],
    date('M d, Y H:i:s'),
    $file,
    $line,
    json_encode($_GET['error'])
);

file_put_contents(JS_ERROR_LOG, implode("\n", $entries));
