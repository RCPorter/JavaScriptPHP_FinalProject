<?php

    class WordDB {
        const WORD_MAX = 3994;
        public static function getWords($num1, $num2, $num3){
            $db = Database::getDB();
            $query = ' SELECT * FROM word
                        WHERE   word_id = '. $num1. ' OR
                                word_id = '. $num2. ' OR
                                word_id = '. $num3;
            $statement = $db->prepare($query);
            $statement->execute();

            $words = [];
            foreach ($statement as $row) {
                $words[] = $row['word'];
            }
            return $words;
        }

        public static function setWord($x){
            $db = Database::getDB();
            $query = "  INSERT INTO word (word)
                        VALUE (:x)";
            $statement = $db->prepare($query);
            $statement->bindValue(':x', $x);
            $statement->execute();
        }
    }
?>