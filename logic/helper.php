<?php
include_once "decompiler.php";
require_once "Token.php";
error_reporting(0);

class Helpers
{

    static $decompiler = NULL;
    static $file = NULL;


    public static function handle_input(string $input, string $magic)
    {
        Helpers::set_file($input);
        if ($magic == FileMagic::MACHINE_CODE)
        {
            // Each instruction in LMC is a 3 digit decimal number.
            // We can not analyse it if it does not allign
            if (strlen($input) % 3 == 0) {
                $data = str_split($input, 3);

                $total_instructions = count($data);

                for ($i = 0; $i < $total_instructions; $i++) {
                    $token = Token::tokenise($data[$i]);
                    $token->line = $i + 1;

                    // echo $token->line, "<br>", Decompiler::$data_start, "<br>";

                    if ($token->line < Decompiler::$data_start && $token->key === Keys::DATA)
                        Decompiler::$data_start = $token->line;


                    Self::get_shared_decompiler()->push_token_to_queue($token);
                }
            } else {
                die("<script>console.log(`File Error '2167': Input is not divisible by 3`)</script>");
            }
        }

        if ($magic == FileMagic::ASSEMBLY)
        {
            $lines =  explode("\n", $input);

            for ($i = 0; $i < count($lines); $i++) {

                $data = array();

                /*
                    This Regex is to fetch each identifier out of the assembly.
                    It is limited to 3 identifiers per line

                    - \s*(\w+) fetches the first identifer. "+" is used as the first
                    identifier is required

                    - \s*(\w*) Fetches the second identifier. the "*" makes this 
                    identifier optional

                    - \s(\w*)\s* Fetches the final identifier and ignores anything
                    after it spots a whitespace character
                */
                preg_match("/\s*(\w+)\s*(\w*)\s*(\w*)\s*/s", $lines[$i], $data);

                // Gets rid of unneeded info provided by regex
                array_shift($data);

                // Convert the line into tokens
                $token = Token::tokenise($data);
                $token->line = $i + 1;

                if ($token->line < Decompiler::$data_start && $token->key === Keys::DATA)
                Decompiler::$data_start = $token->line;

                Self::get_shared_decompiler()->push_token_to_queue($token);
            }
        }
    }


    public static function get_shared_decompiler(): Decompiler
    {
        if (Helpers::$decompiler == NULL) {
            Helpers::$decompiler = new Decompiler();
        }

        return Helpers::$decompiler;
    }

    static function set_file($file)
    {
        Helpers::$file = $file;
    }


    public static function get_file()
    {
        return Helpers::$file;
    }

    public static function find_line_for_identifer(string $identifier): int|string
    {
        $file = Helpers::get_file();

        // can't do anything if theres no file or input
        if ($file === NULL || empty($identifier)) return Keys::INVALID;

        $lines = explode("\n", $file);

        for ($i = 0; $i < count($lines); $i++) {
            /*
                This fetches an identifier at the start of
                a line and if it exists, it returns line number

                - ^\s* ignore potential whitespace at the start
                - ($identifier) Check if first identifier matches
                the one that we want

            */
            if (preg_match("/^\s*(" . $identifier . ")/", $lines[$i])) {
                return $i + 1;
            }
        }
        return Keys::INVALID;
    }

    public static function get_line(int $line_no)
    {
        $file = Helpers::get_file();

        // can't do anything if theres no file or input
        if ($file === NULL || !is_numeric($line_no)) return Keys::INVALID;

        $lines = explode("\n", $file);

        $data = [];

        if ( count($lines) < $line_no ) return Keys::INVALID;


        /*
            This Regex is to fetch each identifier out of the assembly.
            It is limited to 3 identifiers per line

            - \s*(\w+) fetches the first identifer. "+" is used as the first
            identifier is required

            - \s*(\w*) Fetches the second identifier. the "*" makes this 
            identifier optional

            - \s(\w*)\s* Fetches the final identifier and ignores anything
            after it spots a whitespace character
        */
        preg_match("/\s*(\w+)\s*(\w*)\s*(\w*)\s*/s", $lines[$line_no - 1], $data);
        array_shift($data);
        
        return $data;
    }
    // @Description - Print Objects for debug purposes
    public static function print_object($obj)
    {
        echo "<pre>", var_dump($obj), "</pre>";
    }

};
