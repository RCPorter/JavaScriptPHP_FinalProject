<?php

class Pass_gen {

    /*  I would like to point out here that the method I used is not technically good
        for this use case due to the rand() functions predictability.
        However, for the sake of brevity, we will be using the rand() function.
        The appropriate method (I think) would be to use one of the APIs suggested
        by the php documentation. This would be an eventual update prior to release
        if this was a real world project. 
    */
    private $base_upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private $base_lower = "abcdefghijklmnopqrstuvwxyz";
    private $base_special= "`~!@#$%^&*()-_=+[{]}|;:,<.>?";
    private $similar_upper = "ABCDEFGHJKMNPQRTUVWXY";
    private $similar_lower = "abcdefghjkmnpqrtuvwxy";
    private $coin; /* This will be used continuously to make yes/no decisions */
    private $dice; /* This will hold a number decided by the roll function */
    private $base_words; /* Holds the three randomly selected words */
    private $option_upper; /* boolean for capitalized characters*/
    private $option_lower; /* boolean for lower case characters*/
    private $option_number; /* boolean for lower case characters*/
    private $option_special; /* boolean for special characters*/
    private $option_similar; /* boolean for including 1,2, and 5 (too similar to i,l,o,s,z);*/
    private $options; /* This will hold an array of options chosen for random selection */
    private $count; /* holds the length of the options array. I added this because it is used frequently */
    private $hints = []; /*holds the hints generated for the password. If it is three word, the hints are the words
                           if it is long string the hints are the first part of each third of the string followed by '*' filler */
    public function set_upper($u){
        $this->option_upper = $u;
    }
    public function set_lower($l){
        $this->option_lower = $l;
    }
    public function set_number($n){
        $this->option_number = $n;
    }

    public function set_special($s){
        $this->option_special = $s;
    }
    
    public function set_similar($ss){
        $this->option_similar = $ss;
    }
    private function set_hints($pass, $type){
        $this->hints = array_fill(0, 3, "");
        if($type == 'three_word'){
            for($i = 0; $i < 3; $i++){
                $this->hints[$i] = $this->base_words[$i];
            }
        }
        else {
            $full = strlen($pass);
            $split = intval(($full / 3) * 10 / 10);
            $first = $full - $split * 2;
            $second = $first + $split;
            $third = $first + $split * 2;
            for ($i = 1; $i <= $full ; $i++){
                if ($i <= $first){
                    if ($i == $first){
                        $this->hints[0] = $this->hints[0]. substr($pass, $first - 1, 1);
                    }
                    else {
                        $this->hints[0] = $this->hints[0]. "*";
                    }
                }
                else if ($i <= $second){
                    if ($i == $second){
                        $this->hints[1] = $this->hints[1]. substr($pass, $second - 1, 1);
                    }
                    else {
                        $this->hints[1] = $this->hints[1]. "*";
                    }
                }
                else if ($i <= $third){
                    if ($i == $third){
                        $this->hints[2] = $this->hints[2]. substr($pass, $third - 1, 1);
                    }
                    else {
                        $this->hints[2] = $this->hints[2]. "*";
                    }
                }
            }
        }
    }
    public function get_hints(){
        return $this->hints;
    }

