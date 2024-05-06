<?php
    class Database {

        private static $dsn = 'mysql:host=localhost;dbname=whats_the_word';
        private static $username = 'wtw_app';
        private static $password = '1p2a3s4S!';
        private static $db;
    
        private function __construct() {}

        public static function getDB() {
            if (!isset(self::$db)){
                try {
                    self::$db = new PDO(self::$dsn, 
                                        self::$username, 
                                        self::$password);
                } catch (PDOException $e) {
                    $error_message = $e->getMessage();
                    include('../errors/database_error.php');
                    exit();
                }
            }
            return self::$db;
        }

    }
?>