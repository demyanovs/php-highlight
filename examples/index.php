<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeHighlighter example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet"  href="css/highlighter.css">
    <script type="text/javascript" src="js/code_highlighter.js"></script>
</head>
<body>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../CodeHighlighter/src/autoload.php';
require_once '../CodeHighlighter/src/CodeHighlighter/Themes/Theme.php';

use CodeHighlighter\Highlighter;
use CodeHighlighter\Theme\Theme;

$text = '
<h2>PHP</h2>
<code data-lang="php" data-file-path="php-code-highlighter/examples/index.php">
abstract class AbstractClass
{
    // Our abstract method only needs to define the required arguments
    abstract protected function prefixName($name);

}

class ConcreteClass extends AbstractClass
{

    // Our child class may define optional arguments not in the parent\'s signature
    public function prefixName($name, $separator = ".") {
        if ($name == "Pacman") {
            $prefix = "Mr";
        } elseif ($name == "Pacwoman") {
            $prefix = "Mrs";
        } else {
            $prefix = "";
        }
        return "{$prefix}{$separator} {$name}";
    }
}

$class = new ConcreteClass;
echo $class->prefixName("Pacman"), "\n";
echo $class->prefixName("Pacwoman"), "\n";
</code>

<h2>JavaScript</h2>
<code data-lang="js" data-file-path="example.js">
var searchHelp = {
    showImages: true,
    showDesc: true,
    minChars: 3,
    cmd: \'show_search_help\',
    keysDownBlock: [13, 37, 38, 39, 40],

    showSearchHelp: function (obj) {
        var self = this,
            searchText = $(obj).val(),
            searchName = $(obj).attr(\'name\'),
            autocompleteContainerId = \'#\' + $(obj).data(\'container-id\');

        if ( $.inArray($(obj).which, this.keysDownBlock) === -1 ) {
            if (searchText.length < self.minChars) {
                return;
            }
            else {
                // Hide help
                $(autocompleteContainerId + \' ul\').css(\'display\', \'none\');
            }
        }
    }
};
</code>

<h2>Bash</h2>
<code data-lang="bash" data-file-path="example.sh">
#!/bin/bash
read -p "Enter number : " n
if test $n -ge 0
then
	echo "$n is positive number."
else
	echo "$n number is negative number."
fi
</code>


<h2>Xml</h2>
<code data-lang="xml">
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE recipe>
<recipe name="bread" preptime="5min" cooktime="180min">
   <title>
      Simple bread
   </title>
   <composition>
      <ingredient amount="3" unit="стакан">Мука</ingredient>
      <ingredient amount="0.25" unit="грамм">Дрожжи</ingredient>
      <ingredient amount="1.5" unit="стакан">Тёплая вода</ingredient>
   </composition>
   <instructions>
     <step>
        Mix all ingredients and knead thoroughly.
     </step>
     <step>
        Cover with a cloth and leave for one hour in a warm room.
     </step>
     <step>
        Knead again, put on a baking sheet and put in the oven.
     </step>
   </instructions>
</recipe>
</code>

<h2>HTML</h2>
<code data-lang="html">
<!DOCTYPE html>
<title>Title</title>

<style>body {width: 500px;}</style>

<script type="application/javascript">
  function $init() {return true;}
</script>

<body>
  <p checked class="title" id=\'title\'>Title</p>
  <!-- here goes the rest of the page -->
  <div class="actions">
    Mix all ingredients and knead thoroughly
  </div>
</body>
</code>
';

$highlighter = new Highlighter($text, 'drakula');
// Configuration
//Highlighter::$showLineNumbers = true;
//Highlighter::$showActionsPanel = true;
//Theme settings are overwritten here
//Theme::getTheme()::setBackgroundColor('#ccc');
echo $highlighter->parse();

?>
</body>
</html>
