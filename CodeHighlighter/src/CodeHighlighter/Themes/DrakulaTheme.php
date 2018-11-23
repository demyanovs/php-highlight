<?php

namespace CodeHighlighter\Theme;


class DrakulaTheme extends Theme
{

    private static $_defaultColor = '#ccc';

    private static $_backgroundColor = '#ccc';

    private static $_commentColor = '#cc';

    private static $_keywordColor = '#ccc; font-weight: bold';

    private static $_variableColor = '#ccc';

    private static $_stringColor = '#ccc';

    private static $_htmlColor = '#ccc';

    private static $_flagColor = '#ccc';

    private static $_XMLTagColor = '#ccc';

    private static $_XMLAttrNameColor = '#ccc;';

    private static $_XMLAttrValueColor = '#ccc';

    private static $_XMLInfoColor = '#ccc';


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
}