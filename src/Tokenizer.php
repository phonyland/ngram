<?php

declare(strict_types=1);

namespace Phonyland\NGram;

/**
 * @internal
 */
final class Tokenizer
{
    /**
     * @phpstan-var array<\Phonyland\NGram\TokenizerFilter>
     */
    private array $filters      = [];
    private string $separator   = '';

    public const WHITESPACE_SEPARATOR = '/\s/';

    /**
     * Applies the removal rules and returns tokenized array.
     *
     * @param  string  $text
     *
     * @return array
     * @phpstan-return array<string>
     */
    public function tokenize(string $text): array
    {
        $text = preg_replace($this->getFilterPatterns(), $this->getFilterReplacements(), $text);

        return preg_split($this->separator, $text, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Adds a new removal rule.
     *
     * @param  string  $searchRegex
     * @param  string  $replaceString
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
     * @param  string  $seperator
     *
     * @return $this
     */
    public function setSeparator(string $seperator): self
    {
        $this->separator = $seperator;

        return $this;
    }

    /**
     * Get applied filter patterns.
     *
     * @return array
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
     * @return array
     * @phpstan-return array<string>
     */
    private function getFilterReplacements(): array
    {
        return array_map(function (TokenizerFilter $filter): string {
            return $filter->replacement;
        }, $this->filters);
    }
}
