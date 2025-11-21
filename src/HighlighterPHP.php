<?php

namespace Demyanovs\PHPHighlight;

/**
 * Highlighter for PHP code using PHP's built-in highlight_string function
 */
class HighlighterPHP extends HighlighterBase
{
    private const UNWANTED_PATTERNS = ['&lt;?php&nbsp;', '<code>', '</code>'];

    public function highlight(): string
    {
        // Use PHP's built-in highlight_string function
        $highlighted = highlight_string('<?php ' . trim($this->text), true);

        // Remove unwanted parts from highlight_string output
        $text = str_replace(self::UNWANTED_PATTERNS, '', $highlighted);
        // Remove <code> tags with any attributes
        $text = preg_replace('/<code[^>]*>/', '', $text);

        // Normalize line breaks
        $text = str_replace(PHP_EOL, '<br />', $text);
        $byLines = explode('<br />', $text);

        // Clean up highlight_string output: remove first wrapper line and trailing closing tags
        $lines = $this->cleanHighlightOutput($byLines);

        return implode('<br />', $lines);
    }

    /**
     * Clean up highlight_string output by removing wrapper elements
     *
     * @param array<int, string> $byLines Lines from highlight_string
     *
     * @return array<int, string> Cleaned lines
     */
    private function cleanHighlightOutput(array $byLines): array
    {
        $lines = [];
        $totalLines = count($byLines);

        // Find the range of lines to process (skip leading/trailing empty lines from highlight_string)
        $firstLineIndex = 0;
        $lastLineIndex = $totalLines - 1;

        // Skip leading empty lines before <pre> tag
        for ($i = 0; $i < $totalLines; $i++) {
            $trimmed = trim($byLines[$i]);
            if (str_starts_with($trimmed, '<pre')) {
                $firstLineIndex = $i;
                break;
            }

            if (!empty($trimmed)) {
                $firstLineIndex = $i;
                break;
            }
        }

        // Skip trailing empty lines after </pre> tag
        for ($i = $totalLines - 1; $i >= 0; $i--) {
            $trimmed = trim($byLines[$i]);
            if (str_ends_with($trimmed, '</pre>')) {
                $lastLineIndex = $i;
                break;
            }

            if (!empty($trimmed)) {
                $lastLineIndex = $i;
                break;
            }
        }

        // Helper function to check if a line is empty (including HTML tags only)
        $isEmptyLine = static function (string $line): bool {
            // Remove all HTML tags and check if remaining content is empty
            $content = strip_tags($line);

            return trim($content) === '';
        };

        for ($i = $firstLineIndex; $i <= $lastLineIndex; $i++) {
            $line = $byLines[$i];
            $trimmed = trim($line);
            $wasPreTagLine = false;
            $wasClosingPreTagLine = false;

            // Remove <pre> opening tag from first processed line
            if ($i === $firstLineIndex && str_starts_with($trimmed, '<pre')) {
                $wasPreTagLine = true;
                $line = preg_replace('/^<pre[^>]*>/', '', $line);
                $trimmed = trim($line);
            }

            // Remove </pre> closing tag from last processed line
            if ($i === $lastLineIndex && str_ends_with($trimmed, '</pre>')) {
                $wasClosingPreTagLine = true;
                $line = preg_replace('/<\/pre>$/', '', $line);
                $trimmed = trim($line);
            }

            // Skip lines that became empty only after removing wrapper tags
            // These are artifacts from highlight_string, not real empty lines from the code
            // Check if line is empty (including HTML tags only)
            if ($isEmptyLine($line)) {
                if ($wasPreTagLine || $wasClosingPreTagLine) {
                    // Skip this line - it's just a wrapper tag artifact
                    continue;
                }

                // Preserve real empty lines from the original code
                $lines[] = '';
                continue;
            }

            $lines[] = $line;
        }

        // Remove leading and trailing empty lines that are artifacts from highlight_string
        while (!empty($lines) && $isEmptyLine($lines[0])) {
            array_shift($lines);
        }

        while (!empty($lines) && $isEmptyLine($lines[count($lines) - 1])) {
            array_pop($lines);
        }

        return $lines;
    }
}
