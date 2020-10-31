<?php

use Phonyland\NGram\Tokenizer;

it('seperates the text with the given seperator', function () {
    $tokenizer = new Tokenizer();

    $tokenizer->setSeparator('/\s/');
    expect($tokenizer->tokenize('sample text'))->toBe(['sample', 'text']);

    $tokenizer->setSeparator('/e/');
    expect($tokenizer->tokenize('sample text'))->toBe(['sampl', ' t', 'xt']);
});

it('removes the tokens by given removal rule', function () {
    $tokenizer = (new Tokenizer())->setSeparator('/\s/');

    $tokenizer->addRemovalRule('/m/');
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'text']);

    $tokenizer->addRemovalRule('/x/', 'q');
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'teqt']);
});

// multiple
