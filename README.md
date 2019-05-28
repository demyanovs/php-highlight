# PHPHighlight

PHPHighlight is a PHP library for highlighting syntax that can be easily configured and extended.

## Language syntax support
* PHP
* JavaScript
* XML
* HTML
* Bash

## How it works
The library parses the text, finds the tag \<pre>, read attributes (data-lang, data-file, data-theme), and for this reason decides how to highlight the syntax of this block. 
Supports style customization.

## Installation
`$ composer require demyanovs/php-highlight`

## Basic Usage
See examples here [index.php](../master/examples/index.php)
```php
<?php

require_once '../vendor/autoload.php';

use Demyanovs\PHPHighlight\Highlighter;

$highlighter = new Highlighter($text, 'railscasts');
// Configuration
$highlighter->setShowLineNumbers(false);
$highlighter->setShowActionPanel(true);
echo $highlighter->parse();
```

## Themes
* default - light theme
* Drakula - dark theme
* Railscasts - dark theme

## Configuration
```php
// Show line numbers
$highlighter->setShowLineNumbers(true);
// Show action panel (copy button)
$highlighter->setShowActionPanel(true);
```

You can set following attributes in \<pre> tag
\<pre data-lang="php" data-file="example.php" data-theme="drakuala">
* lang - a language of the text. This affects how the parser will highlight the syntax.
* file - show file name in action panel.
* theme - allows to overwrite the global theme.

## Features
- [x] line numbers
- [x] dark/light themes
- [x] set filename
- [x] copy button
- [x] overwrite theme in code block
- [ ] overwrite line numbers and action panel settings in code block
- [ ] action panel: open code in a new window
- [ ] action panel: about
