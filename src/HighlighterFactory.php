<?php

namespace Demyanovs\PHPHighlight;

/**
 * Factory for creating highlighter instances based on language
 */
class HighlighterFactory
{
    /**
     * Create appropriate highlighter instance based on language
     */
    public static function create(string $lang, string $block): HighlighterBase
    {
        return match ($lang) {
            'bash' => new HighlighterBash($block),
            'xml', 'html' => new HighlighterXML($block),
            default => self::createPHPHighlighter($block), // Use base logic for all other languages
        };
    }

    /**
     * Create PHP highlighter (used for PHP, JavaScript, Go, etc.)
     */
    private static function createPHPHighlighter(string $block): HighlighterPHP
    {
        // Restore PHP tags if they were escaped
        $block = str_replace(Highlighter::PHP_OPEN_TAG_ESCAPED, Highlighter::PHP_OPEN_TAG, $block);

        return new HighlighterPHP($block);
    }
}
