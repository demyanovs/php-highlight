<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterPHP extends HighlighterAbstract {

    use SetOptions;

    private static $_instance;

    public static function getInstance($text)
    {
        if (self::$_instance) {
            return self::$_instance;
        }
        return self::$_instance = new self($text);
    }

    /**
     * @return mixed
     */
    public function highlight()
    {
        // Set default colors
        $this->setColors();
        return str_replace(['&lt;?php&nbsp;<br />', '<code>', '</code>'], '', highlight_string("<?php ".$this->_text, true));
    }

    protected function setColors()
    {
        ini_set("highlight.comment", self::getCommentColor());
        ini_set("highlight.default", self::getDefaultColor());
        ini_set("highlight.html", self::getHtmlColor());
        ini_set("highlight.keyword", self::getKeywordColor());
        ini_set("highlight.string", self::getStringColor());
    }

}