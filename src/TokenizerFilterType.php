<?php

declare(strict_types=1);

namespace Phonyland\NGram;

enum TokenizerFilterType: string
{
    case NONE = '/\s+/';

    case FRENCH = '/[^a-zéèëêúüûùœàáäâæíïìîóöôòç]+/';

    case ENGLISH = '/[^a-zæœ]+/';

    case OLD_ENGLISH = '/[^a-zþðƿȝæœ]/';

    case ALPHABETICAL = '/[^a-z]+/';

    case NUMERICAL = '/[^0-9]+/';

    case ALPHANUMBERICAL = '/[^0-9a-z]+/';

    case LATIN_EXTENDED_ALPHABETICAL = '/[^a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß]+/';

    case LATIN_EXTENDED_ALPHANUMERICAL = '/[^0-9a-zéèëêęėēúüûùūçàáäâæãåāíïìîįīóöôòõœøōñńß]+/';

    case NO_SYMBOLS = "/[^ \p{L}]+/u";

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
    case JAPANESE = "/[^ \u{3040}-\u{3096}\u{30A0}-\u{30FF}\u{2E80}-\u{2FD5}\u{3400}-\u{4DBF}\u{4E00}-\u{9FFF}\u{F900}-\u{FAFF}]+/u";

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
    case CHINESE = "/[^ \u{2E80}-\u{2FD5}\u{3400}-\u{4DBF}\u{4E00}-\u{9FFF}\u{F900}-\u{FAFF}]+/";

    case WHITESPACE_SEPARATOR = '\s';
}
