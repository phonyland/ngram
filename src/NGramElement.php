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
    public int   $probabilityAsFirst = 0;
    public array $children           = [];
    public array $lastChildren       = [];

    public bool $hasChildren;
    public bool $hasLastChildren;
}
