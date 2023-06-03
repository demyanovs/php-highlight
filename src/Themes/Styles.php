<?php
/**
 * Class for replacing css file
 */

namespace Demyanovs\PHPHighlight\Themes;

class Styles
{
    private static string $codeHighlighterStyle = "display: block; padding: 5px; border: 1px solid #ddd; border-radius: 3px; font-size: 12px; font-family: 'SFMono-Regular',Consolas,'Liberation Mono',Menlo,Courier,monospace; overflow-x: auto; overflow-y: hidden; white-space: pre-wrap; tab-size: 4;";

    private static string $codeBlockWrapperMetaStyle = 'padding: 5px 10px; border: 1px solid #ddd; border-bottom: none; background-color: #eee; border-top-left-radius: 4px; border-top-right-radius: 4px;';

    private static string $codeBlockWrapperInfoStyle = 'height: 23px; line-height: 23px; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;';

    private static string $codeBlockWrapperActionsStyle = 'float: left; line-height: 22px; margin-right: 10px;';

    private static string $codeBlockWrapperMetaDivider = 'display: inline-block; width: 1px; height: 15px; margin: 0 3px; vertical-align: middle; background-color: #ddd;';

    private static string $codeBlockWrapperCopyTextStyle = 'font-size: 16px; cursor: pointer;';

    private static string $lineNumbersStyle = 'margin-right: 15px; color: #000; font-weight: normal; float: left;';

    private static string $lineNumberStyle = 'display: block;';

    public static function getCodeHighlighterStyle(): string
    {
        return self::$codeHighlighterStyle;
    }

    public static function getCodeBlockWrapperMetaStyle(): string
    {
        return self::$codeBlockWrapperMetaStyle;
    }

    public static function getCodeBlockWrapperInfoStyle(): string
    {
        return self::$codeBlockWrapperInfoStyle;
    }

    public static function getCodeBlockWrapperActionsStyle(): string
    {
        return self::$codeBlockWrapperActionsStyle;
    }

    public static function getCodeBlockWrapperMetaDividerStyle(): string
    {
        return self::$codeBlockWrapperMetaDivider;
    }

    public static function getCodeBlockWrapperCopyTextStyle(): string
    {
        return self::$codeBlockWrapperCopyTextStyle;
    }

    public static function getLineNumbersStyle(): string
    {
        return self::$lineNumbersStyle;
    }

    public static function getLineNumberStyle(): string
    {
        return self::$lineNumberStyle;
    }
}
