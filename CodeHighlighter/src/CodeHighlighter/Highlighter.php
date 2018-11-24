<?php

namespace CodeHighlighter;

use CodeHighlighter\Theme\Theme;

class Highlighter {

    /**
     * @var string
     */
    protected static $_text;

    private $theme;

    public static $_showActionsPanel = true;

    public static $_showLineNumbers = true;

    /**
     * Highlighter constructor.
     * @param string $text
     * @param string $theme
     */
    public function __construct(string $text, string $theme = '')
    {
        self::$_text = $text;
        $this->theme = Theme::getTheme($theme);
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
        $highlighter->setTheme($this->theme);
        $block = $highlighter->highlight();
        return $this->wrapCode($block, $highlighter->theme->getBackgroundColor(), $filePath);
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
        if (self::$_showActionsPanel) {
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
        $wrapper .= '</div><div class="code-highlighter" style="background-color: '.$bgColor.'">'.$text.'</div>';
        return $wrapper;



        return '
            <div class="code-block-wrapper">
            <div class="meta">

                    
   
                </div>
            </div>
            <div class="code-highlighter" style="background-color: '.$bgColor.'">'.$text.'</div>';
    }
}
