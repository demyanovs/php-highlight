<?php

namespace Demyanovs\PHPHighlight\Exception;

/**
 * Exception thrown when an invalid theme is provided or requested
 */
class InvalidThemeException extends \InvalidArgumentException
{
    public function __construct(string $message = 'Invalid theme provided', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

