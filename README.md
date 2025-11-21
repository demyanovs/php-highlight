# PHPHighlight

PHPHighlight is a PHP syntax highlighting library that can be easily customized and extended.

## How it works
The library parses the text, finds the `<pre>` and `<pre><code>` tags, reads the attributes (data-lang, data-file, data-theme) and highlights the syntax of the code block.

**Recommended:** Use `<pre><code>` pattern for better semantics and compatibility with Markdown output.

Supports style customization. Here are examples of styling:

<img width="757" height="309" src="examples/img/scr_01.png" alt="styling example">

## Requirements
PHP 8.1+

## Installation
You can install package via composer
```bash
$ composer require demyanovs/php-highlight
```

## Usage
See full example in [examples/index.php](examples/index.php)
```php
<?php

require_once 'vendor/autoload.php';

use Demyanovs\PHPHighlight\Highlighter;
use Demyanovs\PHPHighlight\Themes\ObsidianTheme;

$text = '
<pre><code class="language-php" data-file="php-highlight/examples/index.php">
&lt;?php
abstract class AbstractClass
{
    /**
     * Our abstract method only needs to define the required arguments
     */
    abstract protected function prefixName(string $name): string;
}

class ConcreteClass extends AbstractClass
{
    /**
     * Our child class may define optional arguments not in the parent\'s signature
     */
    public function prefixName(string $name): string
    {
        $prefix = "";
        if ($name === "Pacman") {
            $prefix = "Mr.";
        } elseif ($name === "Pacwoman") {
            $prefix = "Mrs.";
        } else {
            
        }
        
        return $prefix . " " . $name;
    }
}

$class = new ConcreteClass;
echo $class->prefixName("Pacman"), "\n";
echo $class->prefixName("Pacwoman"), "\n";
</code></pre>
';

$highlighter = (new Highlighter($text, ObsidianTheme::TITLE))
        ->showLineNumbers(true)
        ->showActionPanel(true);
echo $highlighter->parse();
```

### Customization
```php
$highlighter->showLineNumbers(true);
$highlighter->showActionPanel(true);
```

You can set following attributes in `<pre>` or `<code>` tags:
```html
<pre><code class="language-php" data-file="example.php" data-theme="darkula">
// or
<pre data-lang="php" data-file="example.php" data-theme="darkula"><code>
```

* `data-lang` or `class="language-*"` - a language of the text. This affects how the parser will highlight the syntax.
* `data-file` - show file name in action panel.
* `data-theme` - allows to overwrite the global theme.

**Note:** `class="language-*"` on `<code>` tag is automatically recognized (common in Markdown output).

### How to create a custom theme
To create a custom theme you need to create an instance of `Demyanovs\PHPHighlight\Themes\Theme` class
and pass it to Highlighter as a third argument:
```php
use Demyanovs\PHPHighlight\Highlighter;
use Demyanovs\PHPHighlight\Themes\Theme;
use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

$defaultColorSchemaDto = new DefaultColorSchemaDto(
    '#000000', // background
    '#ffffff', // default text
    '#888888', // comment
    '#ff0000', // keyword
    '#00ff00', // string
    '#0000ff', // number
    '#ffff00'  // variable
);

$PHPColorSchemaDto = new PHPColorSchemaDto(
    '#0000BB', // keyword
    '#FF8000', // variable
    '#fbc201', // function
    '#007700', // string
    '#DD0000'  // comment
);

$XMLColorSchemaDto = new XMLColorSchemaDto(
    '#008000', // tag
    '#7D9029', // attribute
    '#BA2121', // string
    '#BC7A00'  // comment
);

$myTheme = new Theme(
    'myThemeTitle',
    $defaultColorSchemaDto,
    $PHPColorSchemaDto,
    $XMLColorSchemaDto
);

$highlighter = new Highlighter($text, 'myThemeTitle', [$myTheme]);
```

### Supports language syntax
* PHP
* JavaScript
* XML/HTML
* Bash
* Go
* and others

### Themes
* default
* darkula
* railscasts
* obsidian
* far
* vs2015
* c64

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Changelog
See [CHANGELOG.md](./CHANGELOG.md) for a list of changes and version history.

## License
[MIT](./LICENSE.md)
