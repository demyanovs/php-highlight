# CodeHighlighter

CodeHighlighter is a small PHP library for highlighting syntax that can be easily configured or extended.

## Language syntax support
* PHP
* JavaScript
* XML
* HTML
* Bash

## How it works
The library parses the text, finds the tag \<code>, read the attribute data-lang, and for this reason decides how to highlight the syntax of this block. 
Supports style customization.

## Installation
```php
// require the CodeHighlighter autoloader
require_once '/path/to/CodeHighlighter/src/autoload.php';
```

## Basic Usage
See examples here [index.php](../master/examples/index.php)
```php
<?php

require_once '/path/to/CodeHighlighter/src/autoload.php';
require_once '../CodeHighlighter/src/CodeHighlighter/Themes/Theme.php';

use CodeHighlighter\Highlighter;

$highlighter = new Highlighter($text, 'drakula');
// Configuration
//Highlighter::$showLineNumbers = true;
//Highlighter::$showActionsPanel = true;
//The theme colors are overwritten here (if necessary)
//Theme::getTheme()::setBackgroundColor('#ccc');
echo $highlighter->parse();
```

## Themes
Default - light theme
Drakula - dark theme

## Overwritten theme colors
Library has its own themes, but all theme colors can be overwritten like this:
```php
// Default
Theme::getTheme()::setDefaultColor('#000;');
Theme::getTheme()::setBackgroundColor('#f8f8f8');
Theme::getTheme()::setCommentColor('#7f7f7f;');
Theme::getTheme()::setKeywordColor('#cb7832;');
Theme::getTheme()::setVariableColor('#cb7832');
Theme::getTheme()::setStringColor('#000;');
Theme::getTheme()::setHtmlColor('#fbc201;');
Theme::getTheme()::setFlagColor('#cb7832;');

// XML
Theme::getTheme()::setXMLTagColor('#008000;');
Theme::getTheme()::setXMLAttrNameColor('#7D9029;');
Theme::getTheme()::setXMLAttrValueColor('#BA2121;');
Theme::getTheme()::setXMLInfoColor('#BC7A00;');

// PHP
Theme::getTheme()::setPHPDefaultColor('#0000BB;');
Theme::getTheme()::setPHPCommentColor('#FF8000;');
Theme::getTheme()::setPHPHtmlColor('#fbc201;');
Theme::getTheme()::setPHPKeywordColor('#007700;');
Theme::getTheme()::setPHPStringColor('#DD0000;');
```

## Configuration
```php
// Show line numbers
Highlighter::$showLineNumbers = true;
// Show action panel (copy button)
Highlighter::$showActionsPanel = true;
```

## Features
- [x] set filename
- [x] line numbers
- [x] dark/light themes
- [ ] copy button
