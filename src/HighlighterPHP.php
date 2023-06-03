<?php

namespace Demyanovs\PHPHighlight;

class HighlighterPHP extends HighlighterBase
{
    private static ?self $instance = null;

    public static function getInstance(string $text): self
    {
        if (self::$instance) {
            self::$instance->setText($text);

            return self::$instance;
        }

        return self::$instance = new self($text);
    }

    public function highlight(): string
    {
        $text = str_replace(
            ['&lt;?php&nbsp;', '<code>', '</code>'],
            '',
            highlight_string('<?php ' . trim($this->text), true),
        );
        $text = str_replace(PHP_EOL, '<br />', $text);

        $byLines = explode('<br />', $text);
        $lines    = [];
        $i        = 0;
        foreach ($byLines as $key => $line) {
            $i++;
            if ($i === 1) {
                continue;
            }

            // Join first two rows
            if ($i === 2) {
                $line = $byLines[0] . $byLines[1];
            }

            // Join last rows
            if (
                $i === count($byLines) - 3 &&
                $byLines[count($byLines) - 2] === '</span>' &&
                $byLines[count($byLines) - 1] === ''
            ) {
                $lines[] = $byLines[count($byLines) - 4];
                $lines[] = $byLines[$i] . $byLines[count($byLines) - 2] . $byLines[count($byLines) - 1];
                break;
            }

            $lines[$key] = $line;
        }

        return implode('<br />', $lines);
    }
}
