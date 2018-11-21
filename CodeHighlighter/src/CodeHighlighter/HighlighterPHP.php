<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterPHP extends Highlighter {

    use SetOptions;

    private static $_instance;

    public static function getInstance($text)
    {
        self::setText($text);
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
        $this->setColors();
        $text = str_replace(['&lt;?php&nbsp;', '<code>', '</code>'], '', highlight_string("<?php ".self::$_text, true));
        $lines = [];
        $i = 1;
        $by_lines = explode('<br />', $text);
        foreach ($by_lines as $key => $line) {
            if($i == 1) {
                $lines[$key] = $line.$this->setLineNumber($i) ;
            } else {
                $lines[$key] = $this->setLineNumber($i) . $line;
            }
            $i++;
        }

        return implode("<br />", $lines);
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