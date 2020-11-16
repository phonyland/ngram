<div align="center">

[![Phony Logo](https://raw.githubusercontent.com/phonyland/artwork/master/logo.png)](https://github.com/phonyland)

</div>

<div align="center">

# N-Gram Tools

</div>

This repository contains the N-Gram Tools for 🙃 Phony Language.

## 🚀 Installation

Requires PHP `>= 7.4` or `>= 8.0`.

You can install the package via composer:

```console
composer require phonyland/ngram
```

## ⌨️ Usage

### Tokenizer

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

$tokenizer = new Tokenizer();
$tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
$tokenizer->addRemovalRule(TokenizerFilter::NO_SYMBOLS);
$tokenizer->addRemovalRule('/m/');

$text = 'sample# text%';

$tokenizer->tokenize($text);
// ['saple', 'text']
```

### N-Gram

#### N-Gram Sequence

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramSequence;

$tokenizer = new Tokenizer();
$tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
$tokens = $tokenizer->tokenize('sample text');

NGramSequence::unigram($tokens);
// ['s', 'a', 'm', 'p', 'l', 'e', 't', 'e', 'x', 't'];

NGramSequence::bigram($tokens);
// ['sa', 'am', 'mp', 'pl', 'le', 'te', 'ex', 'xt'];

NGramSequence::trigram($tokens);
// ['sam', 'amp', 'mpl', 'ple', 'tex', 'ext'];

NGramSequence::multigram(4, $tokens);
// ['samp', 'ampl', 'mple', 'text'];

// Generate Unique N-Grams 
NGramSequence::unigram($tokens, true);
// ['s', 'a', 'm', 'p', 'l', 'e', 't', 'x'];
```

#### N-Gram Sequences with Count

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramCount;

$tokenizer = new Tokenizer();
$tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
$tokens = $tokenizer->tokenize('sample text');

NGramCount::unigram($tokens);
// [
//     's' => 1,
//     'a' => 1,
//     'm' => 1,
//     'p' => 1,
//     'l' => 1,
//     'e' => 2,
//     't' => 2,
//     'x' => 1,
// ];

NGramCount::bigram($tokens);
//  [
//      'sa' => 1,
//      'am' => 1,
//      'mp' => 1,
//      'pl' => 1,
//      'le' => 1,
//      'te' => 1,
//      'ex' => 1,
//      'xt' => 1,
//  ];

NGramCount::trigram($tokens);
//  [
//      'sam' => 1,
//      'amp' => 1,
//      'mpl' => 1,
//      'ple' => 1,
//      'tex' => 1,
//      'ext' => 1,
//  ];

NGramCount::multigram(4, $tokens);
// [
//     'samp' => 1,
//     'ampl' => 1,
//     'mple' => 1,
//     'text' => 1,
// ];
```

#### N-Gram Frequency

```php
$tokenizer = new Tokenizer();
$tokenizer->setSeparator(TokenizerFilter::ALPHABETICAL);
$tokens = $tokenizer->tokenize('bombadil! bombadillo!');

NGramFrequency::unigram($tokens);
//[
//    'b' => 0.2222222222222222,
//    'o' => 0.16666666666666666,
//    'm' => 0.1111111111111111,
//    'a' => 0.1111111111111111,
//    'd' => 0.1111111111111111,
//    'i' => 0.1111111111111111,
//    'l' => 0.16666666666666666,
//]

NGramFrequency::bigram($tokens);
//[
//    'bo' => 0.125,
//    'om' => 0.125,
//    'mb' => 0.125,
//    'ba' => 0.125,
//    'ad' => 0.125,
//    'di' => 0.125,
//    'il' => 0.125,
//    'll' => 0.0625,
//    'lo' => 0.0625,
//]

NGramFrequency::trigram($tokens);
//[
//    'bom' => 0.14285714285714285,
//    'omb' => 0.14285714285714285,
//    'mba' => 0.14285714285714285,
//    'bad' => 0.14285714285714285,
//    'adi' => 0.14285714285714285,
//    'dil' => 0.14285714285714285,
//    'ill' => 0.07142857142857142,
//    'llo' => 0.07142857142857142,
//]

NGramFrequency::multigram(4, $tokens);
//[
//    'bomb' => 0.16666666666666666,
//    'omba' => 0.16666666666666666,
//    'mbad' => 0.16666666666666666,
//    'badi' => 0.16666666666666666,
//    'adil' => 0.16666666666666666,
//    'dill' => 0.08333333333333333,
//    'illo' => 0.08333333333333333,
//]
```

---

If you want to start generating realistic fake data with 🙃 Phony, visit the main **[Phony Repository](https://github.com/phonyland/phony)**.

- Explore the docs: **[phony.land »](https://phony.land/)**
- Follow us on Twitter: **[@phonyphp »](https://twitter.com/phonyphp)**

Phonyland was created by **[Yunus Emre Deligöz](https://twitter.com/yedeligoez)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
