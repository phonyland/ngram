<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilterType;

describe('Tokenizer@tokenize', function () {
    test('it can separate the text from the given separator', function (): void {
        // Arrange
        $tokenizer = new Tokenizer();
        $tokenizer->addWordSeparatorPattern(wordSeparationPattern: TokenizerFilterType::WHITESPACE_SEPARATOR);

        $text = 'sample text';

        // Act
        $result = $tokenizer->tokenize($text);

        // Assert
        expect($result)->toBe(['sample', 'text']);
    });

    test('it can separate the text from multiple separators', function (): void {
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

    test('it can separate the text from regex patterns', function (): void {
        // Arrange
        $tokenizer = new Tokenizer();
        $tokenizer->addWordSeparatorPattern('\s');

        $text = 'sample     text '.PHP_EOL.'sample text';

        // Act
        $result = $tokenizer->tokenize($text);

        // Assert
        expect($result)->toBe(['sample', 'text', 'sample', 'text']);
    });

    test('A minimum word length can be set', function (): void {
        // Arrange
        $tokenizer = new Tokenizer();
        $tokenizer->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);

        $text = 'A sample text with some meaningless words';

        // Act
        $result = $tokenizer->tokenize(text: $text, minWordLength: 6);

        // Assert
        expect($result)->toBe(['sample', 'meaningless']);
    });

    it('it can filter the tokens by given removal rule', function (): void {
        // Arrange
        $tokenizer = (new Tokenizer())
            ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);

        // Act I
        $tokenizer->addWordFilterRule('/m/');
        // Assert I
        expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'text']);

        // Act II
        $tokenizer->addWordFilterRule('/x/', 'q');
        // Assert II
        expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'teqt']);
    });
});

describe('Tokenizer@sentences', function () {
    test('it can separate the text with the given punctuation into sentences', function (): void {
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
});

describe('Tokenizer@tokenizeBySentences', function () {
    test('it can separate the text into tokens by sentences', function (): void {
        // Arrange
        $tokenizer = new Tokenizer();
        $tokenizer
            ->addSentenceSeparatorPattern('.')
            ->addSentenceSeparatorPattern('!')
            ->addSentenceSeparatorPattern('?')
            ->addWordFilterRule(TokenizerFilterType::NO_SYMBOLS)
            ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR);

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
});

test('it can convert tokens to lowercase', function (): void {
    // Arrange
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->toLowercase();

    $text = 'Sample TeXt';

    // Act
    $result = $tokenizer->tokenize($text);

    // Assert
    expect($result)->toBe(['sample', 'text']);
});

test('it can convert tokens to an array', function (): void {
    // Arrange
    $tokenizer = (new Tokenizer())
        ->addWordFilterRule(TokenizerFilterType::NO_SYMBOLS)
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern(' ')
        ->addWordSeparatorPattern(TokenizerFilterType::WHITESPACE_SEPARATOR)
        ->addWordSeparatorPattern(TokenizerFilterType::NUMERICAL)
        ->toLowercase();

    // Act
    $result = $tokenizer->toArray();

    // Assert
    expect($result)->toBe([
        'word_filters' => [['pattern' => '/[^ \p{L}]+/u', 'replacement' => '']],
        'word_separation_patterns' => ['\s', '/[^0-9]+/'],
        'sentence_separation_patterns' => ['.', ' '],
        'to_lowercase' => true,
    ]);
});
