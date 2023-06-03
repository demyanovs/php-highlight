<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class C64Theme extends Theme
{
    public const TITLE = 'c64';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#70A4B2;',
            '#352879',
            '#6C5EB5;',
            '#FFFFFF;',
            '#70A4B2',
            '#B8C76F;',
            '#588D43;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#70A4B2; font-weight;',
            '#9A6759;',
            '#9AD284;',
            '#6C6C6C;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#FFFFFF;',
            '#9AD284;',
            '#70A4B2;',
            '#70A4B2; font-weight: bold;',
            '#B8C76F;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
