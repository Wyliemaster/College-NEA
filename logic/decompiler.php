<?php
require_once "Token.php";

class Decompiler
{
    //@type = array(Token)
    //@Description - A queue containing all tokens to avoid them being processed in the wrong order
    private $token_queue = [];

    //@Description - Pushes a token into the token queue
    public function push_token_to_queue(Token $token): void
    {
        if ($token instanceof Token)
            array_push($this->token_queue, $token);
    }

    // @Description - Peaks the next item in the queue
    public function peak()
    {
        if (count($this->token_queue) > 0) {
            return $this->token_queue[0];
        }
    }

    // @Description - Peaks the queue and then removes the
    // latest element
    public function get_from_queue_and_update()
    {

        if (count($this->token_queue) > 0) {
            $data = $this->peak();
            unset($this->token_queue[0]);
            array_shift($this->token_queue);
            return $data;
        }
    }

    // @Description - Gets the entire token queue
    // for debugging purposes.
    public function get_queue()
    {
        return $this->token_queue;
    }
}
