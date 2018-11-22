<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterXml extends HighlighterBase {

    use SetOptions;

    private static $_instance;

    private static $_tag_color = '#808000; font-weight: bold;';

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
        /*
        $s = self::$_text;
        $s = htmlspecialchars($s);
        // Tag brackets
        $s = preg_replace("#&lt;([\?])(.*)([\?])&gt;#sU",
            "<span style=\"color: #800000\">&lt;\\1\\2\\3&gt;</span>",$s);
        $s = preg_replace("#&lt;([^\s\?/=])(.*)([\[\s/]|&gt;)#iU",
            "&lt;<span style=\"color: ".self::getTagColor()."\">\\1\\2</span>\\3",$s);
        $s = preg_replace("#&lt;([/])([^\s]*?)([\s\]]*?)&gt;#iU",
            "&lt;\\1<span style=\"color: ".self::getTagColor()."\">\\2</span>\\3&gt;",$s);

        $s = preg_replace("#&lt;(.*)(\[)(.*)(\])&gt;#isU",
            "&lt;\\1<span style=\"color: #800080\">\\2\\3\\4</span>&gt;",$s);
        // Value color
        // [\s](.*=)(".*")

        */


//        [.\s?]?<[a-z!?\/]++[\s]?+((.*?="(.*?)")(.*?=)"(.*?)")?
//      ([.\s?]?<[a-z!?\/]++[\s]?+)((.*?="(.*?)")(.*?=)"(.*?)")?
//gmi


        $text = preg_replace('/([a-zA-z]*=)(".*")/ismU', '<span style="color: orange">$1</span><span style="color: red">$2</span><span style="color: green">$4</span>', self::$_text);

        /*
                $text = preg_replace_callback(
                    '/([a-zA-z]*=)(".*")/ismU',
                    function ($matches) {
                        print_r($matches);
                        $var = $matches[1];
                        $value = $matches[2];
                        return $matches[0];

                        //$lang = $matches[1];
                        //$filePath = $matches[3];
                        //$block = trim($matches[4]);
                        //return $this->parseBlock($block, $lang, $filePath);
                    },
                    self::$_text);
                */

        // Comment
        return $text;
    }

    /**
     * @param string $color
     */
    public static function setTagColor(string $color)
    {
        self::$_tag_color = $color;
    }

    public static function getTagColor()
    {
        return self::$_tag_color;
    }
}