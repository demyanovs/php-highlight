<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class FarTheme extends Theme
{
    public const TITLE = 'far';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#e0e2e4;',
            '#000080',
            '#888;',
            '#fff; font-weight: bold;',
            '#0ff',
            '#0ff;',
            '#ff0;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#0ff;',
            '#888;',
            '#fbc201;',
            '#fff; font-weight: bold;',
            '#ff0;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#fff; font-weight: bold;',
            '#0ff;',
            '#ff0;',
            '#008080;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
