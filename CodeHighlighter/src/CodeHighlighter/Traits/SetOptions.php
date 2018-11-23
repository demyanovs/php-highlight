<?php

namespace CodeHighlighter\Traits;

trait SetOptions
{

    private static $_defaultColor = '#0000BB';

    private static $_backgroundColor = '#FFF';

    private static $_commentColor = '#FF8000';

    private static $_keywordColor = '#007700; font-weight: bold';

    private static $_variableColor = '#0000BB';

    private static $_stringColor = '#DD0000';

    private static $_htmlColor = '#808080';

    private static $_flagColor = '#fa6e6e';

    private static $_XMLTagColor = '#008000';

    private static $_XMLAttrNameColor = '#BC7A00;';

    private static $_XMLAttrValueColor = '#BA2121';

    private static $_XMLInfoColor = '#800000';

    /**
     * @param string $color
     */
    public static function setDefaultColor(string $color): void
    {
        self::$_defaultColor = $color;
    }

    /**
     * @return string
     */
    public static function getDefaultColor(): string
    {
        return self::$_defaultColor;
    }

    /**
     * @param string $color
     */
    public static function setBackgroundColor(string $color)
    {
        self::$_backgroundColor = $color;
    }

    /**
     * @return string
     */
    public static function getBackgroundColor(): string
    {
        return self::$_backgroundColor;
    }

    /**
     * @param string $color
     */
    public static function setCommentColor(string $color)
    {
        self::$_commentColor = $color;
    }

    /**
     * @return string
     */
    public static function getCommentColor(): string
    {
        return self::$_commentColor;
    }

    /**
     * @param string $color
     */
    public static function setKeywordColor(string $color)
    {
        self::$_keywordColor = $color;
    }

    /**
     * @return string
     */
    public static function getKeywordColor(): string
    {
        return self::$_keywordColor;
    }

    /**
     * @param string $color
     */
    public static function setVariableColor(string $color)
    {
        self::$_variableColor = $color;
    }

    /**
     * @return string
     */
    public static function getVariableColor()
    {
        return self::$_variableColor;
    }

    /**
     * @param string $color
     */
    public static function setStringColor(string $color): void
    {
        self::$_stringColor = $color;
    }

    /**
     * @return string
     */
    public static function getStringColor(): string
    {
        return self::$_stringColor;
    }

    /**
     * @param string $color
     */
    public static function setHtmlColor(string $color): void
    {
        self::$_htmlColor = $color;
    }

    /**
     * @return string
     */
    public static function getHtmlColor(): string
    {
        return self::$_htmlColor;
    }

    /**
     * @return string
     */
    private function getFlagColor(): string
    {
        return self::$_flagColor;
    }

    /**
     * @param string $color
     */
    private function setFlagColor(string $color)
    {
        self::$_flagColor = $color;
    }

    /**
     * @param string $color
     */
    public static function setXMLTagColor(string $color)
    {
        self::$_XMLTagColor = $color;
    }

    public static function getXMLTagColor()
    {
        return self::$_XMLTagColor;
    }

    /**
     * @param string $color
     */
    public static function setXMLAttrNameColor(string $color)
    {
        self::$_XMLAttrNameColor = $color;
    }

    public static function getXMLAttrNameColor()
    {
        return self::$_XMLAttrNameColor;
    }

    /**
     * @param string $color
     */
    public static function setXMLAttrValueColor(string $color)
    {
        self::$_XMLAttrValueColor = $color;
    }

    public static function getXMLAttrValueColor()
    {
        return self::$_XMLAttrValueColor;
    }

    /**
     * @param string $color
     */
    public static function setXMLInfoColor(string $color)
    {
        self::$_XMLInfoColor = $color;
    }

    public static function getXMLInfoColor()
    {
        return self::$_XMLInfoColor;
    }
}