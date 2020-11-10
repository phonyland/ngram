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
     * @phpstan-return array<string, int>
     */
    public static function multigram(int $n, array $tokens): array
    {
        /** @phpstan-var array<string, int> $frequency */
        $frequency = [
            'elements' => [],
            'firstElements' => [],
        ];

        foreach ($tokens as $token) {
            $ngramCount = mb_strlen($token) - $n + 1;
            /** @var \Phonyland\NGram\NGramElement $previousNGramElement */
            $previousNGramElement = null;

            for ($i = 0; $i < $ngramCount; $i++) {
                $ngram = mb_substr($token, $i, $n);

                $ngramElement = !array_key_exists($ngram, $frequency['elements'])
                    ? $frequency['elements'][$ngram] = new NGramElement()
                    : $frequency['elements'][$ngram];

                if ($i === 0) {
                    $ngramElement->probabilityAsFirst++;
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

        $keys = array_keys($frequency['elements']);
        $keyCount = count($keys);
        $validFirst = [];
        $sumFirst = 0;

        for ($i = 0; $i < $keyCount; $i++) {
            $key = $keys[$i];
            /** @var \Phonyland\NGram\NGramElement $element */
            $element = $frequency['elements'][$key];

            // Valid Firsts
            if ($element->probabilityAsFirst > 0) {
                if (!array_key_exists($key, $validFirst)) {
                    $validFirst[$key] = $element->probabilityAsFirst;
                    $sumFirst += $element->probabilityAsFirst;
                } else {
                    $validFirst[$key] += $element->probabilityAsFirst;
                    $sumFirst += $element->probabilityAsFirst;
                }
            }

            unset($element->probabilityAsFirst);

            $childrenKeys = array_keys($element->children);
            $childrenKeyCount = count($childrenKeys);
            $sumChildren = 0;

            for ($a = 0; $a < $childrenKeyCount; $a++) {
                $sumChildren += $element->children[$childrenKeys[$a]];
            }

            for ($b = 0; $b < $childrenKeyCount; $b++) {
                $element->children[$childrenKeys[$b]] /= $sumChildren;
            }

            $element->hasChildren = $childrenKeyCount > 0;

            $lastChildrenKeys = array_keys($element->lastChildren);
            $lastChildrenCount = count($lastChildrenKeys);
            $sumLastChildren = 0;

            for ($c = 0; $c < $lastChildrenCount; $c++) {
                $sumLastChildren += $element->lastChildren[$lastChildrenKeys[$c]];
            }

            for ($d = 0; $d < $lastChildrenCount; $d++) {
                $element->lastChildren[$lastChildrenKeys[$d]] /= $sumLastChildren;
            }

            $element->hasLastChildren = $lastChildrenCount > 0;
        }

        $validFirstKeys = array_keys($validFirst);
        $validFirstKeyCount = count($validFirstKeys);

        for ($v = 0; $v < $validFirstKeyCount; $v++) {
            $key = $validFirstKeys[$v];
            $validFirst[$key] /= $sumFirst;
        }

        $frequency['firstElements'] = $validFirst;

        // Compact

        for ($x = 0; $x < $keyCount; $x++)
        {
            /** @var \Phonyland\NGram\NGramElement $ngramElement */
            $ngramElement = $frequency['elements'][$keys[$x]];

            $frequency['elements'][$keys[$x]] = [
                $ngramElement->hasChildren ? $ngramElement->children : 0,
                $ngramElement->hasLastChildren ? $ngramElement->lastChildren : 0,
            ];
        }

        $frequency['e'] = $frequency['elements'];
        $frequency['fe'] = $frequency['firstElements'];

        unset(
            $frequency['elements'],
            $frequency['firstElements'],
        );

        return $frequency;
    }
}
