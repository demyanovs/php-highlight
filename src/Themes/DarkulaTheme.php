<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class DarkulaTheme extends Theme
{
    public const TITLE = 'darkula';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#bababa;',
            '#2b2b2b',
            '#7f7f7f;',
            '#cb7832; font-weight: bold;',
            '#cb7832',
            '#6a8759;',
            '#cb7832;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#cb7832;',
            '#bababa;',
            '#6896ba;',
            '#7f7f7f;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#bababa;',
            '#7f7f7f; font-weight: bold;',
            '#fbc201;',
            '#cb7832;',
            '#6a8759;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
