<?php

namespace Demyanovs\PHPHighlight\Tests;

use Demyanovs\PHPHighlight\Exception\ThemeNotSetException;
use Demyanovs\PHPHighlight\HighlighterBase;
use Demyanovs\PHPHighlight\HighlighterBash;
use Demyanovs\PHPHighlight\Themes\DefaultTheme;
use PHPUnit\Framework\TestCase;

class HighlighterBaseTest extends TestCase
{
    public function testHighlightWithoutThemeThrowsException(): void
    {
        $highlighter = new HighlighterBash('echo "test"');
        
        $this->expectException(ThemeNotSetException::class);
        $this->expectExceptionMessage('Theme must be set before highlighting');
        
        $highlighter->highlight();
    }

    public function testHighlightWithThemeWorks(): void
    {
        $highlighter = new HighlighterBash('echo "test"');
        $theme = new DefaultTheme();
        $highlighter->setTheme($theme);
        
        $result = $highlighter->highlight();
        
        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    public function testHighlightEmptyTextReturnsEmpty(): void
    {
        $highlighter = new HighlighterBash('');
        $theme = new DefaultTheme();
        $highlighter->setTheme($theme);
        
        $result = $highlighter->highlight();
        
        $this->assertEquals('', $result);
    }

    public function testHighlightWhitespaceOnlyReturnsEmpty(): void
    {
        $highlighter = new HighlighterBash('   ');
        $theme = new DefaultTheme();
        $highlighter->setTheme($theme);
        
        $result = $highlighter->highlight();
        
        $this->assertEquals('', $result);
    }
}

