CREATE TABLE `zizelo_indexes`(
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE `zizelo_documents`(
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `index_id` INTEGER NOT NULL,
    `object_id` INTEGER NOT NULL,
    FOREIGN KEY(`index_id`) REFERENCES `zizelo_indexes`(`id`) ON DELETE CASCADE,
    UNIQUE(`index_id`, `object_id`)
);

CREATE TABLE `zizelo_words`(
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `text` VARCHAR(100) NOT NULL,
    `hash` VARCHAR(100) NOT NULL,
    UNIQUE(`text`, `hash`)
);

CREATE INDEX `zizelo_words_hash` ON `zizelo_words`(`hash`);

CREATE TABLE `zizelo_words_appearance`(
    `document_id` INTEGER NOT NULL,
    `word_id` INTEGER NOT NULL,
    PRIMARY KEY(`document_id`, `word_id`),
    FOREIGN KEY(`document_id`) REFERENCES `zizelo_documents`(`id`) ON DELETE CASCADE,
    FOREIGN KEY(`word_id`) REFERENCES `zizelo_words`(`id`) ON DELETE CASCADE
);
