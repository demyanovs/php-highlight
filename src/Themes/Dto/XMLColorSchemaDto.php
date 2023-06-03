<?php

namespace Demyanovs\PHPHighlight\Themes\Dto;

class XMLColorSchemaDto
{
    public function __construct(
        private readonly string $XMLTagColor,
        private readonly string $XMLAttrNameColor,
        private readonly string $XMLAttrValueColor,
        private readonly string $XMLInfoColor,
    ) {
    }

    public function getXMLTagColor(): string
    {
        return $this->XMLTagColor;
    }

    public function getXMLAttrNameColor(): string
    {
        return $this->XMLAttrNameColor;
    }

    public function getXMLAttrValueColor(): string
    {
        return $this->XMLAttrValueColor;
    }

    public function getXMLInfoColor(): string
    {
        return $this->XMLInfoColor;
    }
}
