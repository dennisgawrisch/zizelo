<?php
error_reporting(E_ALL);
mb_internal_encoding("UTF-8");

set_include_path(
    dirname(__FILE__) . "/../Zizelo"
    . PATH_SEPARATOR . get_include_path()
);

function __autoload($class_name) {
    require_once str_replace("_", DIRECTORY_SEPARATOR, $class_name) . ".php";
}

$test = new Zizelo_Test_Art();
$test->setUp();
foreach (get_class_methods($test) as $method) {
    if (substr($method, 0, 4) == "test") {
        try {
            $test->$method();
        } catch (Zizelo_Test_Exception $exception) {
            print $method . " failed" . PHP_EOL;
            print "\t" . $exception->getMessage() . PHP_EOL;
            print "\t" . "Query: " . $exception->getQuery() . PHP_EOL;
            print "\t" . "Found:" . PHP_EOL;
            foreach ($exception->getMatches() as $i => $match) {
                if ($i >= 5) {
                    print "\t\t… and more (" . count($exception->getMatches()) . " total)" . PHP_EOL;
                    break;
                }
                print "\t\t" . $match . PHP_EOL;
            }
        }
    }
}
