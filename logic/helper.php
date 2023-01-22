<?php
include "LMC.php";
include "keys.php";

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
    private static function is_operator_bin(string $opcode): bool|string
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
            case Opcodes::BRA:
            case Opcodes::BRZ:
            case Opcodes::BRP:
                return Keys::BRANCH;

            // Actual Operators
            case Opcodes::ADD:
            case Opcodes::SUB:
            case Opcodes::STA:
            case Opcodes::LDA:
                return true;

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
    private static function is_operator_ins(string $instruction): bool|string
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

                case Mnemonic::BRA:
                case Mnemonic::BRZ:
                case Mnemonic::BRP:
                    return Keys::BRANCH;

                case Mnemonic::ADD:
                case Mnemonic::SUB:
                case Mnemonic::STA:
                case Mnemonic::LDA:
                    return true;

                case Mnemonic::DAT:
                    return Keys::DATA;


                default:
                    return Keys::INVALID;
            }
        }
        return Keys::INVALID;
    }

    /*
        Checks for an operator used

        Arguments:
            String $opcode - 3 character string denoting the instruction or opcode

        return:
            returns true if the input is an operator
            otherwise it returns a key which is used for other logic
    */
    public static function is_operator(string $instruction): bool|string
    {
        if( strlen($instruction) == 3 )
        {
            if ( ctype_digit($instruction) )
                return Self::is_operator_bin($instruction);

            return Self::is_operator_ins($instruction);
        }

        return Keys::INVALID;
    }
};
?>