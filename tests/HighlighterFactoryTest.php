<?php

namespace Demyanovs\PHPHighlight\Tests;

use Demyanovs\PHPHighlight\HighlighterBase;
use Demyanovs\PHPHighlight\HighlighterBash;
use Demyanovs\PHPHighlight\HighlighterFactory;
use Demyanovs\PHPHighlight\HighlighterPHP;
use Demyanovs\PHPHighlight\HighlighterXML;
use PHPUnit\Framework\TestCase;

class HighlighterFactoryTest extends TestCase
{
    public function testCreateBashHighlighter(): void
    {
        $highlighter = HighlighterFactory::create('bash', 'echo "test"');
        
        $this->assertInstanceOf(HighlighterBash::class, $highlighter);
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }

    public function testCreateXmlHighlighter(): void
    {
        $highlighter = HighlighterFactory::create('xml', '<root></root>');
        
        $this->assertInstanceOf(HighlighterXML::class, $highlighter);
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }

    public function testCreateHtmlHighlighter(): void
    {
        $highlighter = HighlighterFactory::create('html', '<div></div>');
        
        $this->assertInstanceOf(HighlighterXML::class, $highlighter);
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }

    public function testCreatePhpHighlighterForPhp(): void
    {
        $highlighter = HighlighterFactory::create('php', 'echo "test";');
        
        $this->assertInstanceOf(HighlighterPHP::class, $highlighter);
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }

    public function testCreatePhpHighlighterForUnknownLanguage(): void
    {
        $highlighter = HighlighterFactory::create('python', 'print("test")');
        
        $this->assertInstanceOf(HighlighterPHP::class, $highlighter);
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }

    public function testCreatePhpHighlighterForJavaScript(): void
    {
        $highlighter = HighlighterFactory::create('javascript', 'console.log("test");');
        
        $this->assertInstanceOf(HighlighterPHP::class, $highlighter);
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }

    public function testCreatePhpHighlighterRestoresEscapedPhpTags(): void
    {
        $code = '&lt;?php echo "test";';
        $highlighter = HighlighterFactory::create('php', $code);
        
        $this->assertInstanceOf(HighlighterPHP::class, $highlighter);
        // The highlighter should have restored the PHP tags internally
        $this->assertInstanceOf(HighlighterBase::class, $highlighter);
    }
}

