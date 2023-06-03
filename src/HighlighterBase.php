<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Themes\Theme;

class HighlighterBase
{
    /** @var string[] */
    protected array $keywords = [];

    protected Theme $theme;

    public function __construct(protected string $text)
    {
    }

    public function setTheme(Theme $theme): void
    {
        $this->theme = $theme;
    }

    public function highlight(): string
    {
        $byLines = explode(PHP_EOL, $this->text);
        $lines    = [];
        foreach ($byLines as $key => $line) {
            // Comment line
            if ($this->isCommentLine($line)) {
                $lines[$key] = self::colorWord($line, $line, $this->theme->defaultColorSchema->getCommentColor());
                continue;
            }

            $words = array_unique(explode(' ', $line));
            foreach ($words as $word) {
                $word = trim($word);
                if ($this->isKeyword($word)) {
                    $line = self::colorWord($word, $line, $this->theme->defaultColorSchema->getKeywordColor());
                } elseif ($this->isFlag($word)) {
                    $line = self::colorWord($word, $line, $this->theme->defaultColorSchema->getFlagColor());
                } elseif ($this->isVariable($word)) {
                    $line = self::colorWord($word, $line, $this->theme->defaultColorSchema->getVariableColor());
                }

//                else {
//                    $line = self::colorWord($word, $line, $this->theme->defaultColorSchema->getStringColor());
//                }

                $lines[$key] = $line;
            }
        }

        return sprintf(
            '<span style="color:%s">%s</span>',
            $this->theme->defaultColorSchema->getStringColor(),
            implode('<br />', $lines),
        );
    }

    /**
     * @return array|string|string[]
     */
    public static function colorWord(string $word, string $line, string $color): array|string
    {
        return str_replace(
            $word,
            sprintf('<span style="color: %s">%s</span>', $color, $word),
            $line,
        );
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    protected function isVariable(string $word): bool
    {
        return str_starts_with($word, '$') ?? false;
    }

    protected function isFlag(string $word): bool
    {
        return str_starts_with($word, '-') ?? false;
    }

    protected function isKeyword(string $word): bool
    {
        return in_array($word, $this->keywords) ?? false;
    }

    protected function isCommentLine(string $word): bool
    {
        return str_starts_with($word, '#') ?? false;
    }
}
