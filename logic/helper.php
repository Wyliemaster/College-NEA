<?php
include "LMC.php";
include "keys.php";
include "Token.php";

class Helpers
{

    /*
        Checks for an operator for the binary version of LMC

        Arguments:
            String $opcode - 3 digit number as string in Format: xxx

        return:
            returns true if the input is an operator
            otherwise it returns a key which is used for other logic
    */
    private static function Tokenise_bin(string $opcode, Token $token): string
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
                    return Keys::HALT;

            // User input and output are complicated so using keys for them
            case Opcodes::IO:
                if ( intval($opcode[2] == Opcodes::IO_INPUT ) )
                    return Keys::INPUT;

                if ( intval($opcode[2] == Opcodes::IO_OUTPUT) )
                {
                    return Keys::OUTPUT;
                }
                break;

            // Branching
            case Opcodes::BRZ:
                $token->Flags |= Flags::kZero;
            case Opcodes::BRP:
                $token->Flags |= Flags::kPositive;
            case Opcodes::BRA:
                return Keys::BRANCH;

            case Opcodes::ADD:
                return Keys::ADD;
            case Opcodes::SUB:
                return Keys::SUB;
            case Opcodes::STA:
                return Keys::STORE;
            case Opcodes::LDA:
                return Keys::LOAD;

            default:
                return Keys::DATA;
           }
        }

        return Keys::INVALID;
    }

    /*
        Checks for an operator for the Mnemonic version of LMC

        Arguments:
            String $opcode - 3 character string denoting the instruction

        return:
            returns true if the input is an operator
            otherwise it returns a key which is used for other logic
    */
    private static function tokenise_ins(string $instruction, Token $token): string
    {
        // Checking if the argument is in the correct format
        if ( !ctype_digit($instruction) && strlen($instruction) == 3 )
        {
            switch($instruction)
            {
                case Mnemonic::HLT:
                    return Keys::HALT;

                case Mnemonic::INP:
                    return Keys::INPUT;

                case Mnemonic::OUT:
                    return Keys::OUTPUT;

                case Mnemonic::BRZ:
                    $token->Flags |= Flags::kZero;

                case Mnemonic::BRP:
                    $token->Flags |= Flags::kPositive;

                case Mnemonic::BRA:
                    return Keys::BRANCH;

                case Mnemonic::ADD:
                    return Keys::ADD;
                case Mnemonic::SUB:
                    return Keys::SUB;
                case Mnemonic::STA:
                    return Keys::STORE;
                case Mnemonic::LDA:
                    return Keys::LOAD;

                case Mnemonic::DAT:
                    return Keys::DATA;


                default:
                    return Keys::INVALID;
            }
        }
        return Keys::INVALID;
    }

    /*

        Arguments:
            String $opcode - 3 character string denoting the instruction or opcode

        return:
            returns a token alongside flags for instruction
    */
    public static function tokenise(string $instruction): Token
    {
        if( strlen($instruction) == 3 )
        {
            $key = Keys::INVALID;

            $token = new Token();

            if ( ctype_digit($instruction) )
                $key =  Self::Tokenise_bin($instruction, $token);

            $key = Self::tokenise_ins($instruction, $token);

            $token->key = $key;
        }

        return $token;
        // return Keys::INVALID;
    }
};
?>