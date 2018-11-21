<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterBash extends HighlighterBase {

    use SetOptions;

    private static $_instance;

    /**
     * @var array
     */
    protected $_keywords = ['wget', 'tar', 'cd', 'rsync', 'cp', 'echo', 'if', 'else', 'then', 'fi', 'while', 'echo', '=', '==', '==='];

    public static function getInstance(string $text)
    {
        self::setText($text);
        if (self::$_instance) {
            return self::$_instance;
        }
        return self::$_instance = new self($text);
    }
}