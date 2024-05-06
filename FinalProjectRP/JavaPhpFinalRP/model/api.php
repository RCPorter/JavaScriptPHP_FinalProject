<?php

use LDAP\Result;

class Api {
private $prefix = '21BD1'; /*   $prefix holds the prefix. 
                                The default value is the one given by HaveIBeenPwned page for testing.
                                The prefix is sent to the api, which returns every known password with that prefix back
                                along with the number of times the password has been found in the known breaches. */
private $suffix;            /*  $suffix holds the suffix of the encrypted password. This is used to check through the 
                                list of returned passwords for the exact password that was entered.*/
private $ch;                /* $ch holds the CurlHandle object used for communicating with the API */
private $url;               /* $url holds the url for the api call */
private $words;             /*  $words holds the list of words returned by the api converted into an associative array.
                                The associative array uses the password suffix as the key and the number of times
                                found in known breaches as the value. */
private $resp;              /*  $resp holds the response from the API. This API sends the response in the form a big string. */
private $pass;              /*  $pass holds the password. */
private $e_pass;            /*  $e_pass holds the encrypted password using Hexadecimal SCA1. */
private $result;
/* Verify the password is not a blank string or null, then set the password variable to the password string sent */
public function set_pass($p){
    if($p == ''){
        return FALSE;
    }
    else {
        $this->pass = $p;
        return TRUE;
    }
}

/* Encrypt the password using the Hexadecimal SHA1 algorithm. */
private function encrypt_pass() {
    $this->e_pass = sha1($this->pass, FALSE);
    $this->prefix = substr($this->e_pass, 0, 5);
    $this->suffix = strtoupper(substr($this->e_pass, 5));
}

/* Calls the api and puts converts the retrieved data into an associative array in the format Array[suffix] = number. */
public function call() {
    $this->ch = curl_init();

    $this->encrypt_pass();

    $this->url = 'https://api.pwnedpasswords.com/range/' . $this->prefix;

    curl_setopt($this->ch, CURLOPT_URL, $this->url);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    $this->resp = curl_exec($this->ch);

    if($e = curl_error($this->ch)){
        echo $e;
    }
    else {
        /* Data retrieved from API comes as one long string. Here, the string is broken down into an associative array */
        $lines = explode(PHP_EOL, $this->resp);
        foreach ($lines as $line){
            $hold = explode(':', $line);
            $this->words[$hold[0]] = $hold[1];
        }
        
    }

    $this->check_response();

}

/*  Checks the API response (after conversion). 
    Return -1: No similar passwords were found.
    Return -2: Password was not found among returned passwords.
    Return >0: Password was found returned number of times.*/
private function check_response(){

    if ($this->words != NULL){
        foreach($this->words as $key => $value){
            if ($key == $this->suffix){
                $this->result = $value;
                break;
            }
            else {
                $this->result = -2;
            }
        }
    }
    else {
        $this->result = -1;
    }
    
}

public function get_result() {
    return $this->result;
}


}
?>