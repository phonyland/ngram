<?php

declare(strict_types=1);

namespace Phonyland\NGram;

/***
 * @internal
 *
 * @package Phonyland\NGram
 */
final class NGramElement
{
    /** @phpstan-var array<string, float> $children */
    public array $children           = [];

    /** @phpstan-var array<string, float> $lastChildren */
    public array $lastChildren       = [];

    public bool $hasChildren;

    public bool $hasLastChildren;
}
