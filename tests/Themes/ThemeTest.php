<?php

namespace Demyanovs\PHPHighlight\Tests\Themes;

use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Theme;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    public function testGetTitle(): void
    {
        $themeTitle = 'myTheme';

        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '',
            '',
            '',
            '',
            '',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '',
            '',
            '',
            '',
        );

        $theme = new Theme(
            $themeTitle,
            $defaultColorSchemaDto,
            $PHPColorSchemaDto,
            $XMLColorSchemaDto,
        );

        $this->assertEquals($themeTitle, $theme->getTitle());
    }
}