    /**Decides the value of the coin attribute */
    public function flip(){
        $this->coin = rand(0,1);
    }
    /**Decides the value of the dice attribute */
    public function roll($sides){
        $this->dice = rand(0, $sides - 1);
    }
    /**pulls 3 random words from the database
     * It checks to make sure none of the numbers for pulling 
     * words are the same to eliminate the possibility of
     * duplicate words.
     */
    private function set_words() {
        $nums[0] = rand(0, WordDB::WORD_MAX);
        $nums[1] = rand(0, WordDB::WORD_MAX);
        while ($nums[1] == $nums[0]){
            $nums[1] = rand(0, WordDB::WORD_MAX);
        }
        $nums[2] = rand(0, WordDB::WORD_MAX);
        while ($nums[2] == $nums[0] || $nums[2] == $nums[1]){
            $nums[2] = rand(0, WordDB::WORD_MAX);
        }

        $words = WordDB::getWords($nums[0], $nums[1], $nums[2]);

        for ($i = 0; $i < 3; $i++){
            $this->base_words[$i] = $words[$i];
        }
    }
    /**This function attempts to return a special character associated with the given letter.
     * If no associated number exists, it returns null.
     */
    private function to_special($character){
        switch($character){
            case 'a':
                return '@';
            case 'c':
                return '(';
            case 'd':
                return ')';
            case 'h':
                return '#';
            case 'i':
                $this->flip();
                switch($this->coin){
                    case '0':
                        return '!';
                    case '1':
                        return ':';
                }
            case 'j':
                return ';';
            case 'l':
                return '|';
            case 's':
                return '$';
            case 't':
                return '+';
            case 'v':
                return '/';
            case 'x':
                return '*';
            default:
                return null;
        }

    }
    /**This function attempts to return a number associated with the given letter.
     * If no associated number exists, it returns null.
     */
    private function to_number($character){
        switch($character){
            case 'a':
                return '4';
            case 'b':
                return '8';
            case 'e':
                return '3';
            case 'f':
                return '7';
            case 'g':
                return '9';
            case 'i':
                return '1';
            case 'l':
                return '1';
            case '0':
                return '0';
            case 's':
                return '5';
            case 't':
                return '7';
            case 'z':
                return '2';
            default:
                return null;
        }
    }
    /**This function creates an array of the chosen options */
    private function set_options(){
        if($this->option_lower){
            $this->options[] = 'lower';
        }
        if($this->option_upper){
            $this->options[] = 'upper';
        }
        if($this->option_number){
           $this->options[] = 'number'; 
        }  
        if($this->option_special){
            $this->options[] = 'special';
        }
        $this->count = count($this->options);
    }

