<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Themes\Theme;

class HighlighterBase
{
    /** @var string */
    protected static $_text;

    /** @var string[] */
    protected $_keywords = [];

    /** @var Theme */
    protected $_theme;

    public function __construct(string $text)
    {
        self::$_text = $text;
    }

    public function setTheme(Theme $theme) : void
    {
        $this->_theme = $theme;
    }

    /**
     * @return mixed
     */
    public function highlight()
    {
        $by_lines = explode(PHP_EOL, self::$_text);
        $lines    = [];
        $i        = 1;
        foreach ($by_lines as $key => $line) {
            // Comment line
            if ($this->isCommentLine($line)) {
                $lines[$key] = self::colorWord($line, $line, $this->_theme::getCommentColor());
                $i++;
                continue;
            }
            $words = array_unique(explode(' ', $line));
            foreach ($words as $word) {
                $word = trim($word);
                if ($this->isKeyword($word)) {
                    $line = self::colorWord($word, $line, $this->_theme::getKeywordColor());
                } elseif ($this->isFlag($word)) {
                    $line = self::colorWord($word, $line, $this->_theme::getFlagColor());
                } elseif ($this->isVariable($word)) {
                    $line = self::colorWord($word, $line, $this->_theme::getVariableColor());
                }
                /*
                else {
                    $line = self::colorWord($word, $line, $this->theme->getStringColor());
                }
                */
                $lines[$key] = $line;
            }
            $i++;
        }

        return '<span style="color:' . $this->_theme::getStringColor() . '">' . implode('<br />', $lines) . '</span>';
    }

    /**
     * @return mixed
     */
    public static function colorWord(string $word, string $line, string $color)
    {
        return str_replace($word, '<span style="color:' . $color . '">' . $word . '</span>', $line);
    }

    public static function setText(string $text) : void
    {
        self::$_text = $text;
    }

    protected function isVariable(string $word) : bool
    {
        return substr($word, 0, 1) === '$' ?? false;
    }

    protected function isFlag(string $word) : bool
    {
        return substr($word, 0, 1) === '-' ?? false;
    }

    protected function isKeyword(string $word) : bool
    {
        return in_array($word, $this->_keywords) ?? false;
    }

    protected function isCommentLine(string $word) : bool
    {
        return substr($word, 0, 1) === '#' ?? false;
    }
}
