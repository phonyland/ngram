<?php

declare(strict_types=1);

namespace Phonyland\NGram;

class NGramSequence
{
    /**
     * Generates n-grams for given array of tokens and n-gram level.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string>
     */
    public static function multigram(int $n, array $tokens, bool $isUnique = false): array
    {
        /** @var array<string> $nGrams */
        $nGrams = [];

        foreach ($tokens as $token) {
            $ngramCount = mb_strlen($token) - $n + 1;

            for ($i = 0; $i < $ngramCount; $i++) {
                $nGrams[] = mb_substr($token, $i, $n);
            }
        }

        return $isUnique ? array_values(array_unique($nGrams)) : $nGrams;
    }

    /**
     * Generates trigrams for given array of tokens.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string>
     */
    public static function trigram(array $tokens, bool $isUnique = false): array
    {
        return self::multigram(3, $tokens, $isUnique);
    }

    /**
     * Generates bigrams for given array of tokens.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string>
     */
    public static function bigram(array $tokens, bool $isUnique = false): array
    {
        return self::multigram(2, $tokens, $isUnique);
    }

    /**
     * Generates unigrams for given array of tokens.
     *
     * @param  array<string>  $tokens
     *
     * @return array<string>
     */
    public static function unigram(array $tokens, bool $isUnique = false): array
    {
        return self::multigram(1, $tokens, $isUnique);
    }
}
