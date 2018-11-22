<?php

namespace CodeHighlighter;

class Highlighter {

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
            '/<code data-lang="(.*?)"( data-file-path="(.*?)">|>)(.*?)<\/code>/ism',
            function ($matches) {
                $lang = $matches[1];
                $filePath = $matches[3];
                $block = trim($matches[4]);
                return $this->parseBlock($block, $lang, $filePath);
            },
            $this->_text);
    }

    /**
     * @param string $block
     * @param string $lang
     * @param string $filePath
     * @return mixed|string
     */
    private function parseBlock(string $block, string $lang, string $filePath = '')
    {
        if ($lang == "php") {
            $highlighter = HighlighterPHP::getInstance($block);
        } elseif ($lang == "bash") {
            $highlighter = HighlighterBash::getInstance($block);
        } elseif ($lang == "xml") {
            $highlighter = HighlighterXML::getInstance($block);
        } else {
            $highlighter = new HighlighterPHP($block);
        }
        $block = $highlighter->highlight();
        return $this->wrapCode($block, $highlighter::getBackgroundColor(), $filePath);
    }

    /**
     * @param string $text
     * @param string $bgColor
     * @param string $filePath
     * @return string
     */
    private function wrapCode(string $text, string $bgColor = '', string $filePath = ''): string
    {
        return '
            <div class="code-block-wrapper">
            <div class="meta">
                <div class="actions">
                        <span class="js-copy-clipboard" onclick="codeHighlighter.copyClipboard(this)"><i class="fa fa-copy"></i></span>
                        <span class="meta-divider"></span>
                    </div>
                    
                    <div class="info">
                        <span>'.$filePath.'</span>
                    </div>
                </div>
            </div>
            <div class="code-highlighter" style="background-color: '.$bgColor.'">'.$text.'</div>';
    }
}
