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

#### Simple N-Gram Generation

```php
use Phonyland\NGram\Tokenizer;

$tokenizer = new Tokenizer();
$tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
$tokens = $tokenizer->tokenize('sample text');

NGram::trigram($tokens);
['sam', 'amp', 'mpl', 'ple', 'tex', 'ext'];

NGram::bigram($tokens);
['sa', 'am', 'mp', 'pl', 'le', 'te', 'ex', 'xt'];

NGram::unigram($tokens);
['s', 'a', 'm', 'p', 'l', 'e', 't', 'e', 'x', 't'];

NGram::multigram(4, $tokens);
['samp', 'ampl', 'mple', 'text'];

// Generate Unique N-Grams 
NGram::unigram($tokens, true);
['s', 'a', 'm', 'p', 'l', 'e', 't', 'x'];
```

#### N-Gram Generation with Count

```php
use Phonyland\NGram\Tokenizer;

$tokenizer = new Tokenizer();
$tokenizer->setSeparator(Tokenizer::WHITESPACE_SEPARATOR);
$tokens = $tokenizer->tokenize('sample text');

NGram::trigramCount($tokens);
[
    'sam' => 1,
    'amp' => 1,
    'mpl' => 1,
    'ple' => 1,
    'tex' => 1,
    'ext' => 1,
];

NGram::bigramCount($tokens);
[
    'sa' => 1,
    'am' => 1,
    'mp' => 1,
    'pl' => 1,
    'le' => 1,
    'te' => 1,
    'ex' => 1,
    'xt' => 1,
];

NGram::unigramCount($tokens);
[
    's' => 1,
    'a' => 1,
    'm' => 1,
    'p' => 1,
    'l' => 1,
    'e' => 2,
    't' => 2,
    'x' => 1,
];

NGram::multigramCount(4, $tokens);
[
    'samp' => 1,
    'ampl' => 1,
    'mple' => 1,
    'text' => 1,
];
```

---

If you want to start generating realistic fake data with 🙃 Phony, visit the main **[Phony Repository](https://github.com/phonyland/phony)**.

- Explore the docs: **[phony.land »](https://phony.land/)**
- Follow us on Twitter: **[@phonyphp »](https://twitter.com/phonyphp)**

Phonyland was created by **[Yunus Emre Deligöz](https://twitter.com/yedeligoez)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
