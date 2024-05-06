<?php
require('../model/database.php');
require('../model/hint_db.php');

$action = filter_input(INPUT_POST, 'action');

if ($action === NULL){
    $action = 'word_up';
}
$error = 'hidden';
switch($action){
    case 'word_up':

        include('./word_up.php');

        break;
    case 'load_hints':
        include('./sign_in.php');
        break;
    case 'sign_in':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $pin = filter_input(INPUT_POST, 'pin');
        if (is_nan($pin) || $pin == false || preg_match('/\\d{4}/', $pin) != 1){
            $error = '';
            $message = 'Pin Must be a four digit number. Ex(1234)';
            include('./sign_in.php');
        }
        else if ($username == false || $username == null){
            $error = '';
            $message = 'Invalid Username';
            include('./sign_in.php');
        }
        else {
            $hints = HintDB::get_hints($username, $pin);
            include('./hints.php');
        }
        break;
    case 'add_hint':
        $username = filter_input(INPUT_POST, 'username');
        $pin = filter_input(INPUT_POST, 'pin');
        $hint_1 = filter_input(INPUT_POST, 'hint_1');
        $hint_2 = filter_input(INPUT_POST, 'hint_2');
        $hint_3 = filter_input(INPUT_POST, 'hint_3');
        if (is_nan($pin) || $pin == false || preg_match('/\\d{4}/', $pin) != 1){
            $error = '';
            $message = 'Pin Must be a four digit number. Ex(1234)';
            include('./word_up.php');
        }
        else if ($username == false || $username == null){
            $error = '';
            $message = 'Invalid Username';
            include('./word_up.php');
        }
        else if (     $hint_1 == false || $hint_1 == null
                    ||$hint_2 == false || $hint_2 == null
                    ||$hint_3 == false || $hint_3 == null){
            $error = '';
            $message = 'Missing Hints';
            include('./word_up.php');
        }
        else {
            HintDB::add_hint($username, $pin, $hint_1, $hint_2, $hint_3);
            $hints = HintDB::get_hints($username, $pin);
            include('./hints.php');
        }
        break;
    case 'delete_hint':
        $username = filter_input(INPUT_POST, 'username');
        $pin = filter_input(INPUT_POST, 'pin');
        $hint_1 = filter_input(INPUT_POST, 'hint_1');
        $hint_2 = filter_input(INPUT_POST, 'hint_2');
        $hint_3 = filter_input(INPUT_POST, 'hint_3');
        HintDB::delete_hint($hint_1, $hint_2, $hint_3);
        $hints = HintDB::get_hints($username, $pin);
        include('./hints.php');
        break;

}