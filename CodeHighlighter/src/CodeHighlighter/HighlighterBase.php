<?php

namespace CodeHighlighter;

class HighlighterBase
{

    /**
     * @var string
     */
    protected static $_text;

    protected $_keywords = [];

    /**
     * @var Theme
     */
    public $theme;

    /**
     * HighlighterBase constructor.
     * @param string $text
     * @param null $theme
     */
    public function __construct(string $text)
    {
        self::$_text = $text;
    }

    /**
     * @return mixed
     */
    public function highlight()
    {
        $by_lines = explode(PHP_EOL, self::$_text);
        $lines = [];
        $i = 1;
        foreach ($by_lines as $key => $line) {
            // Comment line
            if ($this->isCommentLine($line)) {
                $lines[$key] = $this->setLineNumber($i).self::colorWord($line, $line, $this->theme->getCommentColor());
                $i++;
                continue;
            }
            $words = array_unique(explode(' ', $line));
            foreach ($words as $word) {
                $word = trim($word);
                if ($this->isKeyword($word)) {
                    $line = self::colorWord($word, $line, $this->theme->getKeywordColor());
                } elseif ($this->isFlag($word)) {
                    $line = self::colorWord($word, $line, $this->theme->getFlagColor());
                } elseif ($this->isVariable($word)) {
                    $line = self::colorWord($word, $line, $this->theme->getVariableColor());
                } else {
                    //$line = self::colorWord($word, $line, $this->theme->getStringColor());
                }
                $lines[$key] = $this->setLineNumber($i).$line;
            }
            $i++;
        }

        return '<span style="color:'.$this->theme->getStringColor().'">'.implode("<br />", $lines).'</span>';
    }

    /**
     * @param string $word
     * @param string $line
     * @param string $color
     * @return mixed
     */
    public static function colorWord(string $word, string $line, string $color)
    {
        return str_replace($word, '<span style="color:'.$color.'">'.$word.'</span>', $line);
    }

    /**
     * @param string $text
     */
    public static function setText(string $text)
    {
        self::$_text = $text;
    }

    protected function setLineNumber(int $number)
    {
        if (Highlighter::$_showLineNumbers) {
            return '<span class="line-number" style="color: '.$this->theme->getDefaultColor().'">' . $number . '</span>';
        } else {
            return '';
        }
    }

    /**
     * @param string $word
     * @return bool
     */
    protected function isVariable(string $word): bool
    {
        if (substr($word, 0, 1) == "$") {
            return true;
        }
        return false;
    }

    /**
     * @param string $word
     * @return bool
     */
    protected function isFlag(string $word): bool
    {
        if (substr($word, 0, 1) == "-") {
            return true;
        }
        return false;
    }

    /**
     * @param string $word
     * @return bool
     */
    protected function isKeyword(string $word): bool
    {
        if (in_array($word, $this->_keywords)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $word
     * @return bool
     */
    protected function isCommentLine(string $word): bool
    {
        if (substr($word, 0, 1) == "#") {
            return true;
        }
        return false;
    }

    /**
     * @param Theme $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }
}