<?php
abstract class Zizelo_Test {
    protected $documents = array();
    protected $search_index;
    protected $query;
    protected $matches;

    public function __construct() {
        $pdo = new PDO("sqlite::memory:");
        $pdo->exec(file_get_contents(dirname(__FILE__) . "/../sql/create-tables.sqlite.sql"));
        Zizelo_Facade::setDefaultStorage(new Zizelo_Storage_Pdo($pdo));
        $this->search_index = Zizelo_Facade::getIndex("things");
    }

    abstract public function setUp();

    protected function addDocument($text) {
        $id = count($this->documents) + 1;
        $this->documents []= array(
            "id"    => $id,
            "text"  => $text,
            "title" => is_array($text) ? $text[0] : $text,
        );
        $this->search_index->addDocument($id, $text);
    }

    protected function search($text) {
        $this->query = $text;
        $matches = $this->search_index->search($text);
        $this->matches = array();
        foreach ($this->documents as $document) {
            if (in_array($document["id"], $matches)) {
                $this->matches []= $document["title"];
            }
        }
    }

    protected function findNothing() {
        if (!empty($this->matches)) {
            $this->fail("Must find nothing");
        }
    }

    protected function find($title) {
        if (!in_array($title, $this->matches)) {
            $this->fail("Must find '$title'");
        }
    }

    protected function findOnly($title) {
        if (array($title) != $this->matches) {
            $this->fail("Must find '$title' only");
        }
    }

    protected function findNot($title) {
        if (in_array($title, $this->matches)) {
            $this->fail("Must not find '$title'");
        }
    }

    protected function fail($message) {
        throw new Zizelo_Test_Exception($message, $this->query, $this->matches);
    }
}

class Zizelo_Test_Exception extends Exception {
    protected $query;
    protected $matches;

    public function __construct($message, $query, array $matches) {
        parent::__construct($message);
        $this->query = $query;
        $this->matches = $matches;
    }

    public function getQuery() {
        return $this->query;
    }

    public function getMatches() {
        return $this->matches;
    }
}