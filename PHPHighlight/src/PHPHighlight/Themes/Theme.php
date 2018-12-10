<?php

namespace PHPHighlight\Theme;

use PHPHighlight\Traits\SetOptions;

class Theme
{
    use SetOptions;

    private static $_instance;

    /**
     * @var string
     */
    private $_name = '';

    /**
     * Theme constructor.
     * @param string $theme
     */
    public function __construct(string $theme = '')
    {
        $this->_name = $theme;
        if (strtolower($theme) == "drakula") {
            $this->drakulaTheme();
        } elseif (strtolower($theme) == "railscasts") {
                $this->railscastsTheme();
        } else {
            $this->defaultTheme();
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    private function defaultTheme()
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

    private function drakulaTheme()
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

    private function railscastsTheme()
    {
        // Default
        self::setDefaultColor('#bababa;');
        self::setBackgroundColor('#232323');
        self::setCommentColor('#bc9458;');
        self::setKeywordColor('#cb7832;');
        self::setVariableColor('#e6e1dc');
        self::setStringColor('#a5c261;');
        self::setHtmlColor('#fbc201;');
        self::setFlagColor('#cb7832;');

        // XML
        self::setXMLTagColor('#e8bf6a;');
        self::setXMLAttrNameColor('#6d9cbe;');
        self::setXMLAttrValueColor('#519f50;');
        self::setXMLInfoColor('#9b859d;');

        // PHP
        self::setPHPDefaultColor('#e6e1dc;');
        self::setPHPCommentColor('#bc9458;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#c26230;');
        self::setPHPStringColor('#a5c261;');
    }
}
