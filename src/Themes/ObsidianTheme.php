<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class ObsidianTheme extends Theme
{
    public const TITLE = 'obsidian';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#e0e2e4;',
            '#282b2e',
            '#818e96;',
            '#93c763; font-weight: bold;',
            '#e6e1dc',
            '#e0e2e4;',
            '#ec7600;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#e0e2e4;',
            '#818e96;',
            '#fbc201;',
            '#93c763; font-weight: bold;',
            '#ec7600;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#8cbbad; font-weight: bold;',
            '#6d9cbe;',
            '#ec7600;',
            '#557182;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
