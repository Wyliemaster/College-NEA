        INP
        STA NUM_ONE
        INP
        STA NUM_TWO
LOOP    LDA RESULT
        ADD NUM_TWO
        STA RESULT
        LDA NUM_ONE
        SUB ONE
        STA NUM_ONE
        BRP LOOP
        LDA RESULT
        SUB NUM_TWO
        STA RESULT
        OUT
        HLT
ONE DAT 1
RESULT DAT 0
NUM_ONE DAT 0
NUM_TWO DAT 0
