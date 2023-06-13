<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class DefaultTheme extends Theme
{
    public const TITLE = 'default';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#000;',
            '#f8f8f8',
            '#7f7f7f;',
            '#cb7832; font-weight: bold;',
            '#cb7832',
            '#000;',
            '#cb7832;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#0000BB;',
            '#FF8000;',
            '#fbc201;',
            '#007700; font-weight: bold;',
            '#DD0000;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#008000;',
            '#7D9029;',
            '#BA2121;',
            '#BC7A00;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
