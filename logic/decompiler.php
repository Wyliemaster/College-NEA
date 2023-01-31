<?php
require_once "Token.php";

class Decompiler
{
    //@type = array(Token)
    //@Description - A queue containing all tokens to avoid them being processed in the wrong order
    private $token_queue = [];

    //@Description - Pushes a token into
    public function push_token_to_queue(Token $token): void
    {
        if ($token instanceof Token)
            array_push($this->token_queue, $token);
    }

    public function get_queue()
    {
        return $this->token_queue;
    }
}