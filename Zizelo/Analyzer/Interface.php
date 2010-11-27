<?php
interface Zizelo_Analyzer_Interface {
    /**
     * Extract words from the text and calculate their hashes.
     * @param string $text
     * @return array associative arrays with string fields "text" and "hash"
     */
    public function extractWords($text);
}