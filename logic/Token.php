<?php
include "LMC.php";
include "keys.php";
error_reporting(0);
class Token
{
    // @type = Int
    public $Flags = 0;

    // @type = String
    public $key = "";

    // @type = String
    public $value = "";

    // @type string
    public $data_name = NULL;

    
    private static function Tokenise_bin(string $opcode, Token $token): void
    {
        // Checking if the input is in the correct format
        if ( ctype_digit($opcode) && strlen($opcode) == 3 )
        {

            // Checking the first digit of the instruction
           switch ( intval($opcode[0]) )
           {

            // Doesn't have an operator so returning HALT key
            case Opcodes::HLT:
                if ( intval($opcode) == Opcodes::HLT )
                    $token->key = Keys::HALT;

            // User input and output are complicated so using keys for them
            case Opcodes::IO:
                if ( intval($opcode[2] == Opcodes::IO_INPUT ) )
                {
                    $token->key = Keys::INPUT;
                    break;
                }

                if ( intval($opcode[2] == Opcodes::IO_OUTPUT) )
                {
                    $token->key = Keys::OUTPUT;
                    break;
                }

            // Branching
            case Opcodes::BRZ:
                $token->Flags |= Flags::kZero;
            case Opcodes::BRP:
                $token->Flags |= Flags::kPositive;
            case Opcodes::BRA:
                $token->key = Keys::BRANCH;

            case Opcodes::ADD:
                $token->key = Keys::ADD;
            case Opcodes::SUB:
                $token->key = Keys::SUB;
            case Opcodes::STA:
                $token->key = Keys::STORE;
            case Opcodes::LDA:
                $token->key = Keys::LOAD;

            default:
                $token->key = Keys::DATA;
           }
           echo var_dump($token);
        }
    }


    private static function tokenise_ins(array $instruction, Token $token): void
    {
        // Checking if the argument is in the correct format
        if ( count($instruction) < 3 && !ctype_digit($instruction[0]) && strlen($instruction[0]) == 3 )
        {
            switch($instruction[0])
            {
                case Mnemonic::HLT:
                    $token->key = Keys::HALT;
                    break;

                case Mnemonic::INP:
                    $token->key = Keys::INPUT;
                    break;

                case Mnemonic::OUT:
                    $token->key = Keys::OUTPUT;
                    break;

                case Mnemonic::BRZ:
                    $token->Flags |= Flags::kZero;

                case Mnemonic::BRP:
                    $token->Flags |= Flags::kPositive;

                case Mnemonic::BRA:
                    $token->key = Keys::BRANCH;
                    break;

                case Mnemonic::ADD:
                    $token->key = Keys::ADD;
                    break;

                case Mnemonic::SUB:
                    $token->key = Keys::SUB;
                    break;

                case Mnemonic::STA:
                    $token->key = Keys::STORE;
                    break;

                case Mnemonic::LDA:
                    $token->key = Keys::LOAD;
                    break;


                default:
                    $token->key = Keys::INVALID;
                    break;

            }
            $token->value = $instruction[1];
        }

        else
        {
            if ($instruction[1] == Mnemonic::DAT)
            {
                $token->data_name = $instruction[0];
                $token->key = Keys::DATA;
                $token->value = $instruction[2];
            }
        }

        echo var_dump($token);

    }


    public static function tokenise($instruction): Token
    {

        $token = new Token();


        if (!is_array($instruction))
            Self::Tokenise_bin($instruction, $token);

        else
            Self::tokenise_ins($instruction, $token);

        return $token;
    }
}