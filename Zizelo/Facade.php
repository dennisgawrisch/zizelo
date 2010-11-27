<?php
class Zizelo_Facade {
    const RELEVANCE_TEXT    = 1.0;
    const RELEVANCE_HASH    = 0.5;
    const RELEVANCE_MINIMAL = 0.17;

    private static $default_storage;
    private static $default_analyzer;
    private static $indexes = array();
    protected $analyzer;
    protected $name;

    /**
     * Set the default storage of indexes.
     * @param Zizelo_Storage_Interface $storage
     */
    public static function setDefaultStorage(Zizelo_Storage_Interface $storage) {
        self::$default_storage = $storage;
    }

    /**
     * Set the default text analyzer.
     * @param Zizelo_Analyzer_Interface $analyzer
     */
    public static function setDefaultAnalyzer(Zizelo_Analyzer_Interface $analyzer) {
        self::$default_analyzer = $default_analyzer;
    }

    /**
     * Get Zizelo_Facade instance for named index.
     * @param string $name
     * @return Zizelo_Facade
     * @todo probably we should allow to specify a different storage for a particular index
     * @throw Zizelo_Exception on empty name
     */
    public static function getIndex($name) {
        $name = (string)$name;
        if (empty($name)) {
            throw new Zizelo_Exception("Empty index name is not allowed");
        }
        if (!isset(self::$indexes[$name])) {
            self::$indexes[$name] = new self($name);
        }
        return self::$indexes[$name];
    }

    final private function __clone() {}

    final public function __wakeup() {
        throw new Exception(get_class($this) . " cannot be deserialized");
    }

    /**
     * @param string $name name of the index
     */
    protected function __construct($name) {
        $this->name = $name;
    }

    /**
     * Add a new document to the index.
     * @param integer $id
     * @param string $text
     * @return Zizelo_Facade
     * @throw Zizelo_Exception on empty document (no word can be extracted)
     * @throw Zizelo_Exception if document already exists
     */
    public function addDocument($id, $text) {
        $words = $this->getAnalyzer()->extractWords($text);
        if (empty($words)) {
            throw new Zizelo_Exception("No word can be extracted from this document, it seems empty");
        }
        $this->getStorage()->addDocument($this->getName(), $id, $words);
        return $this;
    }

    /**
     * Remove an existing document from the index.
     * @param integer $id
     * @return Zizelo_Facade
     */
    public function removeDocument($id) {
        $this->getStorage()->removeDocument($this->getName(), $id);
        return $this;
    }

    /**
     * Remove all documents from the index.
     * @return Zizelo_Facade
     */
    public function clear() {
        $this->getStorage()->clearIndex($this->getName());
        return $this;
    }

    /**
     * Search documents within the index.
     * @param string $text search query
     * @return array identifiers of the matched documents
     */
    public function search($text) {
        $words = $this->getAnalyzer()->extractWords($text);
        if (empty($words)) {
            return array();
        }

        $documents = $this->getStorage()->findDocuments($this->getName(), $words);
        if (empty($documents)) {
            return array();
        }

        $matches = array();

        $perfect_match_relevance = self::RELEVANCE_TEXT + self::RELEVANCE_HASH;
        $perfect_match_ids = array();

        foreach ($documents as $document_id => $document) {
            $relevance = ($document["text"] * self::RELEVANCE_TEXT + $document["hash"] * self::RELEVANCE_HASH) / count($words);
            if ($relevance >= self::RELEVANCE_MINIMAL) {
                $matches[$document_id] = $relevance;
            }
            if ($relevance >= $perfect_match_relevance) {
                $perfect_match_ids []= $document_id;
            }
        }

        if (1 == count($perfect_match_ids)) {
            return $perfect_match_ids;
        } else {
            arsort($matches, SORT_NUMERIC);
            return array_keys($matches);
        }
    }

    /**
     * Set text analyzer, if it needs to be different from the default.
     * @param Zizelo_Analyzer_Interface $analyzer
     * @return Zizelo_Facade
     */
    public function setAnalyzer(Zizelo_Analyzer_Interface $analyzer) {
        $this->analyzer = $analyzer;
        return $this;
    }

    /**
     * Get text analyzer for this index.
     * @return Zizelo_Analyzer_Interface
     */
    protected function getAnalyzer() {
        if (empty($this->analyzer)) {
            if (empty(self::$default_analyzer)) { // default default analyzer
                self::$default_analyzer = new Zizelo_Analyzer_Default();
            }
            $this->analyzer = self::$default_analyzer;
        }
        return $this->analyzer;
    }

    /**
     * Get storage for this index.
     * @return Zizelo_Storage_Interface
     */
    protected function getStorage() {
        return self::$default_storage;
    }

    /**
     * Get name of this index.
     * @return string
     */
    protected function getName() {
        return $this->name;
    }
}