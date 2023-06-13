<?php

namespace Demyanovs\PHPHighlight\Tests;

use Demyanovs\PHPHighlight\Highlighter;
use Demyanovs\PHPHighlight\Themes\Exception\UnknownThemeException;
use Demyanovs\PHPHighlight\Themes\ObsidianTheme;
use PHPUnit\Framework\TestCase;

class HighlighterTest extends TestCase
{
    private Highlighter $highlighter;

    protected function setUp(): void
    {
        $this->highlighter = new Highlighter($this->getText(), ObsidianTheme::TITLE);
    }

    public function testParseRowsNumbersDisplayed(): void
    {
        $output = $this->highlighter->parse();

        $this->assertStringContainsString(
            '<span class="line-number" style="display: block;; color: #e0e2e4;">32</span>',
            $output,
        );
    }

    public function testParseRowsNumbersNotDisplayed(): void
    {
        $this->highlighter->showLineNumbers(false);
        $output = $this->highlighter->parse();

        $this->assertStringNotContainsString(
            '<span class="line-number" style="display: block;; color: #e0e2e4;">32</span>',
            $output,
        );
    }

    public function testParseActionPanelDisplayed(): void
    {
        $output = $this->highlighter->parse();

        $this->assertStringContainsString(
            '<span>php-highlight/examples/index.php</span>',
            $output,
        );
    }

    public function testParseActionPanelNotDisplayed(): void
    {
        $this->highlighter->showActionPanel(false);
        $output = $this->highlighter->parse();

        $this->assertStringNotContainsString(
            '<span>php-highlight/examples/index.php</span>',
            $output,
        );
    }

    public function testDefaultThemeForNonExistentTitle(): void
    {
        $this->expectException(UnknownThemeException::class);

        new Highlighter($this->getText(), 'nonexistent');
    }

    private function getText(): string
    {
        return '
<h2>PHP</h2>
<pre data-file="php-highlight/examples/index.php" data-lang="php">
&lt;?php
abstract class AbstractClass
{
    /**
     * Our abstract method only needs to define the required arguments
     */
    abstract protected function prefixName(string $name): string;
}

class ConcreteClass extends AbstractClass
{
    /**
     * Our child class may define optional arguments not in the parent\'s signature
     */
    public function prefixName(string $name): string
    {
        $prefix = "";
        if ($name === "Pacman") {
            $prefix = "Mr.";
        } elseif ($name === "Pacwoman") {
            $prefix = "Mrs.";
        } else {
            
        }
        
        return $prefix . " " . $name;
    }
}

$class = new ConcreteClass;
echo $class->prefixName("Pacman"), "\n";
echo $class->prefixName("Pacwoman"), "\n";
</pre>';
    }
}
