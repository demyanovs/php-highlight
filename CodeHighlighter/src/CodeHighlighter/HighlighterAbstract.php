<?php
/**
 * Created by PhpStorm.
 * User: vyacheslav.demyanov
 * Date: 25.10.18
 * Time: 10:28
 */

namespace CodeHighlighter;

abstract class HighlighterAbstract
{
    /**
     * @var string
     */
    protected $_text;

    /**
     * HighlightAbstract constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->_text = $text;
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
     * @param string $bg_color
     * @return string
     */
    public static function wrapCode(string $text, string $bg_color = ''): string
    {
        return "<code style='background-color: $bg_color'>".$text."</code>";
    }

    protected function setColors()
    {

    }

    /**
     * @return mixed
     */
    abstract public function highlight();
}