<?php
abstract class Zizelo_Test {
    protected $index;

    public function __construct() {
        $pdo = new PDO("sqlite::memory:");
        $pdo->exec(file_get_contents(dirname(__FILE__) . "/../sql/create-tables.sqlite.sql"));
        Zizelo_Facade::setDefaultStorage(new Zizelo_Storage_Pdo($pdo));
        $this->index = Zizelo_Facade::getIndex("things");
    }

    abstract public function setUp();

    protected function assert($condition) {
        if (!$condition) {
            throw new Zizelo_Test_Exception;
        }
    }
}

class Zizelo_Test_Exception extends Exception {
}