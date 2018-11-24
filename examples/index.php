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
use CodeHighlighter\HighlighterPHP;
use CodeHighlighter\HighlighterBash;
use CodeHighlighter\Theme\Theme;

$text = '
<h2>PHP</h2>
<code data-lang="php" data-file-path="php-code-highlighter/examples/index.php">
require_once \'Zend/Uri/Http.php\';

namespace Location\Web;

interface Factory
{
    static function _factory();
}

abstract class URI extends BaseURI implements Factory
{
    abstract function test();

    public static $st1 = 1;
    const ME = "Yo";
    var $list = NULL;
    private $var;

    /**
     * Returns a URI
     *
     * @return URI
     */
    static public function _factory($stats = array(), $uri = \'http\')
    {
        echo __METHOD__;
        $uri = explode(\':\', $uri, 0b10);
        $schemeSpecific = isset($uri[1]) ? $uri[1] : \'\';
        $desc = \'Multi
line description\';

        // Security check
        if (!ctype_alnum($scheme)) {
            throw new Zend_Uri_Exception(\'Illegal scheme\');
        }

        $this->var = 0 - self::$st;
        $this->list = list(Array("1"=> 2, 2=>self::ME, 3 => \Location\Web\URI::class));

        return [
            \'uri\'   => $uri,
            \'value\' => null,
        ];
    }
}

echo URI::ME . URI::$st1;

__halt_compiler () ; datahere
datahere
datahere */
datahere
</code>

<h2>JavaScript</h2>
<code data-lang="js" data-file-path="example.js">
function $initHighlight(block, cls) {
  try {
    if (cls.search(/\bno\-highlight\b/) != -1)
      return process(block, true, 0x0F) +
             ` class="${cls}"`;
  } catch (e) {
    /* handle exception */
  }
  for (var i = 0 / 2; i < classes.length; i++) {
    if (checkCondition(classes[i]) === undefined)
      console.log(\'undefined\');
  }
}

export  $initHighlight;
</code>

<h2>Bash</h2>
<code data-lang="bash" data-file-path="example.sh">
#!/bin/bash

###### CONFIG
ACCEPTED_HOSTS = root.hag_accepted.conf
BE_VERBOSE=false

if [ "$UID" -ne 0 ]
then
 echo "Superuser rights required"
 exit 2
fi

genApacheConf(){
 echo -e "# Host ${HOME_DIR}$1/$2 :"
}
</code>


<h2>Xml</h2>
<code data-lang="xml">
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE recipe>
<recipe name="хлеб" preptime="5min" cooktime="180min">
   <title>
      Простой хлеб
   </title>
   <composition>
      <ingredient amount="3" unit="стакан">Мука</ingredient>
      <ingredient amount="0.25" unit="грамм">Дрожжи</ingredient>
      <ingredient amount="1.5" unit="стакан">Тёплая вода</ingredient>
   </composition>
   <instructions>
     <step>
        Смешать все ингредиенты и тщательно замесить. 
     </step>
     <step>
        Закрыть тканью и оставить на один час в тёплом помещении. 
     </step>
     <step>
        Замесить ещё раз, положить на противень и поставить в духовку.
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
    Смешать все ингредиенты и тщательно замесить. 
  </div>
</body>
</code>
';

$highlighter = new Highlighter($text, 'drakula');
//if necessary, the theme settings are overwritten here
//Theme::getTheme()::setBackgroundColor('#ccc');




echo $highlighter->parse();

?>
</body>
</html>
