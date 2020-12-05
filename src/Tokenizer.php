<?php

declare(strict_types=1);

namespace Phonyland\NGram;

use RuntimeException;

final class Tokenizer
{
    // region Attributes

    /** @phpstan-var array<TokenizerFilter> */
    private array $filters;
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
        $this->filters = [];
        $this->wordSeparationPatterns = [];
        $this->sentenceSeparationPatterns = [];
        $this->toLowercase = false;
    }

    /**
     * Applies the removal rules and returns tokenized array.
     *
     * @phpstan-return array<string>
     */
    public function tokenize(string $text): array
    {
        $wordSeparationPattern = '/[' . implode('', $this->wordSeparationPatterns) .']/';

        /** @phpstan-var  array<string> $tokens */
        $tokens = preg_split($wordSeparationPattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        /** @phpstan-var  array<string> $tokens */
        $tokens = preg_replace($this->getFilterPatterns(), $this->getFilterReplacements(), $tokens);

        $tokens = $this->toLowercase ? $this->toLowercaseTokens($tokens) : $tokens;

        return array_filter($tokens, fn ($token) => !is_null($token) && $token !== '');
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

        /** @phpstan-var array<string> */
        return preg_split('/(?<=['. $sentenceSeparationPattern .'])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
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

    // endregion

    // region Private Methods

    /**
     * Get applied filter patterns.
     *
     * @phpstan-return array<string>
     */
    private function getFilterPatterns(): array
    {
        return array_map(function (TokenizerFilter $filter): string {
            return $filter->pattern;
        }, $this->filters);
    }

    /**
     * Get applied filter replacements.
     *
     * @phpstan-return array<string>
     */
    private function getFilterReplacements(): array
    {
        return array_map(function (TokenizerFilter $filter): string {
            return $filter->replacement;
        }, $this->filters);
    }

    /**
     * Lowercases all tokens.
     *
     * @param  array  $tokens
     * @phpstan-param array<string> $tokens
     *
     * @return array
     * @phpstan-return array<string>
     */
    private function toLowercaseTokens(array &$tokens): array
    {
        $tokenCount = count($tokens);
        for ($i = 0; $i < $tokenCount; $i++) {
            $tokens[$i] = mb_convert_case($tokens[$i], MB_CASE_LOWER, 'UTF-8');
        }

        return $tokens;
    }

    // endregion

    // region Fluent Config Setters

    /**
     * Adds a new removal rule.
     *
     * @return $this
     */
    public function addWordFilterRule(string $searchRegex, string $replaceString = ''): self
    {
        $this->filters[] = new TokenizerFilter($searchRegex, $replaceString);

        return $this;
    }

    /**
     * Adds a separator pattern for the splitting the given text.
     *
     * @return $this
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
     *
     * @return $this
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
     *
     * @param  bool  $toLowercase
     *
     * @return $this
     */
    public function toLowercase(bool $toLowercase = true): self
    {
        $this->toLowercase = $toLowercase;

        return $this;
    }

    // endregion
}
