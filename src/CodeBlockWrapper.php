<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Themes\Styles;
use Demyanovs\PHPHighlight\Themes\Theme;

/**
 * Wraps highlighted code with HTML structure (line numbers, action panel, etc.)
 */
class CodeBlockWrapper
{
    public function __construct(private bool $showLineNumbers, private bool $showActionPanel, private Theme $theme)
    {
    }

    /**
     * Wrap highlighted code with HTML structure
     *
     * @param string $highlightedCode Highlighted HTML code
     * @param string $bgColor         Background color from theme
     * @param string $filePath        Optional file path for action panel
     *
     * @return string Wrapped HTML code block
     */
    public function wrap(string $highlightedCode, string $bgColor = '', string $filePath = ''): string
    {
        $text = str_replace('<br />', PHP_EOL, $highlightedCode);
        $lineCount = substr_count($text, PHP_EOL) + 1;

        $wrapper = '<div class="code-block-wrapper">';

        if ($this->showActionPanel && $filePath) {
            $wrapper .= $this->buildActionPanel($filePath);
        }

        $lineNumbers = '';
        if ($this->showLineNumbers && $lineCount > 1) {
            $lineNumbers = $this->buildLineNumbers($lineCount);
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

    /**
     * Build action panel HTML
     */
    private function buildActionPanel(string $filePath): string
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

    /**
     * Build line numbers HTML
     */
    private function buildLineNumbers(int $count): string
    {
        if ($count === 1) {
            return '';
        }

        // Generate line numbers more efficiently using array_map and implode
        $lineNumbers = implode('', array_map(
            fn (int $i) => sprintf(
                '<span class="line-number" style="%s; color: %s">%d</span>',
                Styles::getLineNumberStyle(),
                $this->theme->defaultColorSchema->getDefaultColor(),
                $i,
            ),
            range(1, $count),
        ));

        return sprintf(
            '<div class="line-numbers" style="%s">%s</div>',
            Styles::getLineNumbersStyle(),
            $lineNumbers,
        );
    }
}
