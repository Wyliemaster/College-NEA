<?php
include "logic/helper.php";

Helpers::handle_input("100201", "2167");

echo var_dump(Helpers::get_shared_decompiler()->get_queue());

