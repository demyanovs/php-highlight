<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHPHighlight example</title>
    <link type="text/css" rel="stylesheet"  href="css/highlighter.css">
</head>
<body>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$text = '
<h2>PHP</h2>
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

<h2>JavaScript</h2>
<pre><code class="language-javascript" data-file="example.js">
// Arrow functions let us omit the `function` keyword. Here `long_example`
// points to an anonymous function value.
const long_example = (input1, input2) => {
    console.log("Hello, World!");
    const output = input1 + input2;

    return output;
};

const short_example = input => input + 5;

long_example(2, 3); // Prints "Hello, World!" and returns 5.
short_example(2);   // Returns 7.
</code></pre>

<h2>Bash</h2>
<pre><code class="language-bash" data-file="example.sh">
#!/bin/bash
read -p "Enter number : " n
if test $n -ge 0
then
	echo "$n is positive number."
else
	echo "$n number is negative number."
fi
</code></pre>

<h2>Go</h2>
<pre><code class="language-go" data-file="main.go">
package main

import "fmt"

func f(from string) {
    for i := 0; i < 3; i++ {
        fmt.Println(from, ":", i)
    }
}

func main() {

    f("direct")

    go f("goroutine")

    go func(msg string) {
        fmt.Println(msg)
    }("going")

    fmt.Scanln()
    fmt.Println("done")
}
</code></pre>
<h2>Xml</h2>
<pre><code class="language-xml" data-file="recipe.xml">
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
</code></pre>

<h2>HTML</h2>
<pre><code class="language-html" data-file="index.html">
<!DOCTYPE html>
<title>Title</title>

<style>body {width: 500px;}</style>

<script type="application/javascript">
  function $init() {return true;}
</script>

<body>
  <p class="title" id=\'title\'>Title</p>
  <!-- here goes the rest of the page -->
  <div class="actions">
    Mix all ingredients and knead thoroughly.
  </div>
</body>
</code></pre>
';

require_once '../vendor/autoload.php';

use Demyanovs\PHPHighlight\Highlighter;
use Demyanovs\PHPHighlight\Themes\ObsidianTheme;

$highlighter = (new Highlighter($text, ObsidianTheme::TITLE))
        ->showLineNumbers(true)
        ->showActionPanel(true);
echo $highlighter->parse();

?>
</body>
</html>
