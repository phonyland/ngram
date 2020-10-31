<?php

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

test('TokenizerFilter::NONE', function () {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokenizer->addRemovalRule(TokenizerFilter::NONE);

    $text = <<<TEXT
            this is a very
            long string that
            doesn't require
            horizontal scrolling, 
            and interpolates variables :
            Hello
            TEXT;

    $expected = "thisisaverylongstringthatdoesn'trequirehorizontalscrolling,andinterpolatesvariables:Hello";

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});