    /**This function takes the word, iterates over each individual letter in the word,
     *if the letter is among the similar list, it checks the options:
     *  if numbers and special characters are allowed, it flips the coin
     *  and decides which to use based on the result
     *  otherwise it applies the associated number or special character.
     *  if neither are allowed, it removes the character. */
    private function desimilarize($word){
        $one = 1;/*Because str_replace does not accept literals */
        for($i = 0; $i < strlen($word); $i++){
            switch (substr($word, $i, 1)){
                case'i':
                    if ($this->option_special && $this->option_number){
                        $this->flip();
                        if($this->coin == 1) {
                            $word = str_replace('i', '!', $word, $one);
                        }
                        else {
                            $word = str_replace('i', '1', $word, $one);
                        }
                    }
                    else if ($this->option_special && $this->option_number){
                        $this->flip();
                        if($this->coin == 1) {
                            $word = str_replace('i', '!', $word, $one);
                        }
                        else {
                            $word = str_replace('i', ':', $word, $one);
                        }
                    }
                    else if ($this->option_number){
                        $word = str_replace('i', '1', $word, $one);
                    }
                    else $word = str_replace('i', '', $word);
                    break;
                case 'l':
                    if ($this->option_special && $this->option_number){
                        $this->flip();
                        if($this->coin == 1) {
                            $word = str_replace('l', '|', $word, $one);
                        }
                        else {
                            $word = str_replace('l', '1', $word, $one);
                        }
                    }
                    else if ($this->option_special){
                        $word = str_replace('l', '|', $word);
                    }
                    else if ($this->option_number){
                        $word = str_replace('l', '1', $word);
                    }
                    else {
                        $word = str_replace('l', '', $word);
                    }
                    break;
                case 'o':
                    if ($this->option_special && $this->option_number){
                        $this->flip();
                        if($this->coin == 1) {
                            $word = str_replace('o', '()', $word, $one);
                        }
                        else {
                            $word = str_replace('o', '0', $word, $one);
                        }
                    }
                    else if ($this->option_special){
                        $word = str_replace('o', '()', $word);
                    }
                    else if ($this->option_number){
                        $word = str_replace('o', '0', $word);
                    }
                    else {
                        $word = str_replace('o', '', $word);
                    }
                    break;
                case 's':
                    if ($this->option_special && $this->option_number){
                        $this->flip();
                        if($this->coin == 1) {
                            $word = str_replace('s', '$', $word, $one);
                        }
                        else {
                            $word = str_replace('s', '5', $word, $one);
                        }
                    }
                    else if ($this->option_special){
                        $word = str_replace('s', '$', $word);
                    }
                    else if ($this->option_number){
                        $word = str_replace('s', '5', $word);
                    }
                    else {
                        $word = str_replace('s', '', $word);
                    }
                    break;
                case 'z':
                    if ($this->option_special && $this->option_number){
                        $this->flip();
                        if($this->coin == 1) {
                            $word = str_replace('z', '?', $word, $one);
                        }
                        else {
                            $word = str_replace('i', '2', $word, $one);
                        }
                    }
                    else if ($this->option_special){
                        $word = str_replace('z', '2', $word);
                    }
                    else if ($this->option_number){
                        $word = str_replace('z', '?', $word);
                    }
                    else {
                        $word = str_replace('z', '', $word);
                    }
                    break;
            }
        }
        return $word;
    }
    /**This function is used to add a character from any remaining 
     * selected options in case they were unable to be added in place
     * of one of the letters in the generated password. This has yet to
     * happen in my testing, but there it is.
     * It will check the options, flip a coin, then add the character to the 
     * start or the end of the password based on the coin toss.
     */
    private function pad($pass, $option){
        $this->flip();
        if ($this->coin == 1){
            $side = STR_PAD_LEFT;
        }
        else {
            $side = STR_PAD_RIGHT;
        }
        switch ($option){
            case 'number':
                $this->roll(9);
                $pass = str_pad($pass, strlen($pass) + 1, $this->coin, $side);
                break;
            case 'special':
                $this->roll(strlen($this->base_special) - 1);
                $pass = str_pad($pass, strlen($pass) + 1, substr($this->base_special, $this->dice, 1), $side);
                break;
            case 'upper':
                if($this->option_similar){
                    $this->roll(strlen($this->similar_upper) - 1);
                    $pass = str_pad($pass, strlen($pass) + 1, substr($this->similar_upper, $this->dice, 1), $side);
                }
                else {
                    $this->roll(strlen($this->base_upper) - 1);
                    $pass = str_pad($pass, strlen($pass) + 1, substr($this->base_upper, $this->dice, 1), $side);
                }
                break;
        }
        return $pass;
    }
    /**This function randomly determines which remaining characters to change
     * according to the selected options. Further descriptions w/i the 
     * function comments.
     */
    private function change_char($pass, $option){
        $one = 1; /*Because str_replace does not accept a literal */
        $indices = []; /*Hold the indices of all alpha characters in the password for change according to options */
        $replace = null; /*Hold the replacement character for each option. */
        /*Collect the indices of each character in the password that is alpha */
        for ($i = 0; $i < strlen($pass); $i++){ 
            if(ctype_alpha(substr($pass, $i, 1))){
                $indices[] = $i;
            }
        }
        /*If there are no alpha characters in the string we pad the string with a random character from the option string */
        if (empty($indices)){
            $pass = $this->pad($pass, $option);
        }
        else {
            $pick = rand(0, count($indices) - 1); /*select a random character from the indexed character*/
            /*While no character has been replaced*/
            while($replace == null){
                /*get the randomly selected character*/
                $search = substr($pass, $indices[$pick], 1);
                /*attempt to replace it with the associated option function. If there is no replacement, null is returned*/
                if ($option == 'number'){
                    $replace = $this->to_number($search);
                }
                else if ($option == 'special') {
                    $replace = $this->to_special($search);
                }
                else {
                    $replace = (strtoupper($search));
                }
                /*If it is not null, replace the character*/
                if($replace != null){
                    $pass = str_replace($search, $replace, $pass, $one);
                }
                /*if it is, check to make sure there are available characters left. 
                    If not, pad the string
                    If so, remove the checked character from the list and randomly select another one*/
                else {
                    if (empty($indices)){
                        $pass = $this->pad($pass, $option);
                        $replace = null;
                    } 
                    else {
                        array_slice($indices, $pick, 1);
                        $pick = rand(0, count($indices) - 1);
                    }
                }
            }
        }
        return $pass;
    }
    /** This function just checks the options then utilizes the above 
     * functions to execute the correct changes
     */
    private function optionize($pass){
        if ($this->option_number){
           $pass = $this->change_char($pass, 'number');
        }
        if ($this->option_special){
            $pass = $this->change_char($pass, 'special');
        }
        if ($this->option_upper && $this->option_lower){
            $pass = $this->change_char($pass, 'upper');
        }
        /*If only uppercase is selected, convert string to upper */
        if (!$this->option_lower) {
            $pass = strtoupper($pass);
        }
        return $pass;
    }

