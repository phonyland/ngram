<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

it('Tokenizer@tokenize: Seperates the text with the given separator', function (): void {
    // Arrange
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'sample text';

    // Act
    $result = $tokenizer->tokenize($text);

    // Assert
    expect($result)->toBe(['sample', 'text']);
});

it('Tokenizer@tokenize: Seperates the text with multiple separators', function (): void {
    // Arrange
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(' ')
        ->addWordSeparatorPattern(';');

    $text = 'sample text;sample;text';

    // Act
    $result = $tokenizer->tokenize($text);

    // Assert
    expect($result)->toBe(['sample', 'text', 'sample', 'text']);
});

it('Tokenizer@tokenize: Seperates the text with regex patterns', function (): void {
    // Arrange
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern('\s');

    $text = 'sample     text '.PHP_EOL.'sample text';

    // Act
    $result = $tokenizer->tokenize($text);

    // Assert
    expect($result)->toBe(['sample', 'text', 'sample', 'text']);
});

it('Tokenizer@tokenize: A minimum word length can be set', function (): void {
    // Arrange
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'A sample text with a some meaningless words';

    // Act
    $result = $tokenizer->tokenize($text, 6);

    // Assert
    expect($result)->toBe(['sample', 'meaningless']);
});

it('Tokenizer@sentences: Separates the text with the given punctuation into sentences', function (): void {
    // Act
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern('!')
        ->addSentenceSeparatorPattern('?');

    $text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';

    // Act
    $result = $tokenizer->sentences($text);

    // Assert
    expect($result)->toBe([
        'Sample Sentence.',
        'Sample Sentence!',
        'Sample Sentence?',
        'Sample Sentence no.',
        '4?!',
        'Sample sample sentence...',
        'End',
    ]);
});

it('Tokenizer@tokenizeBySentences: Separates the text into tokens by sentences', function (): void {
    // Arrange
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern('!')
        ->addSentenceSeparatorPattern('?')
        ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS)
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';

    // Act
    $result = $tokenizer->tokenizeBySentences($text);

    // Assert
    expect($result)->toBe([
        ['Sample', 'Sentence'],
        ['Sample', 'Sentence'],
        ['Sample', 'Sentence'],
        ['Sample', 'Sentence', 'no'],
        ['Sample', 'sample', 'sentence'],
        ['End'],
    ]);
});

it('Tokenizer@tokenize: Filters the tokens by given removal rule', function (): void {
    // Arrange
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    // Act I
    $tokenizer->addWordFilterRule('/m/');
    // Assert I
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'text']);

    // Act II
    $tokenizer->addWordFilterRule('/x/', 'q');
    // Assert II
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'teqt']);
});

it('Tokenizer: Can convert tokens to lowercase', function (): void {
    // Arrange
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR)
        ->toLowercase();

    $text = 'Sample TeXt';

    // Act
    $result = $tokenizer->tokenize($text);

    // Assert
    expect($result)->toBe(['sample', 'text']);
});

test('Tokenizer: Can be converted to an array', function (): void {
    // Arrange
    $tokenizer = (new Tokenizer())
        ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS)
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern(' ')
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR)
        ->addWordSeparatorPattern(TokenizerFilter::NUMERICAL)
        ->toLowercase();

    // Act
    $result = $tokenizer->toArray();

    // Assert
    expect($result)->toBe([
        'word_filters'                 => [['pattern' => '/[^ \p{L}]+/u', 'replacement' => '']],
        'word_separation_patterns'     => ['\s', '/[^0-9]+/'],
        'sentence_separation_patterns' => ['.', ' '],
        'to_lowercase'                 => true,
    ]);
});
