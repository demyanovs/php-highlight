<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Themes\Styles;
use Demyanovs\PHPHighlight\Themes\Theme;
use Demyanovs\PHPHighlight\Themes\ThemePool;

class Highlighter
{
    protected string $text;

    private bool $showLineNumbers = true;

    private bool $showActionPanel = true;

    private Theme $theme;

    private ThemePool $themePool;

    /**
     * @param Theme[] $customThemes
     */
    public function __construct(string $text, string $themeTitle = '', array $customThemes = [])
    {
        $this->text = str_replace('<?php', '&lt;?php', $text);
        $this->themePool = new ThemePool($customThemes);
        $this->theme = $this->themePool->getByTitle($themeTitle);
    }

    /**
     * @return string|string[]|null
     */
    public function parse(): array|string|null
    {
        $callback = function ($matches) {
            $patternDataAttr = '/data-(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/ism';
            preg_match_all($patternDataAttr, $matches[1], $attributes);
            $data = [];
            foreach ($attributes[1] as $key => $attr) {
                $data[$attr] = $attributes[2][$key];
            }

            $block = isset($matches[2]) ? trim($matches[2]) : '';
            $lang  = $data['lang'] ?? '';
            $file  = $data['file'] ?? '';
            $themeName = $data['theme'] ?? '';

            if (!$lang) {
                return str_replace('<?php', '&lt;?php', $block);
            }

            return $this->parseBlock($block, $lang, $file, $themeName);
        };

        $patternPreTag = '/<pre([^>]+)>(.*?)<\/pre>/ism';

        return preg_replace_callback(
            $patternPreTag,
            $callback,
            $this->text,
        );
    }

    private function parseBlock(string $block, string $lang, string $filePath = '', string $themeName = ''): string
    {
        if ($lang === 'bash') {
            $highlighter = HighlighterBash::getInstance($block);
        } elseif ($lang === 'xml' || $lang === 'html') {
            $highlighter = HighlighterXML::getInstance($block);
        } else {
            $block = str_replace('&lt;?php', '<?php', $block);
            $highlighter = HighlighterPHP::getInstance($block);
        }

        if ($themeName) {
            $theme = $this->themePool->getByTitle($themeName);
        } else {
            $theme = $this->theme;
        }

        $theme->PHPColorSchemaDto->applyColors();
        $highlighter->setTheme($theme);
        $block = $highlighter->highlight();

        return $this->wrapCode($block, $theme->defaultColorSchema->getBackgroundColor(), $filePath);
    }

    private function wrapCode(string $text, string $bgColor = '', string $filePath = ''): string
    {
        $wrapper = '<div class="code-block-wrapper">';
        if ($this->showActionPanel && $filePath) {
            $wrapper .= $this->attachActionPanel($filePath);
        }

        $lineNumbers = '';
        $text = str_replace('<br />', PHP_EOL, $text);

        if ($this->showLineNumbers) {
            $lineNumbers = $this->attachLineNumbers(count(explode(PHP_EOL, $text)));
        }

        $wrapper .= sprintf(
            '
            <div class="code-highlighter" style="%s; background-color: %s">' .
                $lineNumbers .
                '<div class="code-block">%s</div>
            </div>',
            Styles::getCodeHighlighterStyle(),
            $bgColor,
            $text,
        );

        $wrapper .= '</div>';

        return $wrapper;
    }

    public function showLineNumbers(bool $showLineNumbers): void
    {
        $this->showLineNumbers = $showLineNumbers;
    }

    public function showActionPanel(bool $showActionPanel): void
    {
        $this->showActionPanel = $showActionPanel;
    }

    private function attachActionPanel(string $filePath): string
    {
        return sprintf(
            '
            <div class="meta" style="%s">
                <div class="info" style="%s">
                    <span>%s</span>
                </div>
            </div>
            ',
            Styles::getCodeBlockWrapperMetaStyle(),
            Styles::getCodeBlockWrapperInfoStyle(),
            $filePath,
        );
    }

    private function attachLineNumbers(int $count): string
    {
        if ($count === 1) {
            return false;
        }

        $lineNumbers = '';
        for ($i = 1; $i < $count + 1; $i++) {
            $lineNumbers .= sprintf(
                '<span class="line-number" style="%s; color: %s">%d</span>',
                Styles::getLineNumberStyle(),
                $this->theme->defaultColorSchema->getDefaultColor(),
                $i,
            );
        }

        return sprintf(
            '<div class="line-numbers" style="%s">%s</div>',
            Styles::getLineNumbersStyle(),
            $lineNumbers,
        );
    }
}
