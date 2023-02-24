<?php
include_once "LMC.php";
include_once "keys.php";
error_reporting(0);
// @Description - Object to handle tokens
class Token
{
    // @type = Int
    // @Description - Special Flags for certain instructions
    public $Flags = 0;

    // @type = String
    // @Description - Key for the instruction
    public $key = "";

    // @type = String
    // @Description - The value for an instruction
    public $value = "";

    // @type string
    // @Description - Name for data variable if the instruction is DAT
    public $data_name = NULL;

    // @type int
    // description - Line that token represents
    public $line = -1;


    private static function Tokenise_bin(string $opcode, Token $token): void
    {
        // Checking if the input is in the correct format
        if (ctype_digit($opcode) && strlen($opcode) == 3) {
            // Checking the first digit of the instruction
            switch (intval($opcode[0])) {

                    // Doesn't have an operator so returning HALT key
                case Opcodes::HLT:
                    if (intval(substr($opcode, 1, 2)) == Opcodes::HLT) {
                        $token->key = Keys::HALT;
                        break;
                    }

                    // Sometimes the logic may interpret DATA as a HALT instruction
                    // this line is to account for it
                    $token->key = Keys::DATA;
                    $token->value = $opcode;

                    $index = count(Decompiler::$var);
                    array_push(Decompiler::$var, "v$index");
                    break;

                    // User input and output are complicated so using keys for them
                case Opcodes::IO:
                    if (intval($opcode[2] == Opcodes::IO_INPUT)) {
                        $token->key = Keys::INPUT;
                        break;
                    }

                    if (intval($opcode[2] == Opcodes::IO_OUTPUT)) {
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
                    $token->value = substr($opcode, 1, 2);
                    break;

                case Opcodes::ADD:
                    $token->key = Keys::ADD;
                    $token->value = substr($opcode, 1, 2);
                    break;
                case Opcodes::SUB:
                    $token->key = Keys::SUB;
                    $token->value = substr($opcode, 1, 2);
                    break;
                case Opcodes::STA:
                    $token->key = Keys::STORE;
                    $token->value = substr($opcode, 1, 2);
                    break;
                case Opcodes::LDA:
                    $token->key = Keys::LOAD;
                    $token->value = substr($opcode, 1, 2);
                    break;
                default:
                    $token->key = Keys::DATA;
                    $token->value = $opcode;

                    $index = count(Decompiler::$var);
                    array_push(Decompiler::$var, "v$index");
                    break;
            }
        }
    }


    private static function tokenise_ins(array $instruction, Token $token): void
    {
        // Checking if the argument is in the correct format

        if (is_array($instruction) && count($instruction) <= 3 && !empty($instruction)) {

            switch (strtoupper($instruction[0])) {
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
                    $token->value = $instruction[1];
                    break;

                case Mnemonic::ADD:
                    $token->key = Keys::ADD;
                    $token->value = $instruction[1];
                    break;

                case Mnemonic::SUB:
                    $token->key = Keys::SUB;
                    $token->value = $instruction[1];
                    break;

                case Mnemonic::STA:
                    $token->key = Keys::STORE;
                    $token->value = $instruction[1];
                    break;

                case Mnemonic::LDA:
                    $token->key = Keys::LOAD;
                    $token->value = $instruction[1];
                    break;
                case Mnemonic::DAT:
                    $token->key = Keys::DATA;
                    $token->value = $instruction[1];
                    array_push(Decompiler::$var, $token->data_name);
                    break;
                default:
                    if (count($instruction) === 3) {
                        $next = array($instruction[1], $instruction[2]);
                        $token->data_name = $instruction[0];
                        Token::tokenise_ins($next, $token);
                    }
                    break;
            }
        }
    }

    // Converts instruction into a token
    public static function tokenise($instruction): Token
    {
        $token = new Token();

        if (is_array($instruction))
            Self::tokenise_ins($instruction, $token);
        else
            Self::Tokenise_bin($instruction, $token);

        return $token;
    }
}
