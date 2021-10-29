<div align="center">

[![Phony Logo](https://raw.githubusercontent.com/phonyland/artwork/master/logo.png)](https://github.com/phonyland)

</div>

<div align="center">

# 🧪<br>N-Gram Tools

This repository contains the N-Gram Tools for 🙃 Phony Language that includes features like sanitizing, tokenization, n-gram extraction, frequency mapping.

</div>

## 🚀 Installation

Requires PHP `>= 8.0`.

You can install the package via composer:

```sh
composer require phonyland/ngram
```

## ⌨️ Usage

### Tokenizer

### Word Tokenization
 
```php
$tokenizer->tokenize($text);
```

<details>
  <summary>⌨️ Usage</summary>

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

$tokenizer = new Tokenizer();
$tokenizer
  ->addWordSeparatorPattern(';')
  ->addWordSeparatorPattern('\s')
  ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS);

$text = 'sample   text;sample;text';

$tokenizer->tokenize($text);
```

</details>

<details>
    <summary>🖥 Output</summary>

```php
[
    "sample",
    "text",
    "sample",
    "text",
];
```

</details>

### Sentence Tokenization

```php
$tokenizer->sentences($text);
```

<details>
  <summary>⌨️ Usage</summary>

```php
use Phonyland\NGram\Tokenizer;

$tokenizer = new Tokenizer();
$tokenizer
  ->addSentenceSeparatorPattern('.')
  ->addSentenceSeparatorPattern('!')
  ->addSentenceSeparatorPattern('?');

$text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';

$tokenizer->sentences($text);
```

</details>

<details>
    <summary>🖥 Output</summary>

```php
[
    "Sample Sentence.",
    "Sample Sentence!",
    "Sample Sentence?",
    "Sample Sentence no.",
    "4?!",
    "Sample sample sentence...",
    "End",
];
```

</details>

### Word Tokenization by Sentences

```php
$tokenizer->tokenizeBySentences($text);
```

<details>
  <summary>⌨️ Usage</summary>

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\TokenizerFilter;

$tokenizer = new Tokenizer();
$tokenizer
  ->addSentenceSeparatorPattern('.')
  ->addSentenceSeparatorPattern('!')
  ->addSentenceSeparatorPattern('?')
  ->addWordFilterRule(TokenizerFilter::NO_SYMBOLS)
  ->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);

$text = 'Sample Sentence. Sample Sentence! Sample Sentence? Sample Sentence no. 4?! Sample sample sentence... End';

$tokenizer->tokenizeBySentences($text);
```

</details>

<details>
    <summary>🖥 Output</summary>

```php
[
    ["Sample", "Sentence"],
    ["Sample", "Sentence"],
    ["Sample", "Sentence"],
    ["Sample", "Sentence", "no"],
    ["Sample", "sample", "sentence"],
    ["End"],
];
```

</details>

### N-Gram

#### N-Gram Sequence

```php
NGramSequence::multigram($n, $tokens, $isUnique);
NGramSequence::trigram($tokens, $isUnique);
NGramSequence::bigram($tokens, $isUnique);
NGramSequence::unigram($tokens, $isUnique);
```

<details>
    <summary>⌨️ Usage</summary>

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramSequence;
use Phonyland\NGram\TokenizerFilter;

$tokenizer = new Tokenizer();
$tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
$tokens = $tokenizer->tokenize('sample text');

NGramSequence::multigram(4, $tokens);
// ['samp', 'ampl', 'mple', 'text'];

// Generate Unique N-Grams 
NGramSequence::unigram($tokens, true);
// ['s', 'a', 'm', 'p', 'l', 'e', 't', 'x'];
```

</details>

#### N-Gram Sequences with Count

```php
NGramCount::multigram(4, $tokens);
NGramCount::trigram($tokens);
NGramCount::bigram($tokens);
NGramCount::unigram($tokens);

NGramCount::elementOnArray($element, $elements);
```

<details>
    <summary>⌨️ Usage</summary>

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramCount;

$tokenizer = new Tokenizer();
$tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
$tokens = $tokenizer->tokenize('sample text');

NGramCount::multigram(4, $tokens);
// [
//     'samp' => 1,
//     'ampl' => 1,
//     'mple' => 1,
//     'text' => 1,
// ];
```

</details>

#### N-Gram Frequency

```php
NGramFrequency::multigram(4, $tokens);
NGramFrequency::multigram($tokens);
NGramFrequency::bigram($tokens);
NGramFrequency::unigram($tokens);

NGramFrequency::frequencyFromCount($countArray);
```

<details>
    <summary>⌨️ Usage</summary>

```php
use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramFrequency;
use Phonyland\NGram\TokenizerFilter;

$tokenizer = new Tokenizer();
$tokenizer->addWordSeparatorPattern(TokenizerFilter::WHITESPACE_SEPARATOR);
$tokenizer->addWordFilterRule(TokenizerFilter::ALPHABETICAL);
$tokens = $tokenizer->tokenize('bombadil! bombadillo!');

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

</details>


<div align="center">

# 🙃

Start generating data with 🙃 Phony Framework,  
visit the main **[Phony Repository](https://github.com/phonyland/phony)**.

Explore the docs: **[phony.land »](https://phony.land/)**  
Follow us on Twitter: **[@phony_land »](https://twitter.com/phony_land)**

**[🙃 Phony Data Generation Framework](https://phony.land)**  
was created by  
**[Yunus Emre Deligöz](https://twitter.com/yedeligoez)**  
under  
**[MIT license](https://opensource.org/licenses/MIT)**.

</div>
