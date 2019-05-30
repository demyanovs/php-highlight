<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHPHighlight example</title>
    <link type="text/css" rel="stylesheet"  href="css/highlighter.css">
    <script type="text/javascript" src="js/highlighter.js"></script>
</head>
<body>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$text = '
<h2>PHP</h2>
<pre data-file="php-highlight/examples/index.php" data-lang="php">
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
</pre>

<h2>JavaScript</h2>
<pre data-file-path="example.js" data-lang="js">
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
</pre>

<h2>Bash</h2>
<pre data-file-path="example.sh" data-lang="bash">
#!/bin/bash
read -p "Enter number : " n
if test $n -ge 0
then
	echo "$n is positive number."
else
	echo "$n number is negative number."
fi
</pre>


<h2>Xml</h2>
<pre data-lang="xml">
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE recipe>
<recipe name="bread" preptime="5min" cooktime="180min">
   <title>
      Simple bread
   </title>
   <composition>
      <ingredient amount="3" unit="glass">Flour</ingredient>
      <ingredient amount="0.25" unit="gram">Yeast</ingredient>
      <ingredient amount="1.5" unit="glass">Warm water</ingredient>
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
</pre>

<h2>HTML</h2>
<pre data-lang="html">
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
</pre>
';

require_once '../vendor/autoload.php';

use Demyanovs\PHPHighlight\Highlighter;

$highlighter = new Highlighter($text, 'railscasts');
// Configuration
$highlighter->setShowLineNumbers(true);
$highlighter->setShowActionPanel(true);
echo $highlighter->parse();

?>
</body>
</html>
