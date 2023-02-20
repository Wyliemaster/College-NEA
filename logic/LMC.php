<?php
class Opcodes
{
    const HLT = 0;

    const ADD = 1;
    const SUB = 2;
    const STA = 3;
    const LDA = 5;
    const BRA = 6;
    const BRZ = 7;
    const BRP = 8;

    const IO = 9;
    const IO_INPUT = 1;
    const IO_OUTPUT = 2;
};

class Mnemonic
{
    const HLT = "HLT";

    const ADD = "ADD";
    const SUB = "SUB";
    const STA = "STA";
    const LDA = "LDA";
    const BRA = "BRA";
    const BRZ = "BRZ";
    const BRP = "BRP";

    const INP = "INP";
    const OUT = "OUT";

    const DAT = "DAT";
};

class FileMagic
{
    const ASSEMBLY = "1530";
    const MACHINE_CODE = "2167";
}

class Flags
{
    // enums don't allow chosing the number in php for some reason
    // enum Flags 
    // {
    //     case kZero = 1;
    //     case kPositive = 2;
    // };
    const kZero = 1 << 0;
    const kPositive = 1 << 1;
}
