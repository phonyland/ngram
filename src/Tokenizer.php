<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class Tokenizer
{
    /**
     * @phpstan-var array<TokenizerFilter>
     */
    private array $filters      = [];
    private string $separator   = '';
    private bool $toLowercase = true;

    public const WHITESPACE_SEPARATOR = '/\s/';

    /**
     * Applies the removal rules and returns tokenized array.
     *
     * @phpstan-return array<string>
     */
    public function tokenize(string $text): array
    {
        /** @phpstan-var  array<string> $tokens */
        $tokens = preg_split($this->separator, $text, -1, PREG_SPLIT_NO_EMPTY);

        /** @phpstan-var  array<string> $tokens */
        $tokens = preg_replace($this->getFilterPatterns(), $this->getFilterReplacements(), $tokens);

        return array_filter($tokens, fn ($token) => !is_null($token) && $token !== '');
    }

    /**
     * Adds a new removal rule.
     *
     * @return $this
     */
    public function addRemovalRule(string $searchRegex, string $replaceString = ''): self
    {
        $this->filters[] = new TokenizerFilter($searchRegex, $replaceString);

        return $this;
    }

    /**
     * Sets the separator for the splitting the given text.
     *
     * @return $this
     */
    public function setSeparator(string $seperator): self
    {
        $this->separator = $seperator;

        return $this;
    }

    /**
     * Converts all tokens to lowercase.
     *
     * @param  bool  $toLowercase
     *
     * @return $this
     */
    public function toLowercase(bool $toLowercase): self
    {
        $this->toLowercase = $toLowercase;

        return $this;
    }

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
}
