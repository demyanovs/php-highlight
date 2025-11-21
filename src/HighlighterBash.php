<?php

namespace Demyanovs\PHPHighlight;

/**
 * Highlighter for Bash shell scripts
 */
class HighlighterBash extends HighlighterBase
{
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
}
