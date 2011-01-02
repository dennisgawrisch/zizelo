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

class Zizelo_Test {
    protected $index;

    public function setUp() {
        $pdo = new PDO("sqlite::memory:");
        $pdo->exec(file_get_contents(dirname(__FILE__) . "/../sql/create-tables.sqlite.sql"));
        Zizelo_Facade::setDefaultStorage(new Zizelo_Storage_Pdo($pdo));

        $this->index = Zizelo_Facade::getIndex("things");

        $this->index->addDocument(1, "About a Silence in Literature");
        $this->index->addDocument(2, "A Feast for the Seaweeds");
        $this->index->addDocument(3, "Alice’s Adventures in Wonderland");
        $this->index->addDocument(4, "All Quiet on the Western Front");
        $this->index->addDocument(5, "American Psycho");
        $this->index->addDocument(6, "Angaray");
        $this->index->addDocument(7, "Animal Farm");
        $this->index->addDocument(8, "Areopagitica");
        $this->index->addDocument(9, "A Spoon on Earth");
        $this->index->addDocument(10, "Bad Samaritans: The Myth of Free Trade and the Secret History of Capitalism");
        $this->index->addDocument(11, "Big River, Big Sea — Untold Stories of 1949");
        $this->index->addDocument(12, "Borstal Boy");
        $this->index->addDocument(13, "Brave New World");
        $this->index->addDocument(14, "Burger’s Daughter");
        $this->index->addDocument(15, "Candide");
        $this->index->addDocument(16, "The Country Girls");
        $this->index->addDocument(17, "Curved River");
        $this->index->addDocument(18, "The Da Vinci Code");
        $this->index->addDocument(19, "The Death of Lorca");
        $this->index->addDocument(20, "Dianetics");
        $this->index->addDocument(21, "The Diary of Anne Frank");
        $this->index->addDocument(22, "Dictionary of Modern Serbo-Croatian Language");
        $this->index->addDocument(23, "Doctor Zhivago");
        $this->index->addDocument(24, "Droll Stories");
        $this->index->addDocument(25, "The Devil’s Discus");
        $this->index->addDocument(26, "El Señor Presidente");
        $this->index->addDocument(27, "Fanny Hill or Memoirs of a Woman of Pleasure");
        $this->index->addDocument(28, "The Federal Mafia");
        $this->index->addDocument(29, "The Fugitive (Perburuan)");
        $this->index->addDocument(30, "The First Circle");
        $this->index->addDocument(31, "The Grapes of Wrath");
        $this->index->addDocument(32, "The Gulag Archipelago");
        $this->index->addDocument(33, "How to make disposable silencers");
        $this->index->addDocument(34, "Howl");
        $this->index->addDocument(35, "Islam - A Concept of Political World Invasion");
        $this->index->addDocument(36, "July’s People");
        $this->index->addDocument(37, "Jinnah: India-Partition-Independence");
        $this->index->addDocument(38, "Jinnah of Pakistan");
        $this->index->addDocument(39, "Jæger – i krig med eliten");
        $this->index->addDocument(40, "The King Never Smiles");
        $this->index->addDocument(41, "Lady Chatterley’s Lover");
        $this->index->addDocument(42, "Lajja");
        $this->index->addDocument(43, "Little Black Sambo");
        $this->index->addDocument(44, "Lolita");
        $this->index->addDocument(45, "The Lonely Girl");
        $this->index->addDocument(46, "The Lottery");
        $this->index->addDocument(47, "Madame Bovary");
        $this->index->addDocument(48, "Mein Kampf");
        $this->index->addDocument(49, "The Metamorphosis");
        $this->index->addDocument(50, "A Message to Man and Humanity");
        $this->index->addDocument(51, "Mirror of the Polish Crown");
        $this->index->addDocument(52, "The Mountain Wreath");
        $this->index->addDocument(53, "Military Incorporated");
        $this->index->addDocument(54, "Naked Lunch");
        $this->index->addDocument(55, "New Class");
        $this->index->addDocument(56, "The Nickel-Plated-Feet Gang During the Occupation");
        $this->index->addDocument(57, "Nineteen Eighty-Four");
        $this->index->addDocument(58, "Notre ami le roi");
        $this->index->addDocument(59, "Not Without My Daughter");
        $this->index->addDocument(60, "Nine Hours To Rama");
        $this->index->addDocument(61, "On Fierce Wound - Fierce Herb");
        $this->index->addDocument(62, "One Day of Life");
        $this->index->addDocument(63, "One Day in the Life of Ivan Denisovich");
        $this->index->addDocument(64, "Operation Dark Heart");
        $this->index->addDocument(65, "The Peaceful Pill Handbook");
        $this->index->addDocument(66, "Rangila Rasul");
        $this->index->addDocument(67, "Rights of Man");
        $this->index->addDocument(68, "The Satanic Verses");
        $this->index->addDocument(69, "Snorri the Seal");
        $this->index->addDocument(70, "Soft Target: How the Indian Intelligence Service Penetrated Canada");
        $this->index->addDocument(71, "The Song of the Red Ruby");
        $this->index->addDocument(72, "Smash and Grab: Annexation of Sikkim");
        $this->index->addDocument(73, "Spycatcher");
        $this->index->addDocument(74, "Storytellers II");
        $this->index->addDocument(75, "Suicide mode d’emploi");
        $this->index->addDocument(76, "Thalia");
        $this->index->addDocument(77, "The True Furqan");
        $this->index->addDocument(78, "Tropic of Cancer");
        $this->index->addDocument(79, "The Turner Diaries");
        $this->index->addDocument(80, "Ulysses");
        $this->index->addDocument(81, "Uncle Tom’s Cabin");
        $this->index->addDocument(82, "Understanding Islam through Hadis");
        $this->index->addDocument(83, "United States-Vietnam Relations: 1945-1967");
        $this->index->addDocument(84, "Uten en tråd");
        $this->index->addDocument(85, "Unarmed Victory");
        $this->index->addDocument(86, "Various works");
        $this->index->addDocument(87, "Watershed");
        $this->index->addDocument(88, "The Well of Loneliness");
        $this->index->addDocument(89, "Year 501: The Conquest Continues");
        $this->index->addDocument(90, "Zhuan Falun");
        $this->index->addDocument(91, "Aaaa");
        $this->index->addDocument(92, "Oooo");
        $this->index->addDocument(93, "Ryunosuke Akutagawa");
    }

