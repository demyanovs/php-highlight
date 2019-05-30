<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Themes\Theme;

class Highlighter
{
    /** @var string */
    protected static $_text;

    /** @var bool */
    private $_showActionPanel = true;

    /** @var bool */
    private $_showLineNumbers = false;

    /** @var Theme */
    private $_theme;

    public function __construct(string $text, string $theme = '')
    {
        self::$_text  = $text;
        $this->_theme = new Theme($theme);
    }

    /**
     * @return string|string[]|null
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
                $lang  = $data['lang'] ?? '';
                $file  = $data['file'] ?? '';
                $theme = $data['theme'] ?? '';

                return $this->parseBlock($block, $lang, $file, $theme);
            },
            self::$_text
        );
    }

    private function parseBlock(string $block, string $lang, string $filePath = '', string $theme = '') : string
    {
        if ($lang === 'php') {
            $highlighter = HighlighterPHP::getInstance($block);
        } elseif ($lang === 'bash') {
            $highlighter = HighlighterBash::getInstance($block);
        } elseif ($lang === 'xml' || $lang === 'html') {
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

    private function wrapCode(string $text, string $bgColor = '', string $filePath = '') : string
    {
        $wrapper = '<div class="code-block-wrapper">';
        if ($this->_showActionPanel) {
            $wrapper .= '
            <div class="meta">
                <div class="actions">
                    <span class="js-copy-clipboard copy-text" onclick="PHPHighlight.copyClipboard(this)">copy</span>
                    <span class="meta-divider"></span>
                </div>
                <div class="info">
                    <span>' . $filePath . '</span>
                </div>
            </div>';
        }

        $line_numbers = '';
        $text         = str_replace('<br />', PHP_EOL, $text);
        if ($this->_showLineNumbers) {
            $line_numbers = $this->setLineNumbers(count(explode(PHP_EOL, $text)));
        }
        $wrapper .= '<div class="code-highlighter" style="background-color: ' . $bgColor . '">' . $line_numbers . '<div class="code-block">' . $text . '</div></div></div>';

        return $wrapper;
    }

    private function setLineNumbers(int $count) : string
    {
        $line_numbers = '';
        for ($i = 1; $i < $count+1; $i++) {
            $line_numbers .= '<span class="line-number" style="color: ' . $this->_theme::getDefaultColor() . '">' . $i . '</span>';
        }

        return '<div class="line-numbers">' . $line_numbers . '</div>';
    }

    public function setShowActionPanel(bool $status) : void
    {
        $this->_showActionPanel = $status;
    }

    public function setShowLineNumbers(bool $status) : void
    {
        $this->_showLineNumbers = $status;
    }
}
