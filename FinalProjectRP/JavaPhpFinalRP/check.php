<?php
include 'model/api.php';
$api = new Api();;

if ($api->set_pass(filter_input(INPUT_POST, 'pass'))) {
    $api->call();
    $result = $api->get_result();

    if ($result > 0) {
        $check_message = 'Your password has been found in '. $result. ' breaches.';
        $hidden_found = ''; /*Used to switch found box from hidden to not hidden */
        $hidden_check = 'hidden';
        $hidden_not = 'hidden';
        include 'index.php';
    }
    else if($result == -2){
        $check_message = 'Your password was not found in any breaches!';
        $hidden_not = ''; 
        $hidden_check = 'hidden';
        $hidden_found = 'hidden';
        include 'index.php';
    }

}
else {
    $error_message = "No password was entered.";
    include './errors/error.php';
}

