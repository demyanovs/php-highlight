<?php

namespace CodeHighlighter\Theme;

use CodeHighlighter\Traits\SetOptions;

class Theme
{
    use SetOptions;

    private static $_instance;

    private function __construct(string $theme = '')
    {
        if (strtolower($theme) == "drakula") {
            $this->DrakulaTheme();
        } else {
            $this->DefaultTheme();
        }
    }

    public static function getTheme(string $theme = '')
    {
        if (self::$_instance) {
            return self::$_instance;
        }
        return self::$_instance = new self($theme);
    }

    private function DefaultTheme()
    {
        // Default
        self::setDefaultColor('#000;');
        self::setBackgroundColor('#f8f8f8');
        self::setCommentColor('#7f7f7f;');
        self::setKeywordColor('#cb7832;');
        self::setVariableColor('#cb7832');
        self::setStringColor('#000;');
        self::setHtmlColor('#fbc201;');
        self::setFlagColor('#cb7832;');

        // XML
        self::setXMLTagColor('#008000;');
        self::setXMLAttrNameColor('#7D9029;');
        self::setXMLAttrValueColor('#BA2121;');
        self::setXMLInfoColor('#BC7A00;');

        // PHP
        self::setPHPDefaultColor('#0000BB;');
        self::setPHPCommentColor('#FF8000;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#007700;');
        self::setPHPStringColor('#DD0000;');
    }

    private function DrakulaTheme()
    {
        // Default
        self::setDefaultColor('#bababa;');
        self::setBackgroundColor('#2b2b2b');
        self::setCommentColor('#7f7f7f;');
        self::setKeywordColor('#cb7832;');
        self::setVariableColor('#cb7832');
        self::setStringColor('#6a8759;');
        self::setHtmlColor('#fbc201;');
        self::setFlagColor('#cb7832;');

        // XML
        self::setXMLTagColor('#cb7832;');
        self::setXMLAttrNameColor('#bababa;');
        self::setXMLAttrValueColor('#6896ba;');
        self::setXMLInfoColor('#7f7f7f;');

        // PHP
        self::setPHPDefaultColor('#bababa;');
        self::setPHPCommentColor('#7f7f7f;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#cb7832;');
        self::setPHPStringColor('#6a8759;');
    }
}
