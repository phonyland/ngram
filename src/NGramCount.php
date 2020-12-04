<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class NGramCount
{
    /**
     * Generates n-grams with count for given array of tokens and n-gram level.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, int>
     */
    public static function multigram(int $n, array $tokens): array
    {
        /** @phpstan-var array<string, int> $nGrams */
        $nGrams = [];

        foreach ($tokens as $token) {
            $ngramCount = mb_strlen($token) - $n + 1;

            for ($i = 0; $i < $ngramCount; $i++) {
                $ngram = mb_substr($token, $i, $n);

                if (array_key_exists($ngram, $nGrams)) {
                    $nGrams[$ngram]++;
                } else {
                    $nGrams[$ngram] = 1;
                }
            }
        }

        return $nGrams;
    }

    /**
     * Generates unigrams with count for given array of tokens.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, int>
     */
    public static function unigram(array $tokens): array
    {
        return self::multigram(1, $tokens);
    }

    /**
     * Generates bigrams with count for given array of tokens.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, int>
     */
    public static function bigram(array $tokens): array
    {
        return self::multigram(2, $tokens);
    }

    /**
     * Generates trigrams with count for given array of tokens.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, int>
     */
    public static function trigram(array $tokens): array
    {
        return self::multigram(3, $tokens);
    }
}