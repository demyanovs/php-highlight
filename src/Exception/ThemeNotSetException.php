<?php

namespace Demyanovs\PHPHighlight\Exception;

/**
 * Exception thrown when highlighting is attempted without setting a theme first
 */
class ThemeNotSetException extends \RuntimeException
{
    public function __construct(string $message = 'Theme must be set before highlighting. Call setTheme() first.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
