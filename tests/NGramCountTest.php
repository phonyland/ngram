<?php

declare(strict_types=1);

use Phonyland\NGram\NGramCount;
use Phonyland\NGram\Tokenizer;

test('N-Gram Count: unigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramCount::unigram($tokens);
    $expected = [
        's' => 1,
        'a' => 1,
        'm' => 1,
        'p' => 1,
        'l' => 1,
        'e' => 2,
        't' => 2,
        'x' => 1,
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Count: bigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramCount::bigram($tokens);
    $expected = [
        'sa' => 1,
        'am' => 1,
        'mp' => 1,
        'pl' => 1,
        'le' => 1,
        'te' => 1,
        'ex' => 1,
        'xt' => 1,
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Count: trigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramCount::trigram($tokens);
    $expected = [
        'sam' => 1,
        'amp' => 1,
        'mpl' => 1,
        'ple' => 1,
        'tex' => 1,
        'ext' => 1,
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Count: multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramCount::multigram(4, $tokens);
    $expected = [
        'samp' => 1,
        'ampl' => 1,
        'mple' => 1,
        'text' => 1,
    ];

    expect($unigrams)->toBe($expected);
});
