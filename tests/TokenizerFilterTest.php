<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

test('TokenizerFilter::NONE', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::NONE);

    $text = <<<TEXT
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

test('TokenizerFilter::FRENCH', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::FRENCH);

    $text = 'éèëêúüûùœàáäâæíïìîóöôòç#';

    $expected = 'éèëêúüûùœàáäâæíïìîóöôòç';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::ENGLISH', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::ENGLISH);

    $text = 'a-zæœ#';

    $expected = 'azæœ';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::OLD_ENGLISH', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::OLD_ENGLISH);

    $text = 'a-zþðƿȝæœ#';

    $expected = 'azþðƿȝæœ';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::ALPHABETICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::ALPHABETICAL);

    $text = 'a-z#';

    $expected = 'az';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::NUMERICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::NUMERICAL);

    $text = 'a-z#123';

    $expected = '123';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::ALPHANUMBERICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::ALPHANUMBERICAL);

    $text = 'a-z#123';

    $expected = 'az123';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::LATIN_EXTENDED_ALPHABETICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::LATIN_EXTENDED_ALPHABETICAL);

    $text = 'a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß#';

    $expected = 'azéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::LATIN_EXTENDED_ALPHANUMERICAL', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::LATIN_EXTENDED_ALPHANUMERICAL);

    $text = '0-93a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß#';

    $expected = '093azéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß';

    expect($tokenizer->tokenize($text))->toBe([$expected]);
});

test('TokenizerFilter::NO_SYMBOLS', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::NO_SYMBOLS);

    $text = 'abc#%^ abc#%^';

    $expected = ['abc', 'abc'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

test('TokenizerFilter::JAPANESE', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::JAPANESE);

    $text = '科カ苛 abc';

    $expected = ['科カ苛'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

test('TokenizerFilter::CHINESE', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
    $tokenizer->addWordFilterRule(TokenizerFilter::CHINESE);

    $text = '文本 abc';

    $expected = ['文本'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});
