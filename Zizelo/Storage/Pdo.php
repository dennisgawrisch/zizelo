<?php
class Zizelo_Storage_Pdo implements Zizelo_Storage_Interface {
    private $connection;
    private $table_name_prefix;
    private $index_ids = array();

    public function __construct(PDO $connection, $table_name_prefix = "zizelo_") {
        $this->connection = $connection;
        $this->table_name_prefix = $table_name_prefix;
    }

    protected function getConnection() {
        return $this->connection;
    }

    protected function getSql($template, $parameters = array()) {
        $substitutions = array("zizelo_" => $this->table_name_prefix);
        foreach ($parameters as $name => $value) {
            $substitutions[":$name"] = $this->getConnection()->quote($value);
        }
        return strtr($template, $substitutions);
    }

    protected function sqlQuery($template, $parameters = array()) {
        return $this->getConnection()->query($this->getSql($template, $parameters));
    }

    protected function sqlExec($template, $parameters = array()) {
        return $this->getConnection()->exec($this->getSql($template, $parameters));
    }

    protected function getIndexId($index_name, $create = FALSE) {
        if (!isset($this->index_ids[$index_name])) {
            $query = $this->sqlQuery("SELECT `id` FROM `zizelo_indexes` WHERE `name` = :index_name", array("index_name" => $index_name));
            foreach ($query as $row) {
                $id = $row[0];
            }
            if (empty($id)) {
                if ($create) {
                    $this->sqlExec("INSERT INTO `zizelo_indexes`(`name`) VALUES(:index_name)", array("index_name" => $index_name));
                    $this->index_ids[$index_name] = $this->getConnection()->lastInsertId();
                } else {
                    return NULL;
                }
            } else {
                $this->index_ids[$index_name] = $id;
            }
        }
        return $this->index_ids[$index_name];
    }

    public function clearIndex($index_name) {
        $this->sqlExec(
            "DELETE FROM `zizelo_words_appearance` WHERE `document_id` IN
            (SELECT `id` FROM `zizelo_documents` WHERE `index_id` = :index_id)",
            array("index_id" => $this->getIndexId($index_name))
        );
        $this->sqlExec(
            "DELETE FROM `zizelo_documents` WHERE `index_id` = :index_id",
            array("index_id" => $this->getIndexId($index_name))
        );
        return $this;
    }

    public function removeDocument($index_name, $document_id) {
        $this->sqlExec(
            "DELETE FROM `zizelo_words_appearance` WHERE `document_id` IN
            (SELECT `id` FROM `zizelo_documents` WHERE `index_id` = :index_id AND `object_id` = :object_id)",
            array("index_id" => $this->getIndexId($index_name), "object_id" => $document_id)
        );
        $this->sqlExec(
            "DELETE FROM `zizelo_documents` WHERE `index_id` = :index_id AND `object_id` = :object_id",
            array("index_id" => $this->getIndexId($index_name), "object_id" => $document_id)
        );
        return $this;
    }

    public function addDocument($index_name, $document_id, array $words) {
        try {
            $inserted_ok = $this->sqlExec(
                "INSERT INTO `zizelo_documents`(`index_id`, `object_id`) VALUES(:index_id, :object_id)",
                array("index_id" => $this->getIndexId($index_name, TRUE), "object_id" => $document_id)
            );
            if (FALSE === $inserted_ok) {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            throw new Zizelo_Exception("Document already exists");
        }
        $document_surrogate_id = $this->getConnection()->lastInsertId();

        foreach ($words as $word) {
            $query = $this->sqlQuery("SELECT `id` FROM `zizelo_words` WHERE `text` = :text AND `hash` = :hash", $word);
            $word_id = NULL;
            foreach ($query as $row) {
                $word_id = $row[0];
            }
            if (empty($word_id)) {
                $this->sqlExec("INSERT INTO `zizelo_words`(`text`, `hash`) VALUES(:text, :hash)", $word);
                $word_id = $this->getConnection()->lastInsertId();
            }

            $this->sqlExec(
                "INSERT INTO `zizelo_words_appearance`(`document_id`, `word_id`) VALUES(:document_id, :word_id)",
                array("document_id" => $document_surrogate_id, "word_id" => $word_id)
            );
        }

        return $this;
    }

    public function findDocuments($index_name, array $words) {
        $counts = array();

        foreach (array("text", "hash") as $field) {
            $values = array();
            foreach ($words as $word) {
                $values []= $this->getConnection()->quote($word[$field]);
            }
            $values = "(" . implode(", ", $values) . ")";

            $words_ids = array();
            foreach ($this->sqlQuery("SELECT `id` FROM `zizelo_words` WHERE `$field` IN $values") as $row) {
                $words_ids []= $row[0];
            }
            if (empty($words_ids)) {
                continue;
            }
            $words_ids = "(" . implode(", ", $words_ids) . ")";

            foreach ($this->sqlQuery("
                SELECT `document_id`, COUNT(`word_id`) AS `count` FROM `zizelo_words_appearance`
                WHERE `word_id` IN $words_ids
                GROUP BY `document_id`;
            ") as $row) {
                if (!isset($counts[$row["document_id"]])) {
                    $counts[$row["document_id"]] = array(
                        "text" => 0,
                        "hash" => 0,
                    );
                }
                $counts[$row["document_id"]][$field] += $row["count"];
            };
        }

        if (empty($counts)) {
            return array();
        }

        $document_surrogate_ids = "(" . implode(", ", array_keys($counts)) . ")";
        $result = array();
        foreach ($this->sqlQuery("
            SELECT `id`, `object_id` FROM `zizelo_documents`
            WHERE `id` IN $document_surrogate_ids
            AND `index_id` = :index_id", array("index_id" => $this->getIndexId($index_name))
        ) as $row) {
            $result[$row["object_id"]] = $counts[$row["id"]];
        }
        return $result;
    }
}