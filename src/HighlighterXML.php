<?php

namespace Demyanovs\PHPHighlight;

class HighlighterXML extends HighlighterBase
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
        $text = htmlspecialchars($this->text);
        // Brackets
        $text = preg_replace(
            '#&lt;([/]*?)(.*)([\s]*?)&gt;#sU',
            sprintf(
                '<span style="color: %s">&lt;\\1\\2\\3&gt;</span>',
                $this->theme->XMLColorSchemaDto->getXMLTagColor(),
            ),
            $text,
        );
        // Xml version
        $text = preg_replace(
            '#&lt;([\?])(.*)([\?])&gt;#sU',
            sprintf(
                '<span style="color: %s">&lt;\\1\\2\\3&gt;</span>',
                $this->theme->XMLColorSchemaDto->getXMLInfoColor(),
            ),
            $text,
        );
        // Attributes
        $text = preg_replace(
            "#([^\s]*?)\=(&quot;|')(.*)(&quot;|')#isU",
            sprintf(
                '<span style="color: %s">\\1</span>=<span style="color: %s">\\2\\3\\4</span>',
                $this->theme->XMLColorSchemaDto->getXMLAttrNameColor(),
                $this->theme->XMLColorSchemaDto->getXMLAttrValueColor(),
            ),
            $text,
        );

        return sprintf(
            '<span style="color: %s">%s</span>',
            $this->theme->defaultColorSchema->getStringColor(),
            $text,
        );
    }
}
