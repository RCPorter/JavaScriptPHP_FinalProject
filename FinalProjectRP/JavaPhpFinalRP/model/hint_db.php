<?php

class HintDB {
    public static function get_hints($username, $pin) {
        $db = Database::getDB();
        $query = 'SELECT * FROM user
                  WHERE user_name = :username
                    AND pin = :pin';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':pin', $pin);
        $statement->execute();
        $hints = $statement->fetchAll();
        $statement->closeCursor();
        return $hints;
    }
    
    public static function delete_hint($hint1, $hint2, $hint3) {
        $db = Database::getDB();
        $query = 'DELETE FROM user
                  WHERE hint_1 = :hint1
                    AND hint_2 = :hint2
                    AND hint_3 = :hint3';
        $statement = $db->prepare($query);
        $statement->bindValue(':hint1', $hint1);
        $statement->bindValue(':hint2', $hint2);
        $statement->bindValue(':hint3', $hint3);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function add_hint($username, $pin, $hint1, $hint2, $hint3) {
        $db = Database::getDB();
        $query = 'INSERT INTO user
                     (user_name, pin, hint_1, hint_2, hint_3)
                  VALUES
                     (:username, :pin, :hint1, :hint2, :hint3)';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':pin', $pin);
        $statement->bindValue(':hint1', $hint1);
        $statement->bindValue(':hint2', $hint2);
        $statement->bindValue(':hint3', $hint3);
        $statement->execute();
        $statement->closeCursor();
    }
}


?>