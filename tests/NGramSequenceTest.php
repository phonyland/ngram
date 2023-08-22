<?php

declare(strict_types=1);

use Phonyland\NGram\NGramSequence;
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilterType;

test('N-Gram Sequence: Multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramSequence::multigram(4, $tokens);
    $expected = [
        'samp',
        'ampl',
        'mple',
        'text',
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Sequence: Trigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramSequence::trigram($tokens);
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

test('N-Gram Sequence: Bigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramSequence::bigram($tokens);
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

test('N-Gram Sequence: Unigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramSequence::unigram($tokens);
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

test('N-Gram Sequence: Unigram (Unique)', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);
    $tokens = $tokenizer->tokenize('sample text');

    $unigrams = NGramSequence::unigram($tokens, true);
    $expected = [
        's',
        'a',
        'm',
        'p',
        'l',
        'e',
        't',
        'x',
    ];

    expect($unigrams)->toBe($expected);
});
