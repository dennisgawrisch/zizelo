<?php
interface Zizelo_Storage_Interface {
    /**
     * Delete all documents for the index.
     * @param string $index_name
     * @return Zizelo_Storage_Interface $this
     */
    public function clearIndex($index_name);

    /**
     * Remove an existing document from the index.
     * @param string $index_name
     * @param integer $document_id
     * @return Zizelo_Storage_Interface $this
     */
    public function removeDocument($index_name, $document_id);

    /**
     * Add a new document to the index.
     * @param string $index_name
     * @param integer $document_id
     * @param array $words associative arrays with string fields "text" and "hash"
     * @return Zizelo_Storage_Interface $this
     * @throw Zizelo_Exception if document already exists
     */
    public function addDocument($index_name, $document_id, array $words);

    /**
     * Find documents containing the words matching at least some of the passed words by text and/or hash.
     * @param string $index_name
     * @param array $words associative arrays with string fields "text" and "hash"
     * @return array keys are identifiers of the documents, values are associative arrays with fields "text" and "hash", each containing number of correspondent matches for this document
     */
    public function findDocuments($index_name, array $words);
}