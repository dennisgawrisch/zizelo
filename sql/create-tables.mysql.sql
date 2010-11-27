CREATE TABLE `zizelo_indexes`(
    `id` INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zizelo_documents`(
    `id` INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `index_id` INTEGER UNSIGNED NOT NULL,
    `object_id` INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY(`index_id`) REFERENCES `zizelo_indexes`(`id`) ON DELETE CASCADE,
    UNIQUE(`index_id`, `object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zizelo_words`(
    `id` INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `text` VARCHAR(100) NOT NULL,
    `hash` VARCHAR(100) NOT NULL,
    UNIQUE(`text`, `hash`),
    INDEX(`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zizelo_words_appearance`(
    `document_id` INTEGER UNSIGNED NOT NULL,
    `word_id` INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(`document_id`, `word_id`),
    FOREIGN KEY(`document_id`) REFERENCES `zizelo_documents`(`id`) ON DELETE CASCADE,
    FOREIGN KEY(`word_id`) REFERENCES `zizelo_words`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
