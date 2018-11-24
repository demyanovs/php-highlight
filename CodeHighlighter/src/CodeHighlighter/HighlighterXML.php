<?php

namespace CodeHighlighter;

class HighlighterXML extends HighlighterBase {

    private static $_instance;

    public static function getInstance(string $text)
    {
        self::setText($text);
        if (self::$_instance) {
            return self::$_instance;
        }
        return self::$_instance = new self($text);
    }

    function highlight()
    {
        $text = htmlspecialchars(self::$_text);
        // Brackets
        $text = preg_replace("#&lt;([/]*?)(.*)([\s]*?)&gt;#sU",
            "<span style=\"color: ".$this->theme::getXMLTagColor()."\">&lt;\\1\\2\\3&gt;</span>",$text);
        // Xml version
        $text = preg_replace("#&lt;([\?])(.*)([\?])&gt;#sU",
            "<span style=\"color: ".$this->theme::getXMLInfoColor()."\">&lt;\\1\\2\\3&gt;</span>",$text);
        // Attributes
        $text = preg_replace("#([^\s]*?)\=(&quot;|')(.*)(&quot;|')#isU",
            "<span style=\"color: ".$this->theme::getXMLAttrNameColor()."\">\\1</span>=<span style=\"color: ".$this->theme::getXMLAttrValueColor()."\">\\2\\3\\4</span>",$text);

        if (Highlighter::$_showLineNumbers) {
            $by_lines = explode(PHP_EOL, $text);
            $lines = [];
            if ($by_lines) {
                $i = 1;
                foreach ($by_lines as $line) {
                    $lines[] = self::setLineNumber($i).$line;
                    $i++;
                }
                $text = implode(PHP_EOL, $lines);
            }
        }

        return '<span style="color: '.$this->theme->getStringColor().'">'.$text.'</span>';
    }
}