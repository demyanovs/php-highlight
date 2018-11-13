<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeHighlighter example</title>
    <link type="text/css" rel="stylesheet"  href="css/highlighter.css">
</head>
<body>

<?php

require_once '../CodeHighlighter/src/autoload.php';

use CodeHighlighter\HighlighterText;
use CodeHighlighter\HighlighterPHP;
use CodeHighlighter\HighlighterBash;

$text = '
<h2>PHP</h2>
<code data-lang="php" data-file-path="php-code-highlighter/examples/index.php">
private static function strPos()
{
    $mystring = "abc";
    $findme   = "a";
    $pos = strpos($mystring, $findme);
    
    // Note our use of ===.  Simply == would not work as expected
    // because the position of "a" was the 0th (first) character.
    if ($pos === false) {
        echo "<p>The string <b>"$findme"</b> was not found in the string $mystring</p>";
    } else {
        echo "The string "$findme" was found in the string $mystring";
        echo " and exists at position $pos";
    }
}
</code>

<h2>JavaScript</h2>
<code data-lang="js" data-file-path="example.js">
function myConcat(separator) {
   var result = \'\'; // initialize list
   var i;
   // iterate through arguments
   for (i = 1; i < arguments.length; i++) {
      result += arguments[i] + separator;
   }
   return result;
}
</code>

<h2>Bash</h2>
<code data-lang="bash" data-file-path="example.sh">
#!/bin/bash
directory="./BashScripting"

# bash check if directory exists
if [ -d $directory ]; then
	echo "Directory exists"
else 
	echo "Directory does not exists"
fi 
</code>
';

$highlighter = new HighlighterText($text);
HighlighterPHP::setKeywordColor('#a800a2; font-weight: bold');

echo $highlighter->parse();

?>
</body>
</html>
