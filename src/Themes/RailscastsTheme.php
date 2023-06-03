<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class RailscastsTheme extends Theme
{
    public const TITLE = 'railscasts';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#bababa;',
            '#232323',
            '#bc9458;',
            '#cb7832; font-weight: bold;',
            '#e6e1dc',
            '#a5c261;',
            '#cb7832;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#e8bf6a;',
            '#6d9cbe;',
            '#519f50;',
            '#9b859d;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#e6e1dc;',
            '#bc9458;',
            '#fbc201;',
            '#c26230; font-weight: bold;',
            '#a5c261;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
