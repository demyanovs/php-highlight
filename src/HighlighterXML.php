<?php

namespace Demyanovs\PHPHighlight;

/**
 * Highlighter for XML and HTML markup
 */
class HighlighterXML extends HighlighterBase
{
    private const PATTERN_XML_TAG = '#&lt;(?!\?)([/!]*?)(.*?)([\s]*?)&gt;#sU';
    private const PATTERN_XML_INFO = '#&lt;([\?])(.*?)([\?])&gt;#sU';
    private const PATTERN_XML_ATTR = "#([^\s=]*?)\s*=\s*(&quot;|')(.*?)(\\2)#isU";

    public function highlight(): string
    {
        $normalized = str_replace(["\r\n", "\r"], "\n", $this->text);
        $byLines = explode("\n", $normalized);
        $lines = [];

        foreach ($byLines as $line) {
            $processedLine = $this->processLine($line);
            $lines[] = $processedLine;
        }

        return implode('<br />', $lines);
    }

    /**
     * Process a single line of XML/HTML
     */
    private function processLine(string $line): string
    {
        if (trim($line) === '') {
            return '';
        }

        // First escape HTML
        $text = htmlspecialchars($line, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $defaultColor = $this->theme->defaultColorSchema->getStringColor();

        // Process XML version/processing instructions first (more specific pattern)
        // Use callback to process attributes inside XML info
        $text = preg_replace_callback(
            self::PATTERN_XML_INFO,
            function ($matches) {
                // Process attributes inside XML info
                $infoContent = $matches[2];
                $infoContent = preg_replace(
                    self::PATTERN_XML_ATTR,
                    sprintf(
                        '<span style="color: %s">\\1</span>=<span style="color: %s">\\2\\3\\4</span>',
                        $this->theme->XMLColorSchemaDto->getXMLAttrNameColor(),
                        $this->theme->XMLColorSchemaDto->getXMLAttrValueColor(),
                    ),
                    $infoContent,
                );

                return sprintf(
                    '<span style="color: %s">&lt;%s%s%s&gt;</span>',
                    $this->theme->XMLColorSchemaDto->getXMLInfoColor(),
                    $matches[1],
                    $infoContent,
                    $matches[3],
                );
            },
            $text,
        );

        // Process XML tags (but skip if already processed as info)
        // PATTERN_XML_TAG already excludes <? so we don't need to check for spans
        $text = preg_replace_callback(
            self::PATTERN_XML_TAG,
            function ($matches) {
                // Process attributes inside the tag content
                $tagContent = $matches[2];
                $tagContent = preg_replace(
                    self::PATTERN_XML_ATTR,
                    sprintf(
                        '<span style="color: %s">\\1</span>=<span style="color: %s">\\2\\3\\4</span>',
                        $this->theme->XMLColorSchemaDto->getXMLAttrNameColor(),
                        $this->theme->XMLColorSchemaDto->getXMLAttrValueColor(),
                    ),
                    $tagContent,
                );

                return sprintf(
                    '<span style="color: %s">&lt;%s%s%s&gt;</span>',
                    $this->theme->XMLColorSchemaDto->getXMLTagColor(),
                    $matches[1],
                    $tagContent,
                    $matches[3],
                );
            },
            $text,
        );

        // Wrap remaining text content (non-highlighted parts) with default color
        // Split by highlighted spans and wrap non-span parts
        // Use non-greedy matching to avoid issues with nested spans
        $parts = preg_split('/(<span[^>]*>.*?<\/span>)/s', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = '';

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }

            // If it's already a span, keep it as-is
            if (preg_match('/^<span[^>]*>/', $part)) {
                $result .= $part;
            } else {
                // Only wrap non-empty, non-whitespace content
                $trimmed = trim($part);
                if (!empty($trimmed)) {
                    $result .= sprintf('<span style="color: %s">%s</span>', $defaultColor, $part);
                } else {
                    // Keep whitespace as-is
                    $result .= $part;
                }
            }
        }

        // If result is empty but text contains spans, return text as-is
        // Otherwise, if result is empty, wrap entire text with default color
        if ($result === '') {
            // Check if text already contains spans (was processed)
            if (preg_match('/<span[^>]*>/', $text)) {
                return $text;
            }

            return sprintf('<span style="color: %s">%s</span>', $defaultColor, $text);
        }

        return $result;
    }
}
