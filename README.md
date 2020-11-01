<div align="center">

[![Phony Logo](https://raw.githubusercontent.com/phonyland/artwork/master/logo.png)](https://github.com/phonyland)

</div>

<div align="center">

# N-Gram Tools

</div>

This repository contains the N-Gram Tools for 🙃 Phony Language.

## 🚀 Installation

Requires `PHP` `>= 7.4` or `>= 8.0`.

You can install the package via composer:

```console
composer require phonyland/ngram
```

## 🙌 Usage

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

> If you want to start generating realistic fake data with Phony, visit the main **[Phony Repository](https://github.com/phonyland/phony)**.

- Explore the docs: **[phony.land »](https://phony.land/)**
- Follow us on Twitter: **[@phonyphp »](https://twitter.com/phonyphp)**

Phony was created by **[Yunus Emre Deligöz](https://twitter.com/yedeligoez)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
