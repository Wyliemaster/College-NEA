<?php
include "logic/helper.php";

$files = glob('TestData/LMC_ALPHABET.bin');
foreach($files as $file) {

    $data = fopen($file, "r");

    $input = fread($data, filesize($file))."<br>";

    Helpers::handle_input($input, "2167");
}

echo "<pre>",var_dump(Helpers::get_shared_decompiler()->get_queue()),"</pre>";



// Helpers::handle_input("100201", "2167");



