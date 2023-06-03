<?php

namespace Demyanovs\PHPHighlight\Themes\Dto;

class PHPColorSchemaDto
{
    public function __construct(
        private readonly string $defaultColor,
        private readonly string $commentColor,
        private readonly string $htmlColor,
        private readonly string $keywordColor,
        private readonly string $stringColor,
    ) {
    }

    public function applyColors(): void
    {
        ini_set('highlight.default', $this->defaultColor);
        ini_set('highlight.comment', $this->commentColor);
        ini_set('highlight.html', $this->htmlColor);
        ini_set('highlight.keyword', $this->keywordColor);
        ini_set('highlight.string', $this->stringColor);
    }
}
