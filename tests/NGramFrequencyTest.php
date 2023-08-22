<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramFrequency;
use Phonyland\NGram\TokenizerFilterType;

test('N-Gram Frequency: Multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ALPHABETICAL);
    $tokens = $tokenizer->tokenize('bombadil! bombadillo!');

    $unigrams = NGramFrequency::multigram(4, $tokens);

    $expected = [
        'bomb' => 0.16666666666666666,
        'omba' => 0.16666666666666666,
        'mbad' => 0.16666666666666666,
        'badi' => 0.16666666666666666,
        'adil' => 0.16666666666666666,
        'dill' => 0.08333333333333333,
        'illo' => 0.08333333333333333,
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Frequency: Trigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ALPHABETICAL);
    $tokens = $tokenizer->tokenize('bombadil! bombadillo!');

    $unigrams = NGramFrequency::trigram($tokens);

    $expected = [
        'bom' => 0.14285714285714285,
        'omb' => 0.14285714285714285,
        'mba' => 0.14285714285714285,
        'bad' => 0.14285714285714285,
        'adi' => 0.14285714285714285,
        'dil' => 0.14285714285714285,
        'ill' => 0.07142857142857142,
        'llo' => 0.07142857142857142,
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Frequency: Bigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ALPHABETICAL);
    $tokens = $tokenizer->tokenize('bombadil! bombadillo!');

    $unigrams = NGramFrequency::bigram($tokens);

    $expected = [
        'bo' => 0.125,
        'om' => 0.125,
        'mb' => 0.125,
        'ba' => 0.125,
        'ad' => 0.125,
        'di' => 0.125,
        'il' => 0.125,
        'll' => 0.0625,
        'lo' => 0.0625,
    ];

    expect($unigrams)->toBe($expected);
});

test('N-Gram Frequency: Unigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ALPHABETICAL);
    $tokens = $tokenizer->tokenize('bombadil! bombadillo!');

    $unigrams = NGramFrequency::unigram($tokens);

    $expected = [
        'b' => 0.2222222222222222,
        'o' => 0.16666666666666666,
        'm' => 0.1111111111111111,
        'a' => 0.1111111111111111,
        'd' => 0.1111111111111111,
        'i' => 0.1111111111111111,
        'l' => 0.16666666666666666,
    ];

    expect($unigrams)->toBe($expected);
});
