<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Exception\ThemeNotSetException;

/**
 * Interface for syntax highlighters
 */
interface HighlighterInterface
{
    /**
     * Highlight the code text with syntax coloring
     *
     * @throws ThemeNotSetException If theme is not set before highlighting.
     */
    public function highlight(): string;

    /**
     * Set the theme to use for highlighting
     */
    public function setTheme(\Demyanovs\PHPHighlight\Themes\Theme $theme): void;
}

