<?php

declare(strict_types=1);

namespace Phonyland\NGram;

/**
 * @internal
 */
final class Tokenizer
{
    private array $removalRules = [];
    private array $replaceRules = [];
    private string $separator   = '';

    public const WHITESPACE_SEPARATOR = '/\s/';

    /**
     * Applies the removal rules and returns tokenized array.
     *
     * @param  string  $text
     *
     * @return array
     */
    public function tokenize(string $text): array
    {
        $text = preg_replace($this->removalRules, $this->replaceRules, $text);

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
        $this->removalRules[] = $searchRegex;
        $this->replaceRules[] = $replaceString;

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
}
