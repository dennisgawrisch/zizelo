<?php
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