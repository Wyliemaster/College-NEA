<?php
include "logic/helper.php";

$files = glob('TestData/LMC_ALPHABET.s');
foreach($files as $file) {

    $data = fopen($file, "r");

    $input = fread($data, filesize($file))."<br>";

    Helpers::handle_input($input, "1530");
}

Helpers::print_object(Helpers::get_shared_decompiler()->get_queue());

// echo "<pre>",var_dump(Helpers::get_shared_decompiler()->get_queue()),"</pre>";



// Helpers::handle_input("100201", "2167");



