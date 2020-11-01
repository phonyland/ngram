<?php

declare(strict_types=1);

use Phonyland\NGram\NGram;
use Phonyland\NGram\Tokenizer;

test('unigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::unigram($tokens);
    $expected = [
        's',
        'a',
        'm',
        'p',
        'l',
        'e',
        't',
        'e',
        'x',
        't',
    ];

    expect($unigrams)->toBe($expected);
});

test('bigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::bigram($tokens);
    $expected = [
        'sa',
        'am',
        'mp',
        'pl',
        'le',
        'te',
        'ex',
        'xt',
    ];

    expect($unigrams)->toBe($expected);
});

test('trigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::trigram($tokens);
    $expected = [
        'sam',
        'amp',
        'mpl',
        'ple',
        'tex',
        'ext',
    ];

    expect($unigrams)->toBe($expected);
});

test('multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::multigram(4, $tokens);
    $expected = [
        'samp',
        'ampl',
        'mple',
        'text',
    ];

    expect($unigrams)->toBe($expected);
});
