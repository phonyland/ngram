<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

it('Tokenizer: Seperates the text with the given separator', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'sample text';
    $expected = ['sample', 'text'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

it('Tokenizer: Seperates the text with multiple separators', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(' ')
        ->addWordSeparatorPattern(';');

    $text = 'sample text;sample;text';
    $expected = ['sample', 'text', 'sample', 'text'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

it('Tokenizer: Seperates the text with regex patterns', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern('\s');

    $text = 'sample     text ' . PHP_EOL . 'sample text';
    $expected = ['sample', 'text', 'sample', 'text'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

it('Tokenizer: Separates the text with the given punctuation into sentences', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern('!')
        ->addSentenceSeparatorPattern('?');

    $text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';
    $expected = [
        'Sample Sentence.',
        'Sample Sentence!',
        'Sample Sentence?',
        'Sample Sentence no.',
        '4?!',
        'Sample sample sentence...',
        'End',
    ];

    expect($tokenizer->sentences($text))->toBe($expected);
});

it('Tokenizer: Separates the text into tokens by sentences', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern('!')
        ->addSentenceSeparatorPattern('?')
        ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS)
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';
    $expected = [
        ['Sample', 'Sentence'],
        ['Sample', 'Sentence'],
        ['Sample', 'Sentence'],
        ['Sample', 'Sentence', 'no'],
        ['Sample', 'sample', 'sentence'],
        ['End'],
    ];

    expect($tokenizer->tokenizeBySentences($text))->toBe($expected);
});

it('Tokenizer: Filters the tokens by given removal rule', function (): void {
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $tokenizer->addWordFilterRule('/m/');
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'text']);

    $tokenizer->addWordFilterRule('/x/', 'q');
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'teqt']);
});

it('Tokenizer: Can convert tokens to lowercase', function (): void {
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR)
        ->toLowercase();

    $text = 'Sample TeXt';
    $expected = ['sample', 'text'];

    expect($tokenizer->tokenize($text))->toBe($expected);
});

test('Tokenizer: Can be converted to an array', function (): void {
    $tokenizer = (new Tokenizer())
        ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS)
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern(' ')
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR)
        ->addWordSeparatorPattern(TokenizerFilter::NUMERICAL)
        ->toLowercase();

    $expected = [
        'word_filters'                 => [['pattern' => '/[^ \p{L}]+/u', 'replacement' => '']],
        'word_separation_patterns'     => ['\s', '/[^0-9]+/'],
        'sentence_separation_patterns' => ['.', ' '],
        'to_lowercase'                 => true,
    ];

    expect($tokenizer->toArray())->toMatchArray($expected);
});
