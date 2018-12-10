<?php

namespace PHPHighlight\Traits;

trait SetOptions
{

    private static $_defaultColor;

    private static $_backgroundColor;

    private static $_commentColor;

    private static $_keywordColor;

    private static $_variableColor;

    private static $_stringColor;

    private static $_htmlColor;

    private static $_flagColor;

    private static $_XMLTagColor;

    private static $_XMLAttrNameColor;

    private static $_XMLAttrValueColor;

    private static $_XMLInfoColor;

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
    public static function getFlagColor(): string
    {
        return self::$_flagColor;
    }

    /**
     * @param string $color
     */
    public static function setFlagColor(string $color)
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

    /**
     * @param string $color
     */
    public static function setPHPDefaultColor(string $color)
    {
        ini_set("highlight.default", $color);
    }

    /**
     * @param string $color
     */
    public static function setPHPCommentColor(string $color)
    {
        ini_set("highlight.comment", $color);
    }

    /**
     * @param string $color
     */
    public static function setPHPHtmlColor(string $color)
    {
        ini_set("highlight.html", $color);
    }

    /**
     * @param string $color
     */
    public static function setPHPKeywordColor(string $color)
    {
        ini_set("highlight.keyword", $color);
    }

    /**
     * @param string $color
     */
    public static function setPHPStringColor(string $color)
    {
        ini_set("highlight.string", $color);
    }
}