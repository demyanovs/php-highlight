<?php

namespace Demyanovs\PHPHighlight\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;

class VS2015Theme extends Theme
{
    public const TITLE = 'vs2015';

    public function __construct()
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#DCDCDC;',
            '#1E1E1E',
            '#57A64A;',
            '#569CD6;',
            '#4EC9B0',
            '#D69D85;',
            '#F0F0F0;',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#569CD6; font-weight;',
            '#9CDCFE;',
            '#D69D85;',
            '#9B9B9B;',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#DCDCDC;',
            '#57A64A;',
            '#fbc201;',
            '#569CD6; font-weight: bold;',
            '#D69D85;',
        );

        parent::__construct(self::TITLE, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
    }
}
