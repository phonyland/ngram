<?php

declare(strict_types=1);

namespace Phonyland\NGram;

use RuntimeException;

final class Tokenizer
{
    // region Attributes

    /** @phpstan-var array<TokenizerFilter> $wordFilters */
    private array $wordFilters;
    /** @phpstan-var array<string> $wordSeparationPatterns */
    private array $wordSeparationPatterns;
    /** @phpstan-var array<string> $sentenceSeparationPatterns */
    public array $sentenceSeparationPatterns;
    /** @phpstan-var bool $toLowercase */
    private bool $toLowercase;

    // endregion

    // region Public Methods

    public function __construct()
    {
        $this->wordFilters                = [];
        $this->wordSeparationPatterns     = [];
        $this->sentenceSeparationPatterns = [];
        $this->toLowercase                = false;
    }

    /**
     * Applies the removal rules and returns tokenized array.
     *
     * @phpstan-return array<string>
     */
    public function tokenize(string $text): array
    {
        if ($this->wordSeparationPatterns === []) {
            throw new RuntimeException('No word separation pattern given!');
        }

        $text = $this->toLowercase ? $this->toLowercaseTokens($text) : $text;

        $wordSeparationPattern = '/[' . implode('', $this->wordSeparationPatterns) . ']/';

        /** @phpstan-var  array<string> $tokens */
        $tokens = preg_split($wordSeparationPattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        /** @phpstan-var  array<string|null> $tokens */
        $tokens = preg_replace($this->getFilterPatterns(), $this->getFilterReplacements(), $tokens);

        return array_filter($tokens, fn (string|null $token): bool => !is_null($token) && $token !== '');
    }

    /**
     * Applies the separation patterns and returns sentences.
     *
     * @phpstan-return array<string>
     */
    public function sentences(string $text): array
    {
        if ($this->sentenceSeparationPatterns === []) {
            throw new RuntimeException('No sentence separation pattern given!');
        }

        $sentenceSeparationPattern = implode('', $this->sentenceSeparationPatterns);

        /** @phpstan-var  array<string|null> $sentences */
        $sentences =  preg_split('/(?<=[' . $sentenceSeparationPattern . '])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        return array_filter($sentences, fn (string|null $sentence): bool => !is_null($sentence) && $sentence !== '');
    }

    /**
     * Returns tokens by sentences in arrays.
     *
     * @phpstan-return array<array<string>>
     */
    public function tokenizeBySentences(string $text): array
    {
        $sentences = $this->sentences($text);

        $tokensBySentences = [];

        foreach ($sentences as $sentence) {
            $tokensBySentences[] = $this->tokenize($sentence);
        }

        return array_values(array_filter($tokensBySentences));
    }

    /**
     * @return array{word_filters: array<array{pattern:string, replacement: string}>, word_separation_patterns: string[], sentence_separation_patterns: string[], to_lowercase:bool}
     */
    public function toArray(): array
    {
        return [
            'word_filters'                 => array_map(fn(TokenizerFilter $tokenizerFilter) => $tokenizerFilter->toArray(), $this->wordFilters),
            'word_separation_patterns'     => $this->wordSeparationPatterns,
            'sentence_separation_patterns' => $this->sentenceSeparationPatterns,
            'to_lowercase'                 => $this->toLowercase,
        ];
    }

    // endregion

    // region Private Methods

    /**
     * Get applied filter patterns.
     *
     * @phpstan-return array<string>
     */
    private function getFilterPatterns(): array
    {
        return array_map(fn (TokenizerFilter $filter): string => $filter->pattern, $this->wordFilters);
    }

    /**
     * Get applied filter replacements.
     *
     * @phpstan-return array<string>
     */
    private function getFilterReplacements(): array
    {
        return array_map(fn (TokenizerFilter $filter): string => $filter->replacement, $this->wordFilters);
    }

    /**
     * Lowercases all tokens.
     */
    private function toLowercaseTokens(string $text): string
    {
        return mb_convert_case($text, MB_CASE_LOWER, 'UTF-8');
    }

    // endregion

    // region Fluent Config Setters

    /**
     * Adds a new removal rule.
     */
    public function addWordFilterRule(string $searchRegex, string $replaceString = ''): self
    {
        $this->wordFilters[] = new TokenizerFilter($searchRegex, $replaceString);

        return $this;
    }

    /**
     * Adds a separator pattern for the splitting the given text.
     */
    public function addWordSeparatorPattern(string $wordSeparationPattern): self
    {
        $this->wordSeparationPatterns[] = $wordSeparationPattern;

        return $this;
    }

    /**
     * Adds a separator pattern for the splitting into sentences.
     *
     * @phpstan-param string|array<string> $sentenceSeparationPattern
     */
    public function addSentenceSeparatorPattern($sentenceSeparationPattern): self
    {
        if (is_array($sentenceSeparationPattern)) {
            $this->sentenceSeparationPatterns = array_merge(
                $this->sentenceSeparationPatterns,
                $sentenceSeparationPattern
            );
        } else {
            $this->sentenceSeparationPatterns[] = $sentenceSeparationPattern;
        }

        return $this;
    }

    /**
     * Converts all tokens to lowercase.
     */
    public function toLowercase(bool $toLowercase = true): self
    {
        $this->toLowercase = $toLowercase;

        return $this;
    }

    // endregion
}
