<?php

namespace Demyanovs\PHPHighlight;

class HighlighterBash extends HighlighterBase
{
    /** @var self */
    private static $_instance;

    /** @var string[] */
    protected $_keywords = ['wget', 'tar', 'cd', 'rsync', 'cp', 'echo', 'if', 'else', 'then', 'fi', 'while', 'echo', '=', '==', '===', 'exit', 'for', 'done', '<', '>', 'read', 'require', 'composer'];

    public static function getInstance(string $text) : self
    {
        self::setText($text);
        if (self::$_instance) {
            return self::$_instance;
        }

        return self::$_instance = new self($text);
    }
}
