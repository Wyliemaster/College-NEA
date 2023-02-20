<?php
require_once "Token.php";

class Decompiler
{
    //@type = array(Token)
    //@Description - A queue containing all tokens to avoid them being processed in the wrong order
    private $token_queue = [];
    
    //@type = Bool
    //@Description - if set to true, the decompiler will stop decompiling code
    static private $halt = false;

    //@type = int(string)
    //@Description - array of local variables
    static public $var = [];

    static private $code = [];

    static private $filetype = "";

    static private $accumulator;

    static public $data_start = 65535;


    //@Description - Pushes a token into the token queue
    public function push_token_to_queue(Token $token): void
    {
        if ($token instanceof Token)
            array_push($this->token_queue, $token);
    }

    // @Description - Peaks the next item in the queue
    public function peak() : Token
    {
        if (count($this->token_queue) > 0) {
            return $this->token_queue[0];
        }
    }

    // @Description - Peaks the queue and then removes the
    // latest element
    public function get_from_queue_and_update() : Token|NULL
    {
        if (count($this->token_queue) > 0) {
            $data = $this->peak();
            array_shift($this->token_queue);
            return $data;
        }
        return NULL;
    }

    // @Description - Gets the entire token queue
    // for debugging purposes.
    public function get_queue()
    {
        return $this->token_queue;
    }

    public static function decompile($data, $magic)
    {
        Decompiler::$filetype = $magic;
        Helpers::handle_input($data, $magic);

        $decompiler = Helpers::get_shared_decompiler();

        while($token = $decompiler->get_from_queue_and_update())
        {            
            if(!is_numeric($token->value) && $token->value != "")
            {
                $token->value = Helpers::find_line_for_identifer($token->value);
            }
        
            Decompiler::codegen($token);
            
            
        }
        Helpers::print_object(Decompiler::$code);
    }

    private static function calc_var(int $i)
    {
        if (Decompiler::$filetype == FileMagic::MACHINE_CODE)
        {
            return $i - Decompiler::$data_start;
        }

        if( Decompiler::$filetype == FileMagic::ASSEMBLY )
        {
            return $i - Decompiler::$data_start;
        }
    }

    private static function codegen(Token $token)
    {
        switch($token->key)
        {
            case Keys::LOAD:
              Decompiler::$accumulator = Decompiler::$var[Decompiler::calc_var($token->value)];
              $acc = Decompiler::$var[Decompiler::calc_var($token->value)];
              array_push(Decompiler::$code, "acc = $acc");
            break;
            case Keys::STORE:
                $name = Decompiler::$var[Decompiler::calc_var($token->value)];
                array_push(Decompiler::$code, "$name = acc");
            break;
            case Keys::HALT:
                break;
            case Keys::DATA:
                $value = intval($token->value);
                $loc = Decompiler::$var[Decompiler::calc_var($token->line)];
                array_unshift(Decompiler::$code, "INTEGER $loc = $value");
                break;

            case Keys::ADD:
                $var = Decompiler::$var[Decompiler::calc_var($token->value)];
                array_push(Decompiler::$code, "acc = acc + $var");
                break;

            case Keys::SUB:
                $var = Decompiler::$var[Decompiler::calc_var($token->value)];
                array_push(Decompiler::$code, "acc = acc - $var");
            break;

            case Keys::OUTPUT:
                array_push(Decompiler::$code, "OUTPUT acc");
            break;


        }
    }
}
