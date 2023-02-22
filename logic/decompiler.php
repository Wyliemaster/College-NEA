<?php
error_reporting(0);
require_once "Token.php";

class Decompiler
{
    //@type = array(Token)
    //@Description - A queue containing all tokens to avoid them being processed in the wrong order
    private $token_queue = [];

    //@type = Bool
    //@Description - if set to true, the decompiler will stop decompiling code
    static private $halt = false;

    //@type = array(string)
    //@Description - array of local variables
    static public $var = [];

    //@Type = array(string)
    //@Description - Array of decompiled lines of code
    static private $code = [];

    //@Type = string
    //@Description - The type of file which is being decompiled
    static private $filetype = "";

    //@type = int
    //@Description - The part of the file where the data section starts
    static public $data_start = 65535;


    //@Description - Fetches the size of the token queue [DEBUGGING]
    public function queue_size(): int
    {
        return count($this->token_queue);
    }

    //@Description - Pushes a token into the token queue
    public function push_token_to_queue(Token $token): void
    {
        if ($token instanceof Token)
            array_push($this->token_queue, $token);
    }

    // @Description - Peaks the next item in the queue
    public function peak(): Token
    {
        if (count($this->token_queue) > 0) {
            return $this->token_queue[0];
        }
    }

    // @Description - Peaks the queue and then removes the
    // latest element
    public function get_from_queue_and_update(): Token|NULL
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

    // @Description - Decompiles the input
    // $data - the code to be decompiled
    // $magic - special value to denote which filetype
    public static function decompile(string $data, string $magic)
    {
        $code = "";

        Decompiler::$filetype = $magic;
        Helpers::handle_input($data, $magic);

        $decompiler = Helpers::get_shared_decompiler();

        while ($token = $decompiler->get_from_queue_and_update()) {
            // to make value consistent between filetypes
            if (!is_numeric($token->value) && $token->value != "") {
                $token->value = Helpers::find_line_for_identifer($token->value);
            }

            // Generate Code based on token
            Decompiler::codegen($token);
        }


        $inline_css = "";
        $line_no = -1;

        // Make a HTML element that contains the pseudocode
        for ($i = 0; $i < count(Decompiler::$code); $i++) {
            $elem = Decompiler::$code[$i];


            if ($elem == CodeKeys::END) {
                $inline_css = "";
                $line_no = -1;
            }

            $code .= "<custom $inline_css id='$line_no'>" . $elem . "</custom><br>";

            if ($elem == CodeKeys::START) {
                $inline_css = "class='indent'";
                $line_no = 0;
            }


            if ($line_no >= 0) $line_no++;
        }
        return $code;
    }

    // @Description - Calculates where variables are located
    private static function calc_var(int $i)
    {
        if (Decompiler::$filetype == FileMagic::MACHINE_CODE) {
            return $i - Decompiler::$data_start;
        }

        if (Decompiler::$filetype == FileMagic::ASSEMBLY) {
            return $i - Decompiler::$data_start;
        }
    }

    // @Description - Generates code from token
    // $token - Token that contains important instruction data
    private static function codegen(Token $token)
    {

        // Since data is intialised first, this is to give the user
        // an indicator for when the actual code starts
        if ($token->line == 1 && !empty($token->key)) {
            Decompiler::push_to_code("INTEGER ACC = 0");
            Decompiler::push_to_code(CodeKeys::START);
        }
        // ignore if the key is empty
        if ($token->key == "") return;

        // Logic to gen code
        switch ($token->key) {
            case Keys::LOAD:
                $acc = Decompiler::$var[Decompiler::calc_var($token->value)];
                Decompiler::push_to_code("ACC = $acc");
                break;
            case Keys::STORE:
                $name = Decompiler::$var[Decompiler::calc_var($token->value)];
                Decompiler::push_to_code("$name = ACC");
                break;
            case Keys::DATA:
                $value = intval($token->value);
                $loc = Decompiler::$var[Decompiler::calc_var($token->line)];
                array_unshift(Decompiler::$code, "INTEGER $loc = $value");
                break;

            case Keys::ADD:
                $var = Decompiler::$var[Decompiler::calc_var($token->value)];
                Decompiler::push_to_code("ACC += $var");
                break;

            case Keys::SUB:
                $var = Decompiler::$var[Decompiler::calc_var($token->value)];
                Decompiler::push_to_code("ACC -= $var");
                break;

            case Keys::OUTPUT:
                Decompiler::push_to_code("OUTPUT( ACC )");
                break;

            case Keys::INPUT:
                Decompiler::push_to_code("ACC = USER_INPUT( )");
                break;

            case Keys::BRANCH:

                $branch_str = "";

                if ($token->Flags & Flags::kPositive) {
                    $branch_str .= "IF ( ACC > 0 ) THEN ";
                }

                if ($token->Flags & Flags::kZero) {
                    $branch_str .= "IF ( ACC == 0 ) THEN ";
                }

                $branch_str .= "GOTO LINE_" . $token->value;

                Decompiler::push_to_code($branch_str);
                break;
            case Keys::HALT:
                Decompiler::push_to_code(CodeKeys::END);
                break;
        }
    }

    // Helper function to push code
    private static function push_to_code(string $data)
    {
        array_push(Decompiler::$code, $data);
    }
}
