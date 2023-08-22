<?php

declare(strict_types=1);

namespace Phonyland\NGram;

class TokenizerFilter
{
    public function __construct(
        public string|TokenizerFilterType $pattern,
        public string $replacement,
    ) {
        $this->pattern = $this->pattern instanceof TokenizerFilterType
            ? $this->pattern->value
            : $this->pattern;
    }

    /**
     * @return array{pattern: string, replacement: string}
     */
    public function toArray(): array
    {
        return [
            'pattern' => $this->pattern,
            'replacement' => $this->replacement,
        ];
    }
}
