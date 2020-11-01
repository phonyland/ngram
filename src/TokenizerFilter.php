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

    public const NONE = '/\s+/';
    public const FRENCH = '/[^a-zéèëêúüûùœàáäâæíïìîóöôòç]+/';
    public const ENGLISH = '/[^a-zæœ]+/';
    public const OLD_ENGLISH = '/[^a-zþðƿȝæœ]/';
    public const ALPHABETICAL = '/[^a-z]+/';
    public const NUMERICAL = '/[^0-9]+/';
    public const ALPHANUMBERICAL = '/[^0-9a-z]+/';
    public const LATIN_EXTENDED_ALPHABETICAL = '/[^a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß]+/';
    public const LATIN_EXTENDED_ALPHANUMERICAL = '/[^0-9a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß]+/';
    /**
     * Symbols and punctuation filter
     *
     * U+0000 > U+002F & U+003A > U+0040 & U+005B > U+0060 & U+007B > U+007F : Handpicked symbols and punctuation from Basic Latin
     * U+0080 > U+00BF & U+00F7 : Handpicked symbols and punctuation from Latin-1 Supplement
     * U+02B0 > U+02FF : Spacing Modifier Letters
     * U+2000 > U+27FF & U+2900 > U+2BFF : A whole set of symbols and punctuation (excluding the Braille Patterns block)
     * U+2E00 > U+2E7F : Supplemental Punctuation
     * U+3000 > U+303F : CJK Symbols and Punctuation
     * U+FE30 > U+FE4F : CJK Compatibility Forms
     */
    public const NO_SYMBOLS = "/[^ \p{L}]+/u";
    /**
     * Japanese characters (actually includes all the chinese characters instead of only the jōyō kanji)
     *
     * U+2E80 > U+2F00 : CJK Radicals Supplement
     * U+2F00 > U+2FD5 : Kangxi Radicals
     * U+3040 > U+3096 : Hiragana
     * U+30A0 > U+30FF : Katakana
     * u+3400 > U+4DBF : CJK Unified Ideographs Extension A
     * U+4E00 > U+9FFF : CJK Unified Ideographs
     * U+F900 > U+FAFF : CJK Compatibility Ideographs
     */
    public const JAPANESE = "/[^ \u{3040}-\u{3096}\u{30A0}-\u{30FF}\u{2E80}-\u{2FD5}\u{3400}-\u{4DBF}\u{4E00}-\u{9FFF}\u{F900}-\u{FAFF}]+/u";
    /**
     * Chinese characters
     *
     * U+2E80 > U+2F00 : CJK Radicals Supplement
     * U+2F00 > U+2FD5 : Kangxi Radicals
     * u+3400 > U+4DBF : CJK Unified Ideographs Extension A
     * U+4E00 > U+9FFF : CJK Unified Ideographs
     * U+F900 > U+FAFF : CJK Compatibility Ideographs
     */
    public const CHINESE = "/[^ \u{2E80}-\u{2FD5}\u{3400}-\u{4DBF}\u{4E00}-\u{9FFF}\u{F900}-\u{FAFF}]+/";

    public function __construct(string $pattern, string $replacement)
    {
        $this->pattern     = $pattern;
        $this->replacement = $replacement;
    }
}
