<?php

declare(strict_types=1);

namespace Phonyland\NGram;

use RuntimeException;

final class Tokenizer
{
    // region Attributes

    /** @var array<TokenizerFilter> */
    private array $wordFilters;

    /** @var array<string> */
    private array $wordSeparationPatterns;

    /** @var array<string> */
    public array $sentenceSeparationPatterns;

    /** @var bool */
    private bool $toLowercase;

    // endregion

    // region Public Methods

    public function __construct()
    {
        $this->wordFilters = [];
        $this->wordSeparationPatterns = [];
        $this->sentenceSeparationPatterns = [];
        $this->toLowercase = false;
    }

    /**
     * Applies the removal rules and returns tokenized array.
     *
     * @param  string    $text
     * @param  int|null  $minWordLength
     *
     * @return array<string>
     */
    public function tokenize(string $text, ?int $minWordLength = null): array
    {
        if ($this->wordSeparationPatterns === []) {
            throw new RuntimeException('No word separation pattern given!');
        }

        $text = $this->toLowercase ? $this->toLowercaseTokens($text) : $text;

        $wordSeparationPattern = '/['.implode('', $this->wordSeparationPatterns).']/';

        /** @var array<string> $tokens */
        $tokens = preg_split($wordSeparationPattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        /** @var array<string|null> $tokens */
        $tokens = preg_replace($this->getFilterPatterns(), $this->getFilterReplacements(), $tokens);

        return array_values(array_filter($tokens, function (string|null $token) use ($minWordLength): bool {
            return
                ! is_null($token) &&
                $token !== '' &&
                mb_strlen($token) >= $minWordLength;
        }));
    }

    /**
     * Applies the separation patterns and returns sentences.
     *
     * @param  string  $text
     *
     * @return array<string>
     */
    public function sentences(string $text): array
    {
        if ($this->sentenceSeparationPatterns === []) {
            throw new RuntimeException('No sentence separation pattern given!');
        }

        $sentenceSeparationPattern = implode('', $this->sentenceSeparationPatterns);

        /** @var array<string|null> $sentences */
        $sentences = preg_split('/(?<=['.$sentenceSeparationPattern.'])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        return array_filter($sentences, function (string|null $sentence): bool {
            return ! is_null($sentence) && $sentence !== '';
        });
    }

    /**
     * Returns tokens by sentences in arrays.
     *
     * @param  string    $text
     * @param  int|null  $minWordLength
     *
     * @return array<array<string>>
     */
    public function tokenizeBySentences(string $text, ?int $minWordLength = null): array
    {
        $sentences = $this->sentences($text);

        $tokensBySentences = [];

        foreach ($sentences as $sentence) {
            $tokensBySentences[] = $this->tokenize($sentence, $minWordLength);
        }

        return array_values(array_filter($tokensBySentences));
    }

    /**
     * @return array{word_filters: array<array{pattern:string, replacement: string}>, word_separation_patterns: string[], sentence_separation_patterns: string[], to_lowercase:bool}
     */
    public function toArray(): array
    {
        return [
            'word_filters'                 => array_map(fn (TokenizerFilter $tokenizerFilter): array => $tokenizerFilter->toArray(), $this->wordFilters),
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
     * @return array<string>
     */
    private function getFilterPatterns(): array
    {
        return array_map(fn (TokenizerFilter $filter): string => $filter->pattern, $this->wordFilters);
    }

    /**
     * Get applied filter replacements.
     *
     * @return array<string>
     */
    private function getFilterReplacements(): array
    {
        return array_map(fn (TokenizerFilter $filter): string => $filter->replacement, $this->wordFilters);
    }

    /**
     * Lowercases all tokens.
     *
     * @param  string  $text
     *
     * @return string
     */
    private function toLowercaseTokens(string $text): string
    {
        return mb_convert_case($text, MB_CASE_LOWER, 'UTF-8');
    }

    // endregion

    // region Fluent Config Setters

    /**
     * Adds a new removal rule.
     *
     * @param  string  $searchRegex
     * @param  string  $replaceString
     *
     * @return $this
     */
    public function addWordFilterRule(string $searchRegex, string $replaceString = ''): self
    {
        $this->wordFilters[] = new TokenizerFilter($searchRegex, $replaceString);

        return $this;
    }

    /**
     * Adds a separator pattern for the splitting the given text.
     *
     * @param  string  $wordSeparationPattern
     *
     * @return \Phonyland\NGram\Tokenizer
     */
    public function addWordSeparatorPattern(string $wordSeparationPattern): self
    {
        $this->wordSeparationPatterns[] = $wordSeparationPattern;

        return $this;
    }

    /**
     * Adds a separator pattern for the splitting into sentences.
     *
     * @param  string|array<string>  $sentenceSeparationPattern
     *
     * @return \Phonyland\NGram\Tokenizer
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
     * @return \Phonyland\NGram\Tokenizer
     */
    public function toLowercase(bool $toLowercase = true): self
    {
        $this->toLowercase = $toLowercase;

        return $this;
    }

    // endregion
}
