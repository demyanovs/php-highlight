<?php

namespace Demyanovs\PHPHighlight\Tests;

use Demyanovs\PHPHighlight\LanguageNormalizer;
use PHPUnit\Framework\TestCase;

class LanguageNormalizerTest extends TestCase
{
    public function testNormalizeLowercase(): void
    {
        $this->assertEquals('php', LanguageNormalizer::normalize('PHP'));
        $this->assertEquals('javascript', LanguageNormalizer::normalize('JAVASCRIPT'));
        $this->assertEquals('bash', LanguageNormalizer::normalize('BASH'));
    }

    public function testNormalizeWithWhitespace(): void
    {
        $this->assertEquals('php', LanguageNormalizer::normalize('  php  '));
        $this->assertEquals('javascript', LanguageNormalizer::normalize(' javascript '));
    }

    public function testNormalizeAliases(): void
    {
        $this->assertEquals('javascript', LanguageNormalizer::normalize('js'));
        $this->assertEquals('html', LanguageNormalizer::normalize('htm'));
    }

    public function testNormalizeUnknownLanguage(): void
    {
        $this->assertEquals('python', LanguageNormalizer::normalize('python'));
        $this->assertEquals('ruby', LanguageNormalizer::normalize('ruby'));
    }

    public function testNormalizeEmptyString(): void
    {
        $this->assertEquals('', LanguageNormalizer::normalize(''));
        $this->assertEquals('', LanguageNormalizer::normalize('   '));
    }

    public function testNormalizeCaseInsensitiveAliases(): void
    {
        $this->assertEquals('javascript', LanguageNormalizer::normalize('JS'));
        $this->assertEquals('html', LanguageNormalizer::normalize('HTM'));
    }
}
