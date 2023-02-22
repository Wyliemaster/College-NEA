<?php
include "../../logic/helper.php";
include "ERRORS.php";

$file = $_POST["code"];
$type = $_POST["type"];


if (!empty($file) && ( $type == FileMagic::ASSEMBLY || $type == FileMagic::MACHINE_CODE) )
{
    exit(Decompiler::decompile($file, $type));
}

echo V1Errors::GENERIC;
