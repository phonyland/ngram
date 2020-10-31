<?php

declare(strict_types=1);

namespace Phonyland\NGram;

/**
 * @internal
 */
final class TokenizerFilter
{
    public string $pattern;
    public string $replacement;

    public function __construct(string $pattern, string $replacement)
    {
        $this->pattern     = $pattern;
        $this->replacement = $replacement;
    }
}
