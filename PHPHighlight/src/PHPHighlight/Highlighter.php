<?php

namespace PHPHighlight;

use PHPHighlight\Theme\Theme;

class Highlighter {

    /**
     * @var string
     */
    protected static $_text;

    private $_showActionPanel = true;

    private $_showLineNumbers = true;

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
        $this->_theme = new Theme($theme);
    }

    /**
     * @return null|string|string[]
     */
    public function parse()
    {
        return preg_replace_callback(
            '/<pre([^>]+)>(.*?)<\/pre>/ism',
            function ($matches) {
               preg_match_all('/data-(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/ism', $matches[1], $attributes);
                $data = [];
                foreach ($attributes[1] as $key => $attr) {
                    $data[$attr] = $attributes[2][$key];
                }
                $block = isset($matches[2]) ? trim($matches[2]) : '';
                $lang = isset($data['lang']) ? $data['lang'] : '';
                $file = isset($data['file']) ? $data['file'] : '';
                $theme = isset($data['theme']) ? $data['theme'] : '';
                return $this->parseBlock($block, $lang, $file, $theme);
            },
            self::$_text);
    }

    /**
     * @param string $block
     * @param string $lang
     * @param string $filePath
     * @return mixed|string
     */
    private function parseBlock(string $block, string $lang, string $filePath = '', $theme = '')
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
        if ($theme) {
            $highlighter->setTheme(new Theme($theme));
        } else {
            $highlighter->setTheme(new Theme($this->_theme->getName()));
        }

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
        if ($this->_showActionPanel) {
            $wrapper .= '
            <div class="meta">
                <div class="actions">
                    <span class="js-copy-clipboard copy-text" onclick="codeHighlighter.copyClipboard(this)">copy</span>
                    <span class="meta-divider"></span>
                </div>
                <div class="info">
                    <span>'.$filePath.'</span>
                </div>
            </div>';
        }

        $line_numbers = '';
        if ($this->_showLineNumbers) {
            $text = str_replace('<br />', PHP_EOL, $text);
            $line_numbers = $this->setLineNumbers(count(explode(PHP_EOL, $text)));
        }
        $wrapper .= '<div class="code-highlighter" style="background-color: '.$bgColor.'">'.$line_numbers.'<div class="code-block">'.$text.'</div></div></div>';
        return $wrapper;
    }

    /**
     * @param int $count
     * @return string
     */
    private function setLineNumbers(int $count)
    {
        $line_numbers = '';
        for ($i = 1; $i < $count+1; $i++) {
            $line_numbers .= '<span class="line-number" style="color: '.$this->_theme::getDefaultColor().'">' . $i . '</span>';
        }
        return '<div class="line-numbers">'.$line_numbers.'</div>';
    }

    /**
     * @param bool $status
     */
    public function setShowActionPanel(bool $status)
    {
        $this->_showActionPanel = $status;
    }

    /**
     * @param bool $status
     */
    public function setShowLineNumbers(bool $status)
    {
        $this->_showLineNumbers = $status;
    }
}
