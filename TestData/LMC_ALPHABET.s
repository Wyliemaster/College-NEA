START   LDA CURRENT_LETTER
        OUT
        ADD ONE
        STA CURRENT_LETTER
        LDA TOTAL_LETTERS
        SUB ONE
        STA TOTAL_LETTERS
        BRP START
        HLT
CURRENT_LETTER DAT 65
TOTAL_LETTERS DAT 25
ONE     DAT 1