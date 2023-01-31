<?php
include "logic/helper.php";

Helpers::handle_input("100201", "2167");

Helpers::get_shared_decompiler()->get_from_queue_and_update();
Helpers::get_shared_decompiler()->get_from_queue_and_update();

echo var_dump(Helpers::get_shared_decompiler());

