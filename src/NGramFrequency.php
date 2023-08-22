<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class NGramFrequency
{
    /**
     * Generates n-grams with frequency for given array of tokens and n-gram level.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, float>
     */
    public static function multigram(int $n, array $tokens): array
    {
        /** @var array<string, int> $elementsWithCount */
        $elementsWithCount = NGramCount::multigram($n, $tokens);

        return self::frequencyFromCount($elementsWithCount);
    }

    /**
     * Generates trigrams with frequency for given array of tokens and n-gram level.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, float>
     */
    public static function trigram(array $tokens): array
    {
        return self::multigram(3, $tokens);
    }

    /**
     * Generates bigrams with frequency for given array of tokens and n-gram level.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, float>
     */
    public static function bigram(array $tokens): array
    {
        return self::multigram(2, $tokens);
    }

    /**
     * Generates unigrams with frequency for given array of tokens and n-gram level.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string, float>
     */
    public static function unigram(array $tokens): array
    {
        return self::multigram(1, $tokens);
    }

    /**
     * Calculates the frequency from a n-gram count array.
     *
     * @param  array<string, int>  $countArray
     *
     * @return  array<string, float>
     */
    public static function frequencyFromCount(array &$countArray): array
    {
        $ngrams       = array_keys($countArray);
        $elementCount = count($countArray);

        $sumOfAllApperances = array_sum($countArray);

        for ($i = 0; $i < $elementCount; $i++) {
            $countArray[$ngrams[$i]] /= $sumOfAllApperances;
            // TODO: Allow to adjust the precision here
        }

        return $countArray;
    }
}
