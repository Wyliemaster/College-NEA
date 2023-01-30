<?php
include "logic/Token.php";

$instruction = array(0 => "ADD", 1 => 5);
$instruction2 = array(0 => "numone", 1 => "DAT", 2 => 9);

Token::tokenise($instruction2);
Token::tokenise("999");