    /**This function creates the random string of characters for
     * the long string version. Simply put, it randomly adds characters
     * from whichever options were selected.
     */
    private function ls_gen($choice, $i, $pass){
        $this->flip();
        if ($this->coin == 1){
            $side = STR_PAD_LEFT;
        }
        else {
            $side = STR_PAD_RIGHT;
        }
        /*Add a new random character from the chosen option */
        switch($choice){
            /*For upper and lower, base the random character selection off of the similar option */
            case 'upper':
                if($this->option_similar){
                    $this->roll(strlen($this->similar_upper) - 1);
                    $pass = str_pad($pass, $i + 2, substr($this->similar_upper, $this->dice, 1), $side);
                }
                else {
                    $this->roll(strlen($this->base_upper) - 1);
                    $pass = str_pad($pass, $i + 2, substr($this->base_upper, $this->dice, 1), $side);
                }
                break;
            case 'lower':
                if($this->option_similar){
                    $this->roll(strlen($this->similar_lower) - 1);
                    $pass = str_pad($pass, $i + 2, substr($this->similar_lower, $this->dice, 1), $side);
                }
                else {
                    $this->roll(strlen($this->base_lower) - 1);
                    $pass = str_pad($pass, $i + 2, substr($this->base_lower, $this->dice, 1), $side);
                }
                break;
            /*Number simply rolls the dice (0-9) then adds that number to the string */
            case 'number';
                $this->roll(9);
                $pass = str_pad($pass, $i + 2, $this->dice, $side);
                break;
            /*The list of special characters does not change based on the similar option */
            case 'special';
                $this->roll(strlen($this->base_special) - 1);
                $pass = str_pad($pass, $i + 2, substr($this->base_special, $this->dice, 1), $side);    
            break;
        }
        return $pass;
    }
    /** This function determins which type of password is to be generated based 
     * on the type option recieved and passes that information to the generator functions
     * above.
      */
    public function generate($type){
        $this->set_options();
        if ($type == 'three_word'){
            $this->set_words();
            $new_words = [];
            if ($this->option_similar) {
                foreach($this->base_words as $word){
                    $word = $this->desimilarize($word);
                    $new_words[] = $word;
                }
                $password = $this->optionize(implode($new_words));
                $this->set_hints($password, $type);
                
            }
            else {
                $password = $this->optionize(implode($this->base_words));
                $this->set_hints($password, $type);
            }
            return ($password.  ' Hint: '.  $this->hints[0].
                                    ', '.   $this->hints[1].
                                    ', '.   $this->hints[2]);

        }
        else if ($type == 'long_string'){
            /*For str_pad() to work the string must have a length, so we start with 'a' */
            $password = "a";
            /*To verify that all set options are in the password, we set a check for each option */
            for($i = 0; $i < $this->count; $i++){
                $check[] = false;
            }
            for($i = 0; $i <= rand(8, 12); $i++){
                /*Create random int from - to the number of set options - 1 */
                $this->roll($this->count);
                /*Set the check for this option to true to indicate at least one character from that option is in the password */
                $check[$this->dice] = true;
                /*Set the choice to the option rolled */
                $choice = $this->options[$this->dice];
                /*send the ls_gen function the option, the iteration number, the password, and the similar option
                  this returns the new password. */
                $password = $this->ls_gen($choice, $i, $password);
            }
            /*Iterate through the options making sure each one has been checked.
              If not, run the password through ls_gen one more time, setting option to the unchecked option. */
            for($i = 0; $i < $this->count; $i++){
                if ($check[$i] == false){
                    $password = $this->ls_gen($this->options[$i], strlen($password) - 1, $password);
                }
            }
            /*Finally, remove the 'a' from the beginning of the password and return it. */
            $password = substr($password, 1, strlen($password) - 1);
            $this->set_hints($password, $type);
            return ($password.  ' Hint: '.  $this->hints[0].
                                    ', '.   $this->hints[1].
                                    ', '.   $this->hints[2]);
        }
        else {
            return 'This is not the password you were looking for.';
        }
    }

}

?>