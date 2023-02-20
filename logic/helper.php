<?php
include_once "decompiler.php";
require_once "Token.php";


class Helpers
{

    static $decompiler = NULL;




    public static function handle_input(string $input, string $magic)
    {
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



        // TODO: fix
        if ($magic == "1530") // Assembly
        {
            $lines =  explode("\n", $input);
            
            
            for ($i=0; $i < count($lines); $i++) { 
                $data = array();
                # code...

                // echo $lines[$i];
                preg_match("/\s{0,}(\w+)\s{0,}(\w{0,})\s{0,}(\w{0,})/s", $lines[$i], $data);

                
                array_shift($data);
                echo "<pre>", var_dump($data), "</pre>";
                $token = Token::tokenise($data);
                




                

                
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
};
