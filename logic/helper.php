<?php
include_once "decompiler.php";
require_once "Token.php";


class Helpers
{

    static $decompiler = NULL;
    static $file = NULL;


    public static function handle_input(string $input, string $magic)
    {
        Helpers::set_file($input);
        if ($magic == "2167") // File
        {
            if (strlen($input) % 3 == 1) {
                $data = str_split($input, 3);

                $total_instructions = count($data);

                for ($i = 0; $i < $total_instructions; $i++) {
                    $token = Token::tokenise($data[$i]);

                    Self::get_shared_decompiler()->push_token_to_queue($token);
                }
            } else {
                die("<script>console.log(`File Error '2167': Input is not divisible by 3`)</script>");
            }
        }



        if ($magic == "1530") // Assembly
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

    public static function find_line_for_identifer($identifier): int|string
    {
        $file = Helpers::get_file();

        // can't do anything if theres no file
        if ($file === NULL) return Keys::INVALID;

        $lines = explode("\n", $file);

        for ($i=0; $i < count($lines); $i++) { 
            /*
                This fetches an identifier at the start of
                a line and if it exists, it returns line number

                - ^\s* ignore potential whitespace at the start
                - ($identifier) Check if first identifier matches
                the one that we want

            */
            if(preg_match("/^\s*(".$identifier.")/", $lines[$i]))
            {
                return $i + 1;
            }
        }
        return Keys::INVALID;
    }

    public static function print_object($obj)
    {
        echo "<pre>", var_dump($obj), "</pre>";
    }
};
