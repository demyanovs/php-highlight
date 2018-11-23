<?php

namespace CodeHighlighter\Theme;

//use CodeHighlighter\Traits\SetOptions;

class Theme
{

//    use SetOptions;

    private static $_defaultColor = '#558eac';

    private static $_backgroundColor = '#fff';

    private static $_commentColor = '#558eac';

    private static $_keywordColor = '#558eac; font-weight: bold';

    private static $_variableColor = '#558eac';

    private static $_stringColor = '#558eac';

    private static $_htmlColor = '#558eac';

    private static $_flagColor = '#558eac';

    private static $_XMLTagColor = '#558eac';

    private static $_XMLAttrNameColor = '#BC7A00;';

    private static $_XMLAttrValueColor = '#BA2121';

    private static $_XMLInfoColor = '#800000';



    public function __construct()
    {
        self::setDefaultColor(self::$_defaultColor);
        self::setBackgroundColor(self::$_backgroundColor);
        self::setCommentColor(self::$_commentColor);
        self::setKeywordColor(self::$_keywordColor);
        self::setVariableColor(self::$_variableColor);
        self::setStringColor(self::$_stringColor);
        self::setHtmlColor(self::$_htmlColor);
        self::setFlagColor(self::$_flagColor);
        self::setXMLTagColor(self::$_XMLTagColor);
        self::setXMLAttrNameColor(self::$_XMLAttrNameColor);
        self::setXMLAttrValueColor(self::$_XMLAttrValueColor);
        self::setXMLInfoColor(self::$_XMLInfoColor);

        ini_set("highlight.comment", self::getCommentColor());
        ini_set("highlight.default", self::getDefaultColor());
        ini_set("highlight.html", self::getHtmlColor());
        ini_set("highlight.keyword", self::getKeywordColor());
        ini_set("highlight.string", self::getStringColor());
    }


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
}