<?php

namespace CodeHighlighter;

//use CodeHighlighter\Traits\SetOptions;

class HighlighterPHP extends HighlighterBase {

//    use SetOptions;

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
        //self::setColors();
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
}