<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

it('seperates the text with the given separator', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'sample text';

    expect($tokenizer->tokenize($text))
        ->toBe(['sample', 'text']);
});

it('seperates the text with multiple separators', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addWordSeparatorPattern(' ')
        ->addWordSeparatorPattern(';');

    $text = 'sample text;sample;text';

    expect($tokenizer->tokenize($text))
        ->toBe(['sample', 'text', 'sample', 'text']);
});

it('seperates the text with regex patterns', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->addWordSeparatorPattern('\s');

    $text = 'sample     text '.PHP_EOL.'sample text';

    expect($tokenizer->tokenize($text))
        ->toBe(['sample', 'text', 'sample', 'text']);
});

it('separates the text with the given punctuation into sentences', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern('!')
        ->addSentenceSeparatorPattern('?');

    $text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';

    expect($tokenizer->sentences($text))
        ->toBe([
                   'Sample Sentence.',
                   'Sample Sentence!',
                   'Sample Sentence?',
                   'Sample Sentence no.',
                   '4?!',
                   'Sample sample sentence...',
                   'End',
               ]);
});

it('separates the text into tokens by sentences', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer
        ->addSentenceSeparatorPattern('.')
        ->addSentenceSeparatorPattern('!')
        ->addSentenceSeparatorPattern('?')
        ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS)
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';

    expect($tokenizer->tokenizeBySentences($text))
        ->toBe([
                   ['Sample', 'Sentence'],
                   ['Sample', 'Sentence'],
                   ['Sample', 'Sentence'],
                   ['Sample', 'Sentence', 'no'],
                   ['Sample', 'sample', 'sentence'],
                   ['End'],
               ]);
});

it('filters the tokens by given removal rule', function (): void {
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

    $tokenizer->addWordFilterRule('/m/');
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'text']);

    $tokenizer->addWordFilterRule('/x/', 'q');
    expect($tokenizer->tokenize('sample text'))->toBe(['saple', 'teqt']);
});

it('can convert tokens to lowercase', function (): void {
    $tokenizer = (new Tokenizer())
        ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR)
        ->toLowercase();

    $text = 'Sample TeXt';

    expect($tokenizer->tokenize($text))
        ->toBe(['sample', 'text']);
});
