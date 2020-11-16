<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class NGramModel
{
    /**
     * Generates n-grams with frequency for given array of tokens and n-gram level.
     *
     * @phpstan-param  array<string> $tokens
     *
     * @phpstan-return array<string, int>
     */
    public static function multigram(int $n, array $tokens): array
    {
        /** @phpstan-var array<string, int> $elements */
        $elements = [];
        /** @phpstan-var array<string, float> $firstElements */
        $firstElements = [];

        foreach ($tokens as $token) {
            $ngramCount = mb_strlen($token) - $n + 1;

            /** @var \Phonyland\NGram\NGramElement|null $previousNGramElement */
            $previousNGramElement = null;

            for ($i = 0; $i < $ngramCount; $i++) {
                $ngram = mb_substr($token, $i, $n);

                /** @var \Phonyland\NGram\NGramElement|null $ngramElement */
                $ngramElement = !array_key_exists($ngram, $elements)
                    ? $elements[$ngram] = new NGramElement()
                    : $elements[$ngram];

                if ($i === 0) {
                    $firstElements[] = $ngram;
                }

                if ($previousNGramElement !== null) {
                    // check if it is the last children or not
                    if ($i === $ngramCount - 1) {
                        $previousNGramElement->lastChildren[$ngram] = !array_key_exists($ngram, $previousNGramElement->lastChildren)
                            ? $previousNGramElement->lastChildren[$ngram] = 1
                            : $previousNGramElement->lastChildren[$ngram] + 1;
                    } else {
                        $previousNGramElement->children[$ngram] = !array_key_exists($ngram, $previousNGramElement->children)
                            ? $previousNGramElement->children[$ngram] = 1
                            : $previousNGramElement->children[$ngram] + 1;
                    }
                }

                $previousNGramElement = $ngramElement;
            }
        }

        $nGramKeys = array_keys($elements);
        $nGramKeyCount = count($nGramKeys);

        for ($i = 0; $i < $nGramKeyCount; $i++) {
            $ngram = $nGramKeys[$i];
            /** @var \Phonyland\NGram\NGramElement $ngramElement */
            $ngramElement = $elements[$ngram];

            $childrenKeys = array_keys($ngramElement->children);
            $childrenKeyCount = count($childrenKeys);
            $sumChildren = 0;

            for ($a = 0; $a < $childrenKeyCount; $a++) {
                $sumChildren += $ngramElement->children[$childrenKeys[$a]];
            }

            for ($b = 0; $b < $childrenKeyCount; $b++) {
                $ngramElement->children[$childrenKeys[$b]] /= $sumChildren;
            }

            $ngramElement->hasChildren = $childrenKeyCount > 0;

            $lastChildrenKeys = array_keys($ngramElement->lastChildren);
            $lastChildrenCount = count($lastChildrenKeys);
            $sumLastChildren = 0;

            for ($c = 0; $c < $lastChildrenCount; $c++) {
                $sumLastChildren += $ngramElement->lastChildren[$lastChildrenKeys[$c]];
            }

            for ($d = 0; $d < $lastChildrenCount; $d++) {
                $ngramElement->lastChildren[$lastChildrenKeys[$d]] /= $sumLastChildren;
            }

            $ngramElement->hasLastChildren = $lastChildrenCount > 0;
        }

        // Compact

        for ($x = 0; $x < $nGramKeyCount; $x++)
        {
            /** @var \Phonyland\NGram\NGramElement $ngramElement */
            $ngramElement = $elements[$nGramKeys[$x]];

            $elements[$nGramKeys[$x]] = [
                $ngramElement->hasChildren ? $ngramElement->children : 0,
                $ngramElement->hasLastChildren ? $ngramElement->lastChildren : 0,
            ];
        }

        return [
            'e' => $elements,
            'fe' => NGramFrequency::multigram($n, $firstElements),
        ];
    }
}
