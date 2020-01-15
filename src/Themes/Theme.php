<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Traits\SetOptions;

class Theme
{
    use SetOptions;

    /** @var string */
    private $_name = '';

    public function __construct(string $theme = '')
    {
        $this->_name = $theme;

        try {
            $theme = strtolower($theme) . 'Theme';
            $this->$theme();
        } catch (\Throwable $e) {
            $this->defaultTheme();
        }
    }

    public function getName() : string
    {
        return $this->_name;
    }

    private function defaultTheme() : void
    {
        // Default
        self::setDefaultColor('#000;');
        self::setBackgroundColor('#f8f8f8');
        self::setCommentColor('#7f7f7f;');
        self::setKeywordColor('#cb7832; font-weight: bold;');
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
        self::setPHPKeywordColor('#007700; font-weight: bold;');
        self::setPHPStringColor('#DD0000;');
    }

    private function darkulaTheme() : void
    {
        // Default
        self::setDefaultColor('#bababa;');
        self::setBackgroundColor('#2b2b2b');
        self::setCommentColor('#7f7f7f;');
        self::setKeywordColor('#cb7832; font-weight: bold;');
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
        self::setPHPCommentColor('#7f7f7f; font-weight: bold;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#cb7832;');
        self::setPHPStringColor('#6a8759;');
    }

    private function railscastsTheme() : void
    {
        // Default
        self::setDefaultColor('#bababa;');
        self::setBackgroundColor('#232323');
        self::setCommentColor('#bc9458;');
        self::setKeywordColor('#cb7832; font-weight: bold;');
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
        self::setPHPKeywordColor('#c26230; font-weight: bold;');
        self::setPHPStringColor('#a5c261;');
    }

    private function obsidianTheme() : void
    {
        // Default
        self::setDefaultColor('#e0e2e4;');
        self::setBackgroundColor('#282b2e');
        self::setCommentColor('#818e96;');
        self::setKeywordColor('#93c763; font-weight: bold;');
        self::setVariableColor('#e6e1dc');
        self::setStringColor('#e0e2e4;');
        self::setHtmlColor('#fbc201;');
        self::setFlagColor('#ec7600;');

        // XML
        self::setXMLTagColor('#8cbbad; font-weight: bold;');
        self::setXMLAttrNameColor('#6d9cbe;');
        self::setXMLAttrValueColor('#ec7600;');
        self::setXMLInfoColor('#557182;');

        // PHP
        self::setPHPDefaultColor('#e0e2e4;');
        self::setPHPCommentColor('#818e96;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#93c763; font-weight: bold;');
        self::setPHPStringColor('#ec7600;');
    }

    private function farTheme() : void
    {
        // Default
        self::setDefaultColor('#e0e2e4;');
        self::setBackgroundColor('#000080');
        self::setCommentColor('#888;');
        self::setKeywordColor('#fff; font-weight: bold;');
        self::setVariableColor('#0ff');
        self::setStringColor('#0ff;');
        self::setHtmlColor('#fbc201;');
        self::setFlagColor('#ff0;');

        // XML
        self::setXMLTagColor('#fff; font-weight: bold;');
        self::setXMLAttrNameColor('#0ff;');
        self::setXMLAttrValueColor('#ff0;');
        self::setXMLInfoColor('#008080;');

        // PHP
        self::setPHPDefaultColor('#0ff;');
        self::setPHPCommentColor('#888;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#fff; font-weight: bold;');
        self::setPHPStringColor('#ff0;');
    }

    private function vs2015Theme() : void
    {
        // Default
        self::setDefaultColor('#DCDCDC;');
        self::setBackgroundColor('#1E1E1E');
        self::setCommentColor('#57A64A;');
        self::setKeywordColor('#569CD6;');
        self::setVariableColor('#4EC9B0');
        self::setStringColor('#D69D85;');
        self::setHtmlColor('#fbc201;');
        self::setFlagColor('#F0F0F0;');

        // XML
        self::setXMLTagColor('#569CD6; font-weight;');
        self::setXMLAttrNameColor('#9CDCFE;');
        self::setXMLAttrValueColor('#D69D85;');
        self::setXMLInfoColor('#9B9B9B;');

        // PHP
        self::setPHPDefaultColor('#DCDCDC;');
        self::setPHPCommentColor('#57A64A;');
        self::setPHPHtmlColor('#fbc201;');
        self::setPHPKeywordColor('#569CD6; font-weight: bold;');
        self::setPHPStringColor('#D69D85;');
    }

    private function c64Theme() : void
    {
        // Default
        self::setDefaultColor('#70A4B2;');
        self::setBackgroundColor('#352879');
        self::setCommentColor('#6C5EB5;');
        self::setKeywordColor('#FFFFFF;');
        self::setVariableColor('#70A4B2');
        self::setStringColor('#B8C76F;');
        self::setHtmlColor('#70A4B2;');
        self::setFlagColor('#588D43;');

        // XML
        self::setXMLTagColor('#70A4B2; font-weight;');
        self::setXMLAttrNameColor('#9A6759;');
        self::setXMLAttrValueColor('#9AD284;');
        self::setXMLInfoColor('#6C6C6C;');

        // PHP
        self::setPHPDefaultColor('#FFFFFF;');
        self::setPHPCommentColor('#9AD284;');
        self::setPHPHtmlColor('#70A4B2;');
        self::setPHPKeywordColor('#70A4B2; font-weight: bold;');
        self::setPHPStringColor('#B8C76F;');
    }
}
