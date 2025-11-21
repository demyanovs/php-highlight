<?php

namespace Demyanovs\PHPHighlight\Exception;

/**
 * Exception thrown when an invalid or empty language is provided
 */
class InvalidLanguageException extends \InvalidArgumentException
{
    public function __construct(string $message = 'Language cannot be empty', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
