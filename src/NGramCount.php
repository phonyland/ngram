<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class NGramCount
{
    /**
     * Generates n-grams with count for given array of tokens and n-gram level.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, int>
     */
    public static function multigram(int $n, array $tokens): array
    {
        $nGrams = [];

        foreach ($tokens as $token) {
            $ngramCount = mb_strlen($token) - $n + 1;

            for ($i = 0; $i < $ngramCount; $i++) {
                $ngram = mb_substr($token, $i, $n);

                self::elementOnArray($ngram, $nGrams);
            }
        }

        return $nGrams;
    }

    /**
     * Generates trigrams with count for given array of tokens.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, int>
     */
    public static function trigram(array $tokens): array
    {
        return self::multigram(3, $tokens);
    }

    /**
     * Generates bigrams with count for given array of tokens.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, int>
     */
    public static function bigram(array $tokens): array
    {
        return self::multigram(2, $tokens);
    }

    /**
     * Generates unigrams with count for given array of tokens.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, int>
     */
    public static function unigram(array $tokens): array
    {
        return self::multigram(1, $tokens);
    }

    /**
     * Tracks the given element count on $elements array.
     *
     * @param  array<int|string, int>  $elements
     */
    public static function elementOnArray(int|string $element, array &$elements): void
    {
        $elements[$element] ??= 0;
        $elements[$element]++;
    }
}
