<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class Theme
{
    public function __construct(
        private readonly string      $title,
        public DefaultColorSchemaDto $defaultColorSchema,
        public PHPColorSchemaDto     $PHPColorSchemaDto,
        public XMLColorSchemaDto     $XMLColorSchemaDto,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
