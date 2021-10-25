<?php

declare(strict_types=1);

namespace Phonyland\NGram;

final class TokenizerFilter
{
    /**
     * @var string
     */
    public const NONE                          = '/\s+/';
    /**
     * @var string
     */
    public const FRENCH                        = '/[^a-zéèëêúüûùœàáäâæíïìîóöôòç]+/';
    /**
     * @var string
     */
    public const ENGLISH                       = '/[^a-zæœ]+/';
    /**
     * @var string
     */
    public const OLD_ENGLISH                   = '/[^a-zþðƿȝæœ]/';
    /**
     * @var string
     */
    public const ALPHABETICAL                  = '/[^a-z]+/';
    /**
     * @var string
     */
    public const NUMERICAL                     = '/[^0-9]+/';
    /**
     * @var string
     */
    public const ALPHANUMBERICAL               = '/[^0-9a-z]+/';
    /**
     * @var string
     */
    public const LATIN_EXTENDED_ALPHABETICAL   = '/[^a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß]+/';
    /**
     * @var string
     */
    public const LATIN_EXTENDED_ALPHANUMERICAL = '/[^0-9a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß]+/';
    /**
     * @var string
     */
    public const NO_SYMBOLS                    = "/[^ \p{L}]+/u";
    /**
     * Japanese characters (actually includes all the chinese characters instead of only the jōyō kanji).
     *
     * U+2E80 > U+2F00 : CJK Radicals Supplement
     * U+2F00 > U+2FD5 : Kangxi Radicals
     * U+3040 > U+3096 : Hiragana
     * U+30A0 > U+30FF : Katakana
     * u+3400 > U+4DBF : CJK Unified Ideographs Extension A
     * U+4E00 > U+9FFF : CJK Unified Ideographs
     * U+F900 > U+FAFF : CJK Compatibility Ideographs
     *
     * @var string
     */
    public const JAPANESE = "/[^ \u{3040}-\u{3096}\u{30A0}-\u{30FF}\u{2E80}-\u{2FD5}\u{3400}-\u{4DBF}\u{4E00}-\u{9FFF}\u{F900}-\u{FAFF}]+/u";
    /**
     * Chinese characters.
     *
     * U+2E80 > U+2F00 : CJK Radicals Supplement
     * U+2F00 > U+2FD5 : Kangxi Radicals
     * u+3400 > U+4DBF : CJK Unified Ideographs Extension A
     * U+4E00 > U+9FFF : CJK Unified Ideographs
     * U+F900 > U+FAFF : CJK Compatibility Ideographs
     *
     * @var string
     */
    public const CHINESE = "/[^ \u{2E80}-\u{2FD5}\u{3400}-\u{4DBF}\u{4E00}-\u{9FFF}\u{F900}-\u{FAFF}]+/";

    /**
     * @var string
     */
    public const WHITESPACE_SEPARATOR = '\s';

    public function __construct(
        public string $pattern,
        public string $replacement,
    ) {
    }
}
