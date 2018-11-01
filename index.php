<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeHighlighter example</title>
    <style>
        code {
            display: block;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
            font-family: "SFMono-Regular",Consolas,"Liberation Mono",Menlo,Courier,monospace;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: pre-wrap;
            tab-size: 4;
        }
    </style>
</head>
<body>

<?php

require_once 'CodeHighlighter/src/autoload.php';

use CodeHighlighter\HighlighterText;
use CodeHighlighter\HighlighterPHP;
use CodeHighlighter\HighlighterBash;

$text = '
<h2>Sample of php code highlighting</h2>
<code data-lang="php">
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

<h2>js</h2>
<code data-lang="js">
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

<h2>Sample of bash code highlighting</h2>
<code data-lang="bash">
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
