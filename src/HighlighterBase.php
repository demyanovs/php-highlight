<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Exception\ThemeNotSetException;
use Demyanovs\PHPHighlight\Themes\Theme;

/**
 * Base class for syntax highlighters
 *
 * Provides common functionality for highlighting code blocks:
 * - Token extraction and coloring
 * - Keyword, variable, and flag detection
 * - Comment line handling
 * - Theme integration
 *
 * @note This is an abstract class and cannot be instantiated directly.
 *       Use concrete implementations like HighlighterPHP, HighlighterBash, etc.
 */
abstract class HighlighterBase implements HighlighterInterface
{
    private const PATTERN_TOKENS = '/\$[a-zA-Z_][a-zA-Z0-9_]*|-[a-zA-Z0-9-]+|\b[a-zA-Z_][a-zA-Z0-9_]*\b/';

    /** @var string[] */
    protected array $keywords = [];

    protected Theme $theme;

    public function __construct(protected string $text)
    {
    }

    /**
     * Set the theme to use for highlighting
     */
    public function setTheme(Theme $theme): void
    {
        $this->theme = $theme;
    }

    /**
     * Highlight the code text with syntax coloring
     *
     * Colors keywords, variables (starting with $), flags (starting with -), and comment lines (starting with #).
     *
     * @throws ThemeNotSetException If theme is not set before highlighting.
     *
     * @note Empty text returns empty string. Theme must be set before calling.
     */
    public function highlight(): string
    {
        if (!isset($this->theme)) {
            throw new ThemeNotSetException();
        }

        $trimmedText = trim($this->text);
        if (empty($trimmedText)) {
            return '';
        }

        $byLines = explode(PHP_EOL, $this->text);
        $lines   = [];

        foreach ($byLines as $key => $line) {
            // Comment line - process entire line as comment
            if ($this->isCommentLine($line)) {
                $lines[$key] = self::wrapWithColor($line, $this->theme->defaultColorSchema->getCommentColor());
                continue;
            }

            $processedLine = $this->processLine($line);
            $lines[$key] = $processedLine;
        }

        return sprintf(
            '<span style="color:%s">%s</span>',
            $this->theme->defaultColorSchema->getStringColor(),
            implode('<br />', $lines),
        );
    }

    /**
     * Process a single line of code with improved highlighting logic
     */
    private function processLine(string $line): string
    {
        // Extract all potential tokens (words, variables, flags) with their positions
        $tokens = $this->extractTokens($line);

        if (empty($tokens)) {
            return $line;
        }

        // Sort tokens by position (ascending order) to process from start to end
        usort($tokens, static fn ($a, $b) => $a['position'] <=> $b['position']);

        // Build result by processing tokens and keeping track of processed positions
        $result = '';
        $lastPosition = 0;
        $processedPositions = [];

        foreach ($tokens as $token) {
            $position = $token['position'];
            $length = $token['length'];
            $text = $token['text'];

            // Skip if this position overlaps with already processed area
            if ($this->isPositionProcessed($position, $length, $processedPositions)) {
                continue;
            }

            // Add text before this token
            if ($position > $lastPosition) {
                $result .= substr($line, $lastPosition, $position - $lastPosition);
            }

            $color = null;

            // Determine color based on token type (optimized order: most common first)
            if ($this->isVariable($text)) {
                $color = $this->theme->defaultColorSchema->getVariableColor();
            } elseif ($this->isKeyword($text)) {
                $color = $this->theme->defaultColorSchema->getKeywordColor();
            } elseif ($this->isFlag($text)) {
                $color = $this->theme->defaultColorSchema->getFlagColor();
            }

            if ($color !== null) {
                // Add colored token
                $result .= self::wrapWithColor($text, $color);
                // Mark this position as processed
                $processedPositions[] = ['start' => $position, 'end' => $position + $length];
            } else {
                // Add token as-is if no color
                $result .= $text;
            }

            $lastPosition = $position + $length;
        }

        // Add remaining text after last token
        if ($lastPosition < strlen($line)) {
            $result .= substr($line, $lastPosition);
        }

        return $result;
    }

    /**
     * Extract tokens (words, variables, flags) from a line with their positions
     *
     * @return array<int, array{text: string, position: int, length: int}> Array of tokens with positions
     */
    private function extractTokens(string $line): array
    {
        $tokens = [];

        if (preg_match_all(self::PATTERN_TOKENS, $line, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $text = $match[0];
                $position = $match[1];

                if (empty($text)) {
                    continue;
                }

                $tokens[] = [
                    'text' => $text,
                    'position' => $position,
                    'length' => strlen($text), // Position is in bytes, so use strlen
                ];
            }
        }

        return $tokens;
    }

    /**
     * Check if a position in the line has already been processed
     *
     * @param int                                     $position           Start position
     * @param int                                     $length             Length of the token
     * @param array<int, array{start: int, end: int}> $processedPositions Array of processed positions
     *
     * @return bool True if position overlaps with already processed area
     */
    private function isPositionProcessed(int $position, int $length, array $processedPositions): bool
    {
        $end = $position + $length;

        foreach ($processedPositions as $processed) {
            // Check if current position overlaps with processed area
            if (!($end <= $processed['start'] || $position >= $processed['end'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Wrap text with color span
     */
    private static function wrapWithColor(string $text, string $color): string
    {
        return sprintf('<span style="color: %s">%s</span>', $color, htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    /**
     * Update the text to be highlighted
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Check if a word is a variable (starts with $)
     */
    protected function isVariable(string $word): bool
    {
        return str_starts_with($word, '$');
    }

    /**
     * Check if a word is a flag (starts with -)
     */
    protected function isFlag(string $word): bool
    {
        return str_starts_with($word, '-');
    }

    /**
     * Check if a word is a keyword (defined in $keywords array)
     */
    protected function isKeyword(string $word): bool
    {
        return in_array($word, $this->keywords, true);
    }

    /**
     * Check if a line is a comment line (starts with #)
     */
    protected function isCommentLine(string $word): bool
    {
        return str_starts_with($word, '#');
    }
}
