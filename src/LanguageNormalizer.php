<?php

namespace Demyanovs\PHPHighlight;

/**
 * Normalizes language identifiers (lowercase, handle aliases)
 */
class LanguageNormalizer
{
    private const LANGUAGE_ALIASES = [
        'js' => 'javascript',
        'htm' => 'html',
        'go-lang' => 'go',
        'sh' => 'bash',
    ];

    /**
     * Normalize language identifier
     *
     * @param string $lang Language identifier
     *
     * @return string Normalized language identifier
     */
    public static function normalize(string $lang): string
    {
        $lang = strtolower(trim($lang));

        return self::LANGUAGE_ALIASES[$lang] ?? $lang;
    }
}
