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

    public function peak()
    {
        if (count($this->token_queue) > 0) {
            return $this->token_queue[0];
        }
    }

    public function get_from_queue_and_update()
    {

        if (count($this->token_queue) > 0) {
            $data = $this->peak();
            unset($this->token_queue[0]);
            array_shift($this->token_queue);
            return $data;
        }
    }
}
