<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterXML extends HighlighterBase {

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
        $s = self::$_text;
        $text = preg_replace_callback(
            '/[\s]?(<[a-zA-Z\/?!]+>?|\?>)/im',
            function ($matches) {
                return '<span style="color: #808000;">'.htmlspecialchars($matches[0]).'</span>';
            },
            $s
        );
/*
        $text = preg_replace_callback(
            '/>(.*?)</ims',
            function ($matches) {
                return '<span style="color: red;">'.$matches[1].'</span>';
            },
            $text
        );
*/
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