    public function tearDown() {
    }

    protected function assert($condition) {
        if (!$condition) {
            throw new Zizelo_Test_Exception;
        }
    }

    public function testEmpty() {
        $matches = $this->index->search("Cheburashka");
        $this->assert(empty($matches));
    }

    public function testFindSingleWord() {
        $this->assert(in_array(87, $this->index->search("Watershed")));
    }

    public function testFindMultipleWords() {
        $this->assert(in_array(1, $this->index->search("About a Silence in Literature")));
    }

    public function testFindMultipleWordsBySingleWord() {
        $this->assert(in_array(1, $this->index->search("Silence")));
    }

    public function testMisorderedWords() {
        $this->assert(in_array(1, $this->index->search("Literature Silence")));
    }

    public function testBestMatchSingleWord() {
        $this->assert(array(87) == $this->index->search("Watershed"));
    }

    public function testBestMatchMultipleWords() {
        $this->assert(array(50) == $this->index->search("A Message to Man and Humanity"));
    }

    public function testFrequentWords() {
        $matches = $this->index->search("of the");
        $this->assert(empty($matches));
    }

    public function testWordsWithEmptyHash() {
        $matches = $this->index->search("aaaa");
        $this->assert(in_array(91, $matches));
        $this->assert(!in_array(92, $matches));

        $matches = $this->index->search("oooo");
        $this->assert(!in_array(91, $matches));
        $this->assert(in_array(92, $matches));
    }

    public function testLatinDiacritics() {
        $this->assert(in_array(26, $this->index->search("senor")));
    }

    public function testLetterU() {
        $this->assert(in_array(93, $this->index->search("ryunoske")));
    }

    public function testFuzzySearch() {
        $this->assert(in_array(15, $this->index->search("kandid")));
        $this->assert(in_array(21, $this->index->search("diary of Anna Frank")));
        $this->assert(in_array(80, $this->index->search("Uliss")));
        $this->assert(in_array(47, $this->index->search("madam bouwari")));
        $this->assert(in_array(48, $this->index->search("Mein Kammpf")));
    }

    public function testCyrillic() {
        $this->assert(in_array(18, $this->index->search("да винчи")));
        $this->assert(in_array(48, $this->index->search("майн кампф")));
        $this->assert(in_array(80, $this->index->search("улисс")));
        $this->assert(in_array(76, $this->index->search("талия")));
    }
}

class Zizelo_Test_Exception extends Exception {
}

$test = new Zizelo_Test();
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
$test->tearDown();
