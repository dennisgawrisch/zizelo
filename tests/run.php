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

class Zizelo_Test_Basic extends Zizelo_Test {
    public function setUp() {
    }

    public function testEmpty() {
        $this->search("Who killed Kennedy");
        $this->findNothing();
    }
}

$test = new Zizelo_Test_Basic();
$test->setUp();
foreach (get_class_methods($test) as $method) {
    if (substr($method, 0, 4) == "test") {
        try {
            $test->$method();
        } catch (Zizelo_Test_Exception $e) {
            print "$method failed" . PHP_EOL;
        }
    }
}
