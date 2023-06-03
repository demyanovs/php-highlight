<?php

namespace Demyanovs\PHPHighlight\Themes\Dto;

class DefaultColorSchemaDto
{
    public function __construct(
        private readonly string $defaultColor,
        private readonly string $backgroundColor,
        private readonly string $commentColor,
        private readonly string $keywordColor,
        private readonly string $variableColor,
        private readonly string $stringColor,
        private readonly string $flagColor,
    ) {
    }

    public function getDefaultColor(): string
    {
        return $this->defaultColor;
    }

    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    public function getCommentColor(): string
    {
        return $this->commentColor;
    }

    public function getKeywordColor(): string
    {
        return $this->keywordColor;
    }

    public function getVariableColor(): string
    {
        return $this->variableColor;
    }

    public function getStringColor(): string
    {
        return $this->stringColor;
    }

    public function getFlagColor(): string
    {
        return $this->flagColor;
    }
}
