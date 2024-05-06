<?php
require('../model/database.php');
require('../model/pass_gen.php');
require('../model/word_db.php');

$action = filter_input(INPUT_POST, 'action');

if ($action === NULL){
    $action = 'say_word';
}

switch($action) {
    case 'say_word':
        /*The generated password will go here */
        $message = 'placeholder="Generate Password"';
        $disabled = 'disabled';

        $hint_1 = "";
        $hint_2 = "";
        $hint_3 = "";

        /*These will hold the user input so the options remain the same
          after each use of the generate button */
        $up_checked = 'checked';
        $low_checked = 'checked';
        $num_checked = 'checked';
        $spec_checked = 'checked';
        $sim_checked = 'checked';
        $ls_checked = '';
        $tw_checked = 'checked';

        include "say_word.php";

        break;

    case 'pass_gen':
        $upper = isset($_POST['upper']);
        $lower = isset($_POST['lower']);
        $number = isset($_POST['number']);
        $special = isset($_POST['special']);
        $similar = isset($_POST['similar']);
        $type = filter_input(INPUT_POST, 'flexRadioDefault');

        $password_generator = new Pass_gen();

        /*It should not be possible for these to not be set. But, you never know. */
        if (isset($upper, $lower, $number, $special, $similar, $type)){
            $password_generator->set_upper($upper);
            $password_generator->set_lower($lower);
            $password_generator->set_number($number);
            $password_generator->set_special($special);
            $password_generator->set_similar($similar);

            $message = 'value="'.$password_generator->generate($type).'"';
            $hints = $password_generator->get_hints();
            $hint_1 = $hints[0];
            $hint_2 = $hints[1];
            $hint_3 = $hints[2];

            $disabled = '';
        }

        if($upper) {
            $up_checked = 'checked';
        }
        else {
            $up_checked = '';
        }
        if($lower) {
            $low_checked = 'checked';
        }
        else {
            $low_checked = '';
        }
        if($number) {
            $num_checked = 'checked';
        }
        else {
            $num_checked = '';
        }
        if($special) {
            $spec_checked = 'checked';
        }
        else {
            $spec_checked = '';
        }
        if($similar) {
            $sim_checked = 'checked';
        }
        else {
            $sim_checked = '';
        }
        if($type == 'three_word'){
            $ls_checked = '';
            $tw_checked = 'checked';
        }
        else {
            $ls_checked = 'checked';
            $tw_checked = '';
        }

        include "say_word.php";

        break;
}

?>