<?php

declare(strict_types=1);

use Phonyland\NGram\NGramSequence;
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

test('N-Gram Sequence: unigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
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

test('N-Gram Sequence: bigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
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

test('N-Gram Sequence: trigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
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

test('N-Gram Sequence: multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
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

test('N-Gram Sequence: unique unigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
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
