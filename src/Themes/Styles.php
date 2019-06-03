<?php
/**
 * Class for replacing css file
 */

namespace Demyanovs\PHPHighlight\Themes;

class Styles
{
    /** @var string */
    private static $_codeHighlighterStyle = "display: block; padding: 5px; border: 1px solid #ddd; border-radius: 3px; font-size: 12px; font-family: 'SFMono-Regular',Consolas,'Liberation Mono',Menlo,Courier,monospace; overflow-x: auto; overflow-y: hidden; white-space: pre-wrap; tab-size: 4;";

    /** @var string */
    private static $_codeBlockWrapperMetaStyle = 'padding: 5px 10px; border: 1px solid #ddd; border-bottom: none; background-color: #eee; border-top-left-radius: 4px; border-top-right-radius: 4px;';

    /** @var string */
    private static $_codeBlockWrapperInfoStyle = 'height: 23px; line-height: 23px; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;';

    /** @var string */
    private static $_codeBlockWrapperActionsStyle = 'float: left; line-height: 22px; margin-right: 10px;';

    /** @var string */
    private static $_codeBlockWrapperMetaDivider = 'display: inline-block; width: 1px; height: 15px; margin: 0 3px; vertical-align: middle; background-color: #ddd;';

    /** @var string */
    private static $_codeBlockWrapperCopyTextStyle = 'font-size: 16px; cursor: pointer;';

    /** @var string */
    private static $_lineNumbersStyle = 'margin-right: 15px; color: #000; font-weight: normal; float: left;';

    /** @var string */
    private static $_lineNumberStyle = 'display: block;';

    public static function getCodeHighlighterStyle() : string
    {
        return self::$_codeHighlighterStyle;
    }

    public static function getCodeBlockWrapperMetaStyle() : string
    {
        return self::$_codeBlockWrapperMetaStyle;
    }

    public static function getCodeBlockWrapperInfoStyle() : string
    {
        return self::$_codeBlockWrapperInfoStyle;
    }

    public static function getCodeBlockWrapperActionsStyle() : string
    {
        return self::$_codeBlockWrapperActionsStyle;
    }

    public static function getCodeBlockWrapperMetaDividerStyle() : string
    {
        return self::$_codeBlockWrapperMetaDivider;
    }

    public static function getCodeBlockWrapperCopyTextStyle() : string
    {
        return self::$_codeBlockWrapperCopyTextStyle;
    }

    public static function getLineNumbersStyle() : string
    {
        return self::$_lineNumbersStyle;
    }

    public static function getLineNumberStyle() : string
    {
        return self::$_lineNumberStyle;
    }
}
