<?php

namespace CodeHighlighter;

class HighlighterText {

    /**
     * @var string
     */
    private $_text;

    /**
     * HighlightText constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->_text = $text;
    }

    /**
     * @return null|string|string[]
     */
    public function parse()
    {
        return preg_replace_callback(
            '/<code data-lang="(.*?)">(.*?)<\/code>/ism',
            function ($matches) {
                $lang = $matches[1];
                $block = $matches[2];
                return $this->parseBlock($block, $lang);
            },
            $this->_text);
    }

    /**
     * @param string $block
     * @param string $lang
     * @return mixed|string
     */
    private function parseBlock(string $block, string $lang)
    {
        if ($lang == "php") {
            $highlighter = HighlighterPHP::getInstance($block);
            $block = $highlighter->highlight();
        } elseif ($lang == "bash") {
            $highlighter = HighlighterBash::getInstance($block);
            $block = $highlighter->highlight();
        } else {
            $highlighter = new HighlighterPHP($block);
            $block = $highlighter->highlight();
        }
        return $block;
    }
}
