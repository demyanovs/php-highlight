<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class Highlighter
{
    use SetOptions;
    /**
     * @var string
     */
    protected static $_text;

    protected $_keywords = [];

    private $_showLineNumbers = true;

    /**
     * Highlighter constructor.
     * @param string $text
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
                $lines[$key] = $this->setLineNumber($i).self::colorWord($line, $line, self::getCommentColor());
                $i++;
                continue;
            }
            $words = array_unique(explode(' ', $line));
            foreach ($words as $word) {
                $word = trim($word);
                if ($this->isKeyword($word)) {
                    $line = self::colorWord($word, $line, self::getKeywordColor());
                } elseif ($this->isFlag($word)) {
                    $line = self::colorWord($word, $line, self::getFlagColor());
                } elseif ($this->isVariable($word)) {
                    $line = self::colorWord($word, $line, self::getVariableColor());
                } else {
                    $line = self::colorWord($word, $line, self::getStringColor());
                }
                $lines[$key] = $this->setLineNumber($i).$line;
            }
            $i++;
        }

        return implode("<br />", $lines);
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
        if ($this->_showLineNumbers) {
            return '<span class="line-number">' . $number . '</span>';
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
}