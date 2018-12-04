<?php

namespace CodeHighlighter;

use CodeHighlighter\Theme\Theme;

class Highlighter {

    /**
     * @var string
     */
    protected static $_text;

    public static $showActionsPanel = true;

    public static $showLineNumbers = true;

    /**
     * @var Theme
     */
    private $_theme;

    /**
     * Highlighter constructor.
     * @param string $text
     * @param string $theme
     */
    public function __construct(string $text, string $theme = '')
    {
        self::$_text = $text;
        $this->_theme = Theme::getTheme($theme);
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
            self::$_text);
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
        } elseif ($lang == "xml" || $lang == "html") {
            $highlighter = HighlighterXML::getInstance($block);
        } else {
            $highlighter = HighlighterPHP::getInstance($block);
        }
        $highlighter->setTheme($this->_theme);
        $block = $highlighter->highlight();
        return $this->wrapCode($block, $this->_theme::getBackgroundColor(), $filePath);
    }

    /**
     * @param string $text
     * @param string $bgColor
     * @param string $filePath
     * @return string
     */
    private function wrapCode(string $text, string $bgColor = '', string $filePath = ''): string
    {
        $wrapper = '<div class="code-block-wrapper">';
        if (self::$showActionsPanel) {
            $wrapper .= '
            <div class="meta">
                <div class="actions">
                    <span class="js-copy-clipboard" onclick="codeHighlighter.copyClipboard(this)"><i class="fa fa-copy"></i></span>
                    <span class="meta-divider"></span>
                </div>
                <div class="info">
                    <span>'.$filePath.'</span>
                </div>
            </div>';
        }

        $line_numbers = '';
        if (Highlighter::$showLineNumbers) {
            $text = str_replace('<br />', PHP_EOL, $text);
            $line_numbers = $this->setLineNumbers(count(explode(PHP_EOL, $text)));
        }
        $wrapper .= '<div class="code-highlighter" style="background-color: '.$bgColor.'">'.$line_numbers.'<div class="code-block">'.$text.'</div></div></div>';
        return $wrapper;
    }

    private function setLineNumbers(int $count)
    {
        $line_numbers = '';
        for ($i = 1; $i < $count+1; $i++) {
            $line_numbers .= '<span class="line-number" style="color: '.$this->_theme::getDefaultColor().'">' . $i . '</span>';
        }
        return '<div class="line-numbers">'.$line_numbers.'</div>';
    }
}
