<?php

declare(strict_types=1);

namespace Phonyland\NGram;

class NGramCount
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

                self::incrementElementCount($ngram, $nGrams);
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
     * Tracks the count of a given element in the `$elements` array.
     *
     * This method increments the count of the specified element within the provided array.
     * If the element doesn't exist in the array, it initializes its count to 1.
     *
     * @param  int|string  $element   The element whose count needs to be tracked.
     * @param  array<int|string, int>  &$elementCounts   Reference to the array containing element counts.
     */
    public static function incrementElementCount(int|string $element, array &$elementCounts): void
    {
        $elementCounts[$element] ??= 0;
        $elementCounts[$element]++;
    }
}
