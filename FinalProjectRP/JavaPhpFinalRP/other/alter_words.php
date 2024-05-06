<!-- Original List from https://www.mit.edu/~ecprice/wordlist.10000 -->
<?php
    /*Pull from original */
    $file = fopen("old_words.txt", "r") or die("Unable to Open File!");

    while(!feof($file)){
        $words[$index] = fgets($file);
        $index++;
    }

    fclose($file);
    /*Filter from old file and put in new file */
    $file = fopen("words.txt", "w") or die("Unable to Open File");

    foreach ($words as $word){
        if (strlen($word) >= 6 && strlen($word) <= 8) {
            fwrite($file, $word);
        }
    }

    fclose($file);

    $index = 0;

    $file = fopen("words.txt", "r") or die("Unable to Open File!");

    while (!feof($file)){
        $new_word_order[$index] = fgets($file);
        $index++;
    }

    fclose($file);
    /*Pull from new file, remove \r\n from the end of eac word and put
      them into the database. */
    $file = fopen('words.txt', 'r') or die('Unable to Open File');

        while(!feof($file)){
            $word =str_replace("\r\n", "", fgets($file));
            WordDB::setWord($word);
        }
        fclose($file);
?>