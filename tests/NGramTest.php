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

test('unigram frequency', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::unigramFrequency($tokens);
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

test('bigram frequency', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::bigramFrequency($tokens);
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

test('trigram frequency', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::trigramFrequency($tokens);
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

test('multigram frequency', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGram::multigramFrequency(4, $tokens);
    $expected = [
        'samp' => 1,
        'ampl' => 1,
        'mple' => 1,
        'text' => 1,
    ];

    expect($unigrams)->toBe($expected);
});
