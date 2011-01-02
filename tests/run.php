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

$pdo = new PDO("sqlite::memory:");
$pdo->exec(file_get_contents(dirname(__FILE__) . "/../sql/create-tables.sqlite.sql"));
Zizelo_Facade::setDefaultStorage(new Zizelo_Storage_Pdo($pdo));

$index = Zizelo_Facade::getIndex("books");

$index->addDocument(1, "About a Silence in Literature");
$index->addDocument(2, "A Feast for the Seaweeds");
$index->addDocument(3, "Alice’s Adventures in Wonderland");
$index->addDocument(4, "All Quiet on the Western Front");
$index->addDocument(5, "American Psycho");
$index->addDocument(6, "Angaray");
$index->addDocument(7, "Animal Farm");
$index->addDocument(8, "Areopagitica");
$index->addDocument(9, "A Spoon on Earth");
$index->addDocument(10, "Bad Samaritans: The Myth of Free Trade and the Secret History of Capitalism");
$index->addDocument(11, "Big River, Big Sea — Untold Stories of 1949");
$index->addDocument(12, "Borstal Boy");
$index->addDocument(13, "Brave New World");
$index->addDocument(14, "Burger’s Daughter");
$index->addDocument(15, "Candide");
$index->addDocument(16, "The Country Girls");
$index->addDocument(17, "Curved River");
$index->addDocument(18, "The Da Vinci Code");
$index->addDocument(19, "The Death of Lorca");
$index->addDocument(20, "Dianetics");
$index->addDocument(21, "The Diary of Anne Frank");
$index->addDocument(22, "Dictionary of Modern Serbo-Croatian Language");
$index->addDocument(23, "Doctor Zhivago");
$index->addDocument(24, "Droll Stories");
$index->addDocument(25, "The Devil’s Discus");
$index->addDocument(26, "El Señor Presidente");
$index->addDocument(27, "Fanny Hill or Memoirs of a Woman of Pleasure");
$index->addDocument(28, "The Federal Mafia");
$index->addDocument(29, "The Fugitive (Perburuan)");
$index->addDocument(30, "The First Circle");
$index->addDocument(31, "The Grapes of Wrath");
$index->addDocument(32, "The Gulag Archipelago");
$index->addDocument(33, "How to make disposable silencers");
$index->addDocument(34, "Howl");
$index->addDocument(35, "Islam - A Concept of Political World Invasion");
$index->addDocument(36, "July’s People");
$index->addDocument(37, "Jinnah: India-Partition-Independence");
$index->addDocument(38, "Jinnah of Pakistan");
$index->addDocument(39, "Jæger – i krig med eliten");
$index->addDocument(40, "The King Never Smiles");
$index->addDocument(41, "Lady Chatterley’s Lover");
$index->addDocument(42, "Lajja");
$index->addDocument(43, "Little Black Sambo");
$index->addDocument(44, "Lolita");
$index->addDocument(45, "The Lonely Girl");
$index->addDocument(46, "The Lottery");
$index->addDocument(47, "Madame Bovary");
$index->addDocument(48, "Mein Kampf");
$index->addDocument(49, "The Metamorphosis");
$index->addDocument(50, "A Message to Man and Humanity");
$index->addDocument(51, "Mirror of the Polish Crown");
$index->addDocument(52, "The Mountain Wreath");
$index->addDocument(53, "Military Incorporated");
$index->addDocument(54, "Naked Lunch");
$index->addDocument(55, "New Class");
$index->addDocument(56, "The Nickel-Plated-Feet Gang During the Occupation");
$index->addDocument(57, "Nineteen Eighty-Four");
$index->addDocument(58, "Notre ami le roi");
$index->addDocument(59, "Not Without My Daughter");
$index->addDocument(60, "Nine Hours To Rama");
$index->addDocument(61, "On Fierce Wound - Fierce Herb");
$index->addDocument(62, "One Day of Life");
$index->addDocument(63, "One Day in the Life of Ivan Denisovich");
$index->addDocument(64, "Operation Dark Heart");
$index->addDocument(65, "The Peaceful Pill Handbook");
$index->addDocument(66, "Rangila Rasul");
$index->addDocument(67, "Rights of Man");
$index->addDocument(68, "The Satanic Verses");
$index->addDocument(69, "Snorri the Seal");
$index->addDocument(70, "Soft Target: How the Indian Intelligence Service Penetrated Canada");
$index->addDocument(71, "The Song of the Red Ruby");
$index->addDocument(72, "Smash and Grab: Annexation of Sikkim");
$index->addDocument(73, "Spycatcher");
$index->addDocument(74, "Storytellers II");
$index->addDocument(75, "Suicide mode d’emploi");
$index->addDocument(76, "Thalia");
$index->addDocument(77, "The True Furqan");
$index->addDocument(78, "Tropic of Cancer");
$index->addDocument(79, "The Turner Diaries");
$index->addDocument(80, "Ulysses");
$index->addDocument(81, "Uncle Tom’s Cabin");
$index->addDocument(82, "Understanding Islam through Hadis");
$index->addDocument(83, "United States-Vietnam Relations: 1945-1967");
$index->addDocument(84, "Uten en tråd");
$index->addDocument(85, "Unarmed Victory");
$index->addDocument(86, "Various works");
$index->addDocument(87, "Watershed");
$index->addDocument(88, "The Well of Loneliness");
$index->addDocument(89, "Year 501: The Conquest Continues");
$index->addDocument(90, "Zhuan Falun");
