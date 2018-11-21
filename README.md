# CodeHighlighter

CodeHighlighter is a small PHP library for highlighting syntax that can be easily configured or extended.

# Language syntax support
* PHP
* JavaScript
* Bash

## How it works
The library parses the text, finds the tag \<code>, read the attribute data-lang, and for this reason decides how to highlight the syntax of this block.
By default uses php function highlight_string() for php code or for the unknown code, but can be easily extended or replaced at will. Supports style customization;

## Installation
```php
// require the CodeHighlighter autoloader
require_once '/path/to/CodeHighlighter/src/autoload.php';
```

## Basic Usage

```php
<?php

require_once '/path/to/CodeHighlighter/src/autoload.php';

use CodeHighlighter\Highlighter;

$highlighter = new Highlighter($text);
echo $highlighter->parse();

```

## Customization
For each block can be set its own text color, background color, font weight and more.
```php
ClassName::setDefaultColor('#ccc');
ClassName::setBackgroundColor('#ccc');
ClassName::setCommentColor('#ccc');
ClassName::setKeywordColor('#ccc; font-weight: bold');
ClassName::setVariableColor('#ccc');
ClassName::setStringColor('#ccc');
ClassName::setHtmlColor('#ccc');
```
Where ClassName - name of available class, currently available: 
* HighlighterPHP, 
* HighlighterBash

## Example
See [index.php](../master/examples/index.php)
```php
<?php

use CodeHighlighter\Highlighter;
use CodeHighlighter\HighlighterPHP;
use CodeHighlighter\HighlighterBash;

$highlighter = new Highlighter($text);
HighlighterPHP::setCommentColor('#a800a2; font-weight: bold');
HighlighterBash::setCommentColor('#e519f7;');

echo $highlighter->parse();
```

## Extend
You can wrote your own extended HighlighterAbstract or just use HighlighterPHP by default.

## Features
- [x] set filename
- [x] line numbers
- [ ] copy button
- [ ] dark/light themes
