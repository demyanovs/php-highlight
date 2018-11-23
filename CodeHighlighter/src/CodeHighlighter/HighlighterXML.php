<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterXML extends HighlighterBase {

    use SetOptions;

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
            "<span style=\"color: ".self::getXMLTagColor()."\">&lt;\\1\\2\\3&gt;</span>",$text);
        // Xml version
        $text = preg_replace("#&lt;([\?])(.*)([\?])&gt;#sU",
            "<span style=\"color: ".self::getXMLInfoColor()."\">&lt;\\1\\2\\3&gt;</span>",$text);
        // Attributes
        $text = preg_replace("#([^\s]*?)\=(&quot;|')(.*)(&quot;|')#isU",
            "<span style=\"color: ".self::getXMLAttrNameColor()."\">\\1</span>=<span style=\"color: ".self::getXMLAttrValueColor()."\">\\2\\3\\4</span>",$text);
        return $text;
    }
}