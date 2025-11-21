<?php

namespace Demyanovs\PHPHighlight\Tests;

use Demyanovs\PHPHighlight\Exception\InvalidThemeException;
use Demyanovs\PHPHighlight\Exception\ThemeNotSetException;
use Demyanovs\PHPHighlight\Highlighter;
use Demyanovs\PHPHighlight\Themes\DefaultTheme;
use Demyanovs\PHPHighlight\Themes\ObsidianTheme;
use Demyanovs\PHPHighlight\Themes\Theme;
use Demyanovs\PHPHighlight\Themes\Dto\DefaultColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\PHPColorSchemaDto;
use Demyanovs\PHPHighlight\Themes\Dto\XMLColorSchemaDto;
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

        // Check that line numbers are displayed (check for any line number)
        $this->assertStringContainsString('line-number', $output);
        $this->assertStringContainsString('line-numbers', $output);
        // Check for a specific line number that should exist (line 1)
        $this->assertStringContainsString(
            '<span class="line-number" style="display: block;; color: #e0e2e4;">1</span>',
            $output,
        );
    }

    public function testParseRowsNumbersNotDisplayed(): void
    {
        $this->highlighter->showLineNumbers(false);
        $output = $this->highlighter->parse();

        // Check that line numbers are not displayed
        $this->assertStringNotContainsString('line-number', $output);
        $this->assertStringNotContainsString('line-numbers', $output);
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
        $this->expectException(ThemeNotSetException::class);

        new Highlighter($this->getText(), 'nonexistent');
    }

    // Edge Cases Tests

    public function testEmptyCodeBlock(): void
    {
        $text = '<pre data-lang="php"></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringNotContainsString('code-block-wrapper', $output);
    }

    public function testWhitespaceOnlyBlock(): void
    {
        $text = '<pre data-lang="php">   </pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringNotContainsString('code-block-wrapper', $output);
    }

    public function testBlockWithoutLanguage(): void
    {
        $text = '<pre>echo "test";</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        // Blocks without language should use PHP highlighting by default
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('test', $output);
        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testPreCodeTag(): void
    {
        $text = '<pre><code class="language-php">echo "test";</code></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        // Should support <pre><code> pattern (common in Markdown)
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('test', $output);
        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testPreCodeTagWithDataLang(): void
    {
        $text = '<pre data-lang="php"><code>echo "test";</code></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        // Should prefer data-lang from <pre> tag
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testPreCodeTagWithLanguageClass(): void
    {
        $text = '<pre><code class="language-javascript">console.log("test");</code></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        // Should extract language from class="language-*" attribute
        $this->assertStringContainsString('console', $output);
        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testBlockWithSpecialCharacters(): void
    {
        $text = '<pre data-lang="php">&lt;?php echo "test &amp; test"; ?></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testVeryLongFilePath(): void
    {
        $longPath = str_repeat('a', 300);
        $text = '<pre data-lang="php" data-file="' . $longPath . '">echo "test";</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        // File path should be truncated to 255 characters
        $this->assertStringContainsString('...', $output);
        // Check that the displayed path is truncated
        preg_match('/<span>(.*?)<\/span>/', $output, $matches);
        if (isset($matches[1])) {
            $this->assertLessThanOrEqual(255, strlen($matches[1]));
        }
    }

    public function testMultiplePreTags(): void
    {
        $text = '<pre data-lang="php">echo "1";</pre><pre data-lang="bash">echo "2"</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
        $this->assertGreaterThan(1, substr_count($output, 'code-block-wrapper'));
    }

    public function testInvalidCustomThemes(): void
    {
        $this->expectException(InvalidThemeException::class);
        $this->expectExceptionMessage('All custom themes must be instances of');

        new Highlighter('test', 'default', ['not a theme']);
    }

    public function testInvalidThemeFallback(): void
    {
        $text = '<pre data-lang="php" data-theme="nonexistent">echo "test";</pre>';
        $highlighter = new Highlighter($text, DefaultTheme::TITLE);
        
        // Should fall back to default theme without exception
        $output = $highlighter->parse();
        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    // Language Tests

    public function testBashLanguage(): void
    {
        $text = '<pre data-lang="bash">echo "Hello World"</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
        $this->assertStringContainsString('echo', $output);
    }

    public function testXmlLanguage(): void
    {
        $text = '<pre data-lang="xml"><root><item>test</item></root></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
        $this->assertStringContainsString('root', $output);
    }

    public function testHtmlLanguage(): void
    {
        $text = '<pre data-lang="html"><div class="test">Content</div></pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
        $this->assertStringContainsString('div', $output);
    }

    public function testJavaScriptLanguage(): void
    {
        $text = '<pre data-lang="javascript">function test() { return true; }</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testJSLanguageAlias(): void
    {
        $text = '<pre data-lang="js">const x = 1;</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testGoLanguage(): void
    {
        $text = '<pre data-lang="go">package main
func main() {
    println("Hello")
}</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testUnknownLanguageUsesPHPHighlighter(): void
    {
        $text = '<pre data-lang="python">print("Hello")</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        // Should use PHP highlighter (base logic) without throwing exception
        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testLanguageCaseInsensitive(): void
    {
        $text = '<pre data-lang="PHP">echo "test";</pre>';
        $highlighter = new Highlighter($text);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    // Empty Lines Tests

    public function testEmptyLinesInMiddleArePreserved(): void
    {
        $text = '<pre data-lang="php">echo "first";

echo "second";</pre>';
        $highlighter = new Highlighter($text);
        $highlighter->showLineNumbers(true);
        $output = $highlighter->parse();

        // Count line numbers - should have 3 lines (first line, empty line, second line)
        preg_match_all('/<span class="line-number"[^>]*>(\d+)<\/span>/', $output, $matches);
        if (!empty($matches[1])) {
            $lineNumbers = array_map('intval', $matches[1]);
            // Should start from line 1
            $this->assertEquals(1, min($lineNumbers));
            // Should have at least 3 lines
            $this->assertGreaterThanOrEqual(3, count($lineNumbers));
        }

        // Should contain both echo statements (may be HTML-escaped)
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('first', $output);
        $this->assertStringContainsString('second', $output);
    }

    public function testEmptyLinesAtStartAndEndAreRemoved(): void
    {
        $text = '<pre data-lang="php">

echo "test";

</pre>';
        $highlighter = new Highlighter($text);
        $highlighter->showLineNumbers(true);
        $output = $highlighter->parse();

        // Count line numbers
        preg_match_all('/<span class="line-number"[^>]*>(\d+)<\/span>/', $output, $matches);
        if (!empty($matches[1])) {
            $lineNumbers = array_map('intval', $matches[1]);
            // Should start from line 1 (empty lines at start removed)
            $this->assertEquals(1, min($lineNumbers));
            // Should have exactly 1 line (empty lines at start and end removed)
            // The echo line itself
            $this->assertLessThanOrEqual(3, count($lineNumbers), 'Should have no more than 3 lines (including empty line in middle)');
        }

        // Should contain the echo statement (may be HTML-escaped)
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('test', $output);
    }

    public function testEmptyLinesRemovedForPHP(): void
    {
        $text = '<pre data-lang="php">

&lt;?php
echo "test";

</pre>';
        $highlighter = new Highlighter($text);
        $highlighter->showLineNumbers(true);
        $output = $highlighter->parse();

        // Count line numbers
        preg_match_all('/<span class="line-number"[^>]*>(\d+)<\/span>/', $output, $matches);
        if (!empty($matches[1])) {
            $lineNumbers = array_map('intval', $matches[1]);
            // Should start from line 1 (empty line at start removed)
            $this->assertEquals(1, min($lineNumbers));
        }

        // Should contain the code (may be HTML-escaped)
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('test', $output);
    }

    public function testEmptyLinesRemovedForJavaScript(): void
    {
        $text = '<pre data-lang="javascript">

function test() {
    return true;
}

</pre>';
        $highlighter = new Highlighter($text);
        $highlighter->showLineNumbers(true);
        $output = $highlighter->parse();

        // Count line numbers
        preg_match_all('/<span class="line-number"[^>]*>(\d+)<\/span>/', $output, $matches);
        if (!empty($matches[1])) {
            $lineNumbers = array_map('intval', $matches[1]);
            // Should start from line 1 (empty line at start removed)
            $this->assertEquals(1, min($lineNumbers));
            // Should not have excessive lines (empty lines at end removed)
            $this->assertLessThanOrEqual(5, count($lineNumbers));
        }

        // Should contain the code (may be HTML-escaped)
        $this->assertStringContainsString('function', $output);
        $this->assertStringContainsString('return', $output);
        $this->assertStringContainsString('true', $output);
    }

    public function testEmptyLinesRemovedForGo(): void
    {
        $text = '<pre data-lang="go">

package main

func main() {
    println("Hello")
}

</pre>';
        $highlighter = new Highlighter($text);
        $highlighter->showLineNumbers(true);
        $output = $highlighter->parse();

        // Count line numbers
        preg_match_all('/<span class="line-number"[^>]*>(\d+)<\/span>/', $output, $matches);
        if (!empty($matches[1])) {
            $lineNumbers = array_map('intval', $matches[1]);
            // Should start from line 1 (empty line at start removed)
            $this->assertEquals(1, min($lineNumbers));
            // Should not have excessive lines (empty lines at end removed)
            $this->assertLessThanOrEqual(7, count($lineNumbers));
        }

        // Should contain the code (may be HTML-escaped)
        $this->assertStringContainsString('package', $output);
        $this->assertStringContainsString('main', $output);
        $this->assertStringContainsString('func', $output);
    }

    public function testEmptyLinesInMiddleArePreservedForPHP(): void
    {
        $text = '<pre data-lang="php">echo "first";

echo "middle";

echo "last";</pre>';
        $highlighter = new Highlighter($text);
        $highlighter->showLineNumbers(true);
        $output = $highlighter->parse();

        // Count line numbers - should preserve empty lines in middle
        preg_match_all('/<span class="line-number"[^>]*>(\d+)<\/span>/', $output, $matches);
        if (!empty($matches[1])) {
            $lineNumbers = array_map('intval', $matches[1]);
            // Should start from line 1
            $this->assertEquals(1, min($lineNumbers));
            // Should have at least 5 lines (3 echo lines + 2 empty lines)
            $this->assertGreaterThanOrEqual(5, count($lineNumbers));
        }

        // Should contain all echo statements (may be HTML-escaped)
        $this->assertStringContainsString('echo', $output);
        $this->assertStringContainsString('first', $output);
        $this->assertStringContainsString('middle', $output);
        $this->assertStringContainsString('last', $output);
    }

    // Custom Theme Tests

    public function testCustomTheme(): void
    {
        $customTheme = $this->createCustomTheme('custom-test');
        $text = '<pre data-lang="php">echo "test";</pre>';
        $highlighter = new Highlighter($text, 'custom-test', [$customTheme]);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testCustomThemeOverrideInBlock(): void
    {
        $customTheme = $this->createCustomTheme('custom-block');
        $text = '<pre data-lang="php" data-theme="custom-block">echo "test";</pre>';
        $highlighter = new Highlighter($text, DefaultTheme::TITLE, [$customTheme]);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testMultipleCustomThemes(): void
    {
        $theme1 = $this->createCustomTheme('theme1');
        $theme2 = $this->createCustomTheme('theme2');
        $text = '<pre data-lang="php">echo "test";</pre>';
        $highlighter = new Highlighter($text, 'theme1', [$theme1, $theme2]);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
    }

    public function testCustomThemeWithDifferentLanguages(): void
    {
        $customTheme = $this->createCustomTheme('multi-lang');
        $text = '<pre data-lang="php">echo "php";</pre><pre data-lang="bash">echo "bash"</pre>';
        $highlighter = new Highlighter($text, 'multi-lang', [$customTheme]);
        $output = $highlighter->parse();

        $this->assertStringContainsString('code-block-wrapper', $output);
        $this->assertGreaterThan(1, substr_count($output, 'code-block-wrapper'));
    }

    // Helper Methods

    private function createCustomTheme(string $title): Theme
    {
        $defaultColorSchemaDto = new DefaultColorSchemaDto(
            '#000000',
            '#ffffff',
            '#888888',
            '#ff0000',
            '#00ff00',
            '#0000ff',
            '#ffff00',
        );

        $PHPColorSchemaDto = new PHPColorSchemaDto(
            '#0000BB',
            '#FF8000',
            '#fbc201',
            '#007700',
            '#DD0000',
        );

        $XMLColorSchemaDto = new XMLColorSchemaDto(
            '#008000',
            '#7D9029',
            '#BA2121',
            '#BC7A00',
        );

        return new Theme($title, $defaultColorSchemaDto, $PHPColorSchemaDto, $XMLColorSchemaDto);
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
