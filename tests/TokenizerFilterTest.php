<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;
use Phonyland\NGram\TokenizerFilterType;

test('TokenizerFilter: Can be converted to an array', function (): void {
    $tokenizerFilter = new TokenizerFilter(TokenizerFilterType::ALPHABETICAL, '');

    $expected = [
        'pattern' => '/[^a-z]+/',
        'replacement' => '',
    ];

    expect($tokenizerFilter->toArray())->toBe($expected);
});

test('TokenizerFilterType::NONE', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::NONE);

    $text = <<<'TEXT'
            this is a very
            long string that
            doesn't require
            horizontal scrolling,
            and interpolates variables :
            Hello
            TEXT;
    $expected = [
        'this',
        'is',
        'a',
        'very',
        'long',
        'string',
        'that',
        'doesn\'t',
        'require',
        'horizontal',
        'scrolling,',
        'and',
        'interpolates',
        'variables',
        ':',
        'Hello',
    ];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

test('TokenizerFilterType::FRENCH', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::FRENCH);

    $text = 'éèëêúüûùœàáäâæíïìîóöôòç#';
    $expected = 'éèëêúüûùœàáäâæíïìîóöôòç';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::ENGLISH', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ENGLISH);

    $text = 'a-zæœ#';
    $expected = 'azæœ';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::OLD_ENGLISH', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::OLD_ENGLISH);

    $text = 'a-zþðƿȝæœ#';
    $expected = 'azþðƿȝæœ';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::ALPHABETICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ALPHABETICAL);

    $text = 'a-z#';
    $expected = 'az';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::NUMERICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::NUMERICAL);

    $text = 'a-z#123';
    $expected = '123';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::ALPHANUMBERICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::ALPHANUMBERICAL);

    $text = 'a-z#123';
    $expected = 'az123';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::LATIN_EXTENDED_ALPHABETICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::LATIN_EXTENDED_ALPHABETICAL);

    $text = 'a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß#';
    $expected = 'azéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::LATIN_EXTENDED_ALPHANUMERICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::LATIN_EXTENDED_ALPHANUMERICAL);

    $text = '0-93a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß#';
    $expected = '093azéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilterType::NO_SYMBOLS', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::NO_SYMBOLS);

    $text = 'abc#%^ abc#%^';
    $expected = ['abc', 'abc'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

test('TokenizerFilterType::JAPANESE', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::JAPANESE);

    $text = '科カ苛 abc';
    $expected = ['科カ苛'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

test('TokenizerFilterType::CHINESE', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordFilterRule(TokenizerFilterType::CHINESE);

    $text = '文本 abc';
    $expected = ['文本'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});
