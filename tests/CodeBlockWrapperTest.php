<?php

namespace Demyanovs\PHPHighlight\Tests;

use Demyanovs\PHPHighlight\CodeBlockWrapper;
use Demyanovs\PHPHighlight\Themes\DefaultTheme;
use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Theme;
use PHPUnit\Framework\TestCase;

class CodeBlockWrapperTest extends TestCase
{
    private Theme $theme;

    protected function setUp(): void
    {
        $this->theme = new DefaultTheme();
    }

    public function testWrapWithLineNumbers(): void
    {
        $wrapper = new CodeBlockWrapper(true, false, $this->theme);
        $highlightedCode = 'line1<br />line2<br />line3';
        $output = $wrapper->wrap($highlightedCode, '#ffffff');

        $this->assertStringContainsString('line-numbers', $output);
        $this->assertStringContainsString('line-number', $output);
        $this->assertStringContainsString('>1</span>', $output);
        $this->assertStringContainsString('>2</span>', $output);
        $this->assertStringContainsString('>3</span>', $output);
    }

    public function testWrapWithoutLineNumbers(): void
    {
        $wrapper = new CodeBlockWrapper(false, false, $this->theme);
        $highlightedCode = 'line1<br />line2';
        $output = $wrapper->wrap($highlightedCode, '#ffffff');

        $this->assertStringNotContainsString('line-numbers', $output);
        $this->assertStringNotContainsString('line-number', $output);
    }

    public function testWrapWithActionPanel(): void
    {
        $wrapper = new CodeBlockWrapper(false, true, $this->theme);
        $highlightedCode = 'echo "test";';
        $filePath = 'test.php';
        $output = $wrapper->wrap($highlightedCode, '#ffffff', $filePath);

        $this->assertStringContainsString('meta', $output);
        $this->assertStringContainsString('info', $output);
        $this->assertStringContainsString($filePath, $output);
    }

    public function testWrapWithoutActionPanel(): void
    {
        $wrapper = new CodeBlockWrapper(false, false, $this->theme);
        $highlightedCode = 'echo "test";';
        $filePath = 'test.php';
        $output = $wrapper->wrap($highlightedCode, '#ffffff', $filePath);

        $this->assertStringNotContainsString('meta', $output);
        $this->assertStringNotContainsString('info', $output);
        $this->assertStringNotContainsString($filePath, $output);
    }

    public function testWrapWithoutFilePathDoesNotShowActionPanel(): void
    {
        $wrapper = new CodeBlockWrapper(false, true, $this->theme);
        $highlightedCode = 'echo "test";';
        $output = $wrapper->wrap($highlightedCode, '#ffffff', '');

        $this->assertStringNotContainsString('meta', $output);
    }

    public function testWrapSingleLineDoesNotShowLineNumbers(): void
    {
        $wrapper = new CodeBlockWrapper(true, false, $this->theme);
        $highlightedCode = 'single line';
        $output = $wrapper->wrap($highlightedCode, '#ffffff');

        $this->assertStringNotContainsString('line-numbers', $output);
    }

    public function testWrapIncludesCodeBlockWrapper(): void
    {
        $wrapper = new CodeBlockWrapper(false, false, $this->theme);
        $highlightedCode = 'echo "test";';
        $output = $wrapper->wrap($highlightedCode, '#ffffff');

        $this->assertStringContainsString('code-block-wrapper', $output);
        $this->assertStringContainsString('code-highlighter', $output);
        $this->assertStringContainsString('code-block', $output);
    }

    public function testWrapIncludesBackgroundColor(): void
    {
        $wrapper = new CodeBlockWrapper(false, false, $this->theme);
        $highlightedCode = 'echo "test";';
        $bgColor = '#123456';
        $output = $wrapper->wrap($highlightedCode, $bgColor);

        $this->assertStringContainsString('background-color: ' . $bgColor, $output);
    }

    public function testWrapConvertsBrToNewlines(): void
    {
        $wrapper = new CodeBlockWrapper(false, false, $this->theme);
        $highlightedCode = 'line1<br />line2';
        $output = $wrapper->wrap($highlightedCode, '#ffffff');

        // After wrapping, <br /> should be converted to PHP_EOL
        $this->assertStringContainsString('line1', $output);
        $this->assertStringContainsString('line2', $output);
    }
}
