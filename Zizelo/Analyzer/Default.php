<?php
class Zizelo_Analyzer_Default implements Zizelo_Analyzer_Interface {
    protected $nonalphanum = "/[^0-9a-zа-яёϧґєїіў]/u"; // TODO letters of all languages/scripts
    protected $inword_punctuation = "/['’]/u";

    protected $translit = array(
        // Russian
        "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "ie", "ё" => "io", "ж" => "zh",
        "з" => "z", "и" => "i", "й" => "i", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o",
        "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "ts",
        "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "", "ы" => "i", "ь" => "", "э" => "e", "ю" => "iu",
        "я" => "ia",

        // Ukrainian
        "ґ" => "g", "є" => "ie", "і" => "i", "ї" => "i", "ϧ" => "o", "ў" => "w",

        // TODO Japanese
        // TODO Latin diacritics
    );
    protected $similar_letters = array(
        "w" => "v", "u" => "v", "y" => "i", "j" => "i", "z" => "s", "x" => "ks", "c" => "k", "q" => "k",
    );
    protected $meaningless_for_hash = "/[euioahv]/";

    /*
     * Words with hyphens are treated in two ways simultaneously:
     * “simple-minded” → “simple minded simpleminded”
     * @param array $matches as described in preg_replace_callback
     * @return string
     */
    public function handleHyphensCallback($matches) {
        return str_replace("-", " ", $matches[0]) . " " . str_replace("-", "", $matches[0]);
    }

    /**
     * Remove meaningless characters, leaving normalized words separated by single space.
     * @param string $text
     * @return string
     */
    protected function processText($text) {
        $text = mb_strtolower($text);
        $text = preg_replace($this->inword_punctuation, "", $text);
        $text = preg_replace_callback("/\\S+\\-\\S+/", array($this, "handleHyphensCallback"), $text);
        $text = preg_replace($this->nonalphanum, " ", $text);
        $text = preg_replace("/\\s+/u", " ", trim($text));
        return $text;
    }

    /**
     * Get the hash of the word.
     * @param string $word
     * @return string
     */
    protected function getHash($word) {
        $word = strtr($word, $this->translit);
        $word = strtr($word, $this->similar_letters);
        $word = preg_replace($this->meaningless_for_hash, "", $word);
        $word = preg_replace("/(.)\\1+/", "$1", $word);
        return $word;
    }

    /**
     * Extract words from the text and calculate their hashes.
     * @param string $text
     * @return array associative arrays with string fields "text" and "hash"
     */
    public function extractWords($text) {
        $text = $this->processText($text);

        $words_strings = explode(" ", $text);
        $words_strings = array_unique($words_strings);

        $words = array();
        foreach ($words_strings as $word) {
            $words []= array(
                "text" => $word,
                "hash" => $this->getHash($word),
            );
        }
        return $words;
    }
}