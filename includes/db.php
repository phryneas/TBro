<?php
require_once __DIR__.'/constants.php';
if (!defined('VERBOSE')) define('VERBOSE', false);
if (!defined('DEBUG')) define('DEBUG', false);

try {
    global $db;
    $connstr = sprintf('pgsql:host=%s;dbname=%s', DB_SERVER, DB_DB);
    if (VERBOSE || DEBUG) {
        require_once __DIR__.'/libs/loggedPDO/LoggedPDO.php';
        require_once __DIR__.'/libs/loggedPDO/Log_firebugJSON.php';
        $logger = Log::factory('firebugJSON', '', 'PDO');
        //$logger = Log::singleton('firebug', '', 'PDO');
        $db = new \LoggedPDO\PDO($connstr, DB_USERNAME, DB_PASSWORD, null, $logger);
        //$db->log_replace_params = false;
    } else {
        $db = new PDO($connstr, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    }
    #usually stop execution on DB error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #in debug mode, try to continue and output warning
    #DEBUG && $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
