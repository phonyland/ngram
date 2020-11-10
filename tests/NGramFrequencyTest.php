<?php

declare(strict_types=1);

use Phonyland\NGram\NGramFrequency;
use Phonyland\NGram\Tokenizer;

test('N-Gram Frequency: multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramFrequency::multigram(2, $tokens);
    $expected = [
        'samp',
        'ampl',
        'mple',
        'text',
    ];

    expect($unigrams)->toBe($expected);
});
