<?php

namespace CodeHighlighter;

abstract class HighlighterAbstract
{
    /**
     * @var string
     */
    protected static $_text;

    /**
     * HighlightAbstract constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        self::$_text = $text;
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
        return '<span class="line-number">'.$number.'</span>';
    }

    /**
     * @return mixed
     */
    abstract public function highlight();
}