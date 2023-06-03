<?php

namespace Demyanovs\PHPHighlight;

class HighlighterBash extends HighlighterBase
{
    private static ?self $instance = null;

    /** @var string[] */
    protected array $keywords = [
        'wget',
        'tar',
        'cd',
        'rsync',
        'cp',
        'echo',
        'if',
        'else',
        'then',
        'fi',
        'while',
        'echo',
        '=',
        '==',
        '===',
        'exit',
        'for',
        'done',
        '<',
        '>',
        'read',
        'require',
        'composer',
    ];

    public static function getInstance(string $text): self
    {
        if (self::$instance) {
            self::$instance->setText($text);

            return self::$instance;
        }

        return self::$instance = new self($text);
    }
}
