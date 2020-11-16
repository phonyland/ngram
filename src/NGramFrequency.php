<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class NGramFrequency
{
    /**
     * Generates n-grams with frequency for given array of tokens and n-gram level.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, float>
     */
    public static function multigram(int $n, array $tokens): array
    {
        /** @phpstan-var array<string, float> $elementsWithCount */
        $elementsWithCount = NGramCount::multigram($n, $tokens);
        $ngrams = array_keys($elementsWithCount);
        $elementCount = count($elementsWithCount);

        $sumOfAllApperances = array_sum($elementsWithCount);

        for ($i = 0; $i < $elementCount; $i++) {
            $elementsWithCount[$ngrams[$i]] /= $sumOfAllApperances;
        }

        return $elementsWithCount;
    }

    /**
     * Generates trigrams with frequency for given array of tokens and n-gram level.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, float>
     */
    public static function trigram(array $tokens): array
    {
        return self::multigram(3, $tokens);
    }

    /**
     * Generates bigrams with frequency for given array of tokens and n-gram level.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, float>
     */
    public static function bigram(array $tokens): array
    {
        return self::multigram(2, $tokens);
    }

    /**
     * Generates unigrams with frequency for given array of tokens and n-gram level.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, float>
     */
    public static function unigram(array $tokens): array
    {
        return self::multigram(1, $tokens);
    }
}
