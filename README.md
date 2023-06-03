# PHPHighlight

PHPHighlight is a PHP syntax highlighting library that can be easily customized and extended.

## How it works
The library parses the text, finds the \<pre> tag, reads the attributes (data-lang, data-file, data-theme) and highlights the syntax of the code block.

Supports style customization. Here are examples of styling:

<img width="757" height="309" src="https://demyanov.dev/sites/default/files/images/phphighlight2.png" alt="styling example">

## Requirements
PHP 8.1+

## Installation
You can install package via composer
```bash
$ composer require demyanovs/php-highlight
```

## Usage
See full example here [index.php](../master/examples/index.php)
```php
<?php

require_once 'vendor/autoload.php';

use Demyanovs\PHPHighlight\Highlighter;

$text = '
<pre data-file="php-highlight/examples/index.php" data-lang="php">
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
</pre>
';

$highlighter = new Highlighter($text, ObsidianTheme::TITLE);
// Configuration
$highlighter->showLineNumbers(true);
$highlighter->showActionPanel(true);
echo $highlighter->parse();
```

### Customization
```php
$highlighter->showLineNumbers(true);
$highlighter->showActionPanel(true);
```

You can set following attributes in \<pre> tag
\<pre data-lang="php" data-file="example.php" data-theme="drakuala">
* lang - a language of the text. This affects how the parser will highlight the syntax.
* file - show file name in action panel.
* theme - allows to overwrite the global theme.

### How to create a custom theme
To create a custom theme you need to create an instance of Demyanovs\PHPHighlight\Themes\Theme class
and pass it to Highlighter as a third argument:
```php
$defaultColorSchemaDto = new DefaultColorSchemaDto(...);
$PHPColorSchemaDto = new PHPColorSchemaDto(...);
$XMLColorSchemaDto = new XMLColorSchemaDto(...);

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

## License
[MIT](./LICENSE.md)
