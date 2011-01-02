<?php
abstract class Zizelo_Test {
    protected $document_ids = array();
    protected $search_index;
    protected $matches;

    public function __construct() {
        $pdo = new PDO("sqlite::memory:");
        $pdo->exec(file_get_contents(dirname(__FILE__) . "/../sql/create-tables.sqlite.sql"));
        Zizelo_Facade::setDefaultStorage(new Zizelo_Storage_Pdo($pdo));
        $this->search_index = Zizelo_Facade::getIndex("things");
    }

    abstract public function setUp();

    protected function addDocument($text) {
        $title = is_array($text) ? $text[0] : $text;
        $id = count($this->document_ids) + 1;
        $this->document_ids[$title] = $id;
        $this->search_index->addDocument($id, $text);
    }

    protected function search($text) {
        $this->matches = $this->search_index->search($text);
    }

    protected function findNothing() {
        if (!empty($this->matches)) {
            throw new Zizelo_Test_Exception("Must find nothing");
        }
    }

    protected function find($title) {
        if (!in_array($this->getDocumentIdByTitle($title), $this->matches)) {
            throw new Zizelo_Test_Exception("Must find '$title'");
        }
    }

    protected function findOnly($title) {
        if (array($this->getDocumentIdByTitle($title)) != $this->matches) {
            throw new Zizelo_Test_Exception("Must find '$title' only");
        }
    }

    protected function findNot($title) {
        if (in_array($this->getDocumentIdByTitle($title), $this->matches)) {
            throw new Zizelo_Test_Exception("Must not find '$title'");
        }
    }

    protected function getDocumentIdByTitle($title) {
        return isset($this->document_ids[$title]) ? $this->document_ids[$title] : 0;
    }
}

class Zizelo_Test_Exception extends Exception {
}