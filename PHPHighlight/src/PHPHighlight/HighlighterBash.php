<?php

namespace PHPHighlight;

class HighlighterBash extends HighlighterBase {

    private static $_instance;

    /**
     * @var array
     */
    protected $_keywords = ['wget', 'tar', 'cd', 'rsync', 'cp', 'echo', 'if', 'else', 'then', 'fi', 'while', 'echo', '=', '==', '===', 'exit', 'for', 'done', '<', '>', 'read'];

    public static function getInstance(string $text)
    {
        self::setText($text);
        if (self::$_instance) {
            return self::$_instance;
        }
        return self::$_instance = new self($text);
    }
}