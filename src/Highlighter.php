<?php

namespace Demyanovs\PHPHighlight;

use Demyanovs\PHPHighlight\Exception\InvalidLanguageException;
use Demyanovs\PHPHighlight\Exception\InvalidThemeException;
use Demyanovs\PHPHighlight\Exception\ThemeNotSetException;
use Demyanovs\PHPHighlight\Themes\DefaultTheme;
use Demyanovs\PHPHighlight\Themes\Theme;
use Demyanovs\PHPHighlight\Themes\ThemePool;

/**
 * PHPHighlight - A PHP syntax highlighting library
 *
 * This class parses HTML text, finds `<pre>` and `<pre><code>` tags with code blocks,
 * and applies syntax highlighting based on the specified language.
 *
 * @example
 * ```php
 * $text = '<pre><code class="language-php" data-file="example.php">
 * <?php
 * echo "Hello, World!";
 * </code></pre>';
 *
 * $highlighter = new Highlighter($text, 'obsidian');
 * echo $highlighter
 *     ->showLineNumbers(true)
 *     ->showActionPanel(true)
 *     ->parse();
 * ```
 * @example
 * ```php
 * // Using custom theme
 * $customTheme = new Theme('myTheme', $defaultSchema, $phpSchema, $xmlSchema);
 * $highlighter = new Highlighter($text, 'myTheme', [$customTheme]);
 * ```
 * @note Limitations and Considerations:
 * - Blocks without data-lang attribute use PHP highlighting by default.
 * - Empty code blocks are automatically skipped
 * - File paths (data-file) are sanitized and limited to 255 characters for security
 * - Unknown themes fall back to default theme silently
 * - For languages without specific highlighter (bash, xml, html), uses PHP highlighter
 *   which provides basic syntax highlighting
 * - Language names are case-insensitive and normalized (e.g., 'JS' → 'javascript')
 * - HTML attributes are parsed using DOMDocument with regex fallback
 * - Large code blocks may impact performance
 * - Line numbers are not displayed for single-line code blocks
 * - Action panel only appears when both showActionPanel is true AND data-file is provided
 */
class Highlighter
{
    private const PATTERN_PRE_TAG = '/<pre([^>]*)>(.*?)<\/pre>/ism';
    private const PATTERN_PRE_CODE_TAG = '/<pre([^>]*)><code([^>]*)>(.*?)<\/code><\/pre>/ism';
    private const PATTERN_QUOTED_ATTR = '/data-([a-zA-Z0-9_-]+)\s*=\s*(["\'])((?:(?!\2).)*)\2/';
    private const PATTERN_UNQUOTED_ATTR = '/data-([a-zA-Z0-9_-]+)\s*=\s*([^\s>]+)/';

    public const PHP_OPEN_TAG = '<?php';
    public const PHP_OPEN_TAG_ESCAPED = '&lt;?php';

    protected string $text;

    private bool $showLineNumbers = true;

    private bool $showActionPanel = true;

    private Theme $theme;

    private ThemePool $themePool;

    private CodeBlockWrapper $codeBlockWrapper;

    /**
     * @param string  $text         HTML text containing `<pre>` or `<pre><code>` tags with code blocks
     * @param string  $themeTitle   Theme name (defaults to 'default' if empty)
     * @param Theme[] $customThemes Custom Theme instances to register
     *
     * @throws InvalidThemeException If customThemes contains non-Theme instances.
     * @throws ThemeNotSetException If themeTitle is invalid.
     */
    public function __construct(string $text, string $themeTitle = '', array $customThemes = [])
    {
        foreach ($customThemes as $theme) {
            if (!($theme instanceof Theme)) {
                throw new InvalidThemeException('All custom themes must be instances of ' . Theme::class);
            }
        }

        $this->text = str_replace(self::PHP_OPEN_TAG, self::PHP_OPEN_TAG_ESCAPED, $text);
        $this->themePool = new ThemePool($customThemes);
        $this->theme = $this->themePool->getByTitle($themeTitle ?: DefaultTheme::TITLE);
        $this->codeBlockWrapper = new CodeBlockWrapper($this->showLineNumbers, $this->showActionPanel, $this->theme);
    }

    /**
     * Parse and highlight all code blocks in the text
     *
     * Finds all `<pre>` and `<pre><code>` tags and applies syntax highlighting based on `data-lang` attribute.
     * Supports attributes: `data-lang`, `data-file`, `data-theme`
     * Also supports `class="language-*"` attribute on `<code>` tag (common in Markdown output)
     *
     * @return string Processed HTML with highlighted code blocks, or original text if no matches found
     *
     * @note Empty blocks are skipped. Blocks without data-lang use PHP highlighting by default.
     */
    public function parse(): string
    {
        // First process <pre><code> tags (more specific pattern)
        $text = preg_replace_callback(
            self::PATTERN_PRE_CODE_TAG,
            [$this, 'processPreCodeTag'],
            $this->text,
        );

        // Then process remaining <pre> tags
        return preg_replace_callback(
            self::PATTERN_PRE_TAG,
            [$this, 'processPreTag'],
            $text,
        );
    }

    /**
     * Process a single <pre><code> tag match (common in Markdown output)
     *
     * @param array<int, string> $matches Regex matches from preg_replace_callback
     *
     * @return string Processed HTML
     */
    private function processPreCodeTag(array $matches): string
    {
        $preAttributes = $matches[1] ?? '';
        $codeAttributes = $matches[2] ?? '';
        $block = isset($matches[3]) ? trim($matches[3]) : '';

        if (empty($block)) {
            return '';
        }

        $preData = $this->parseAttributes($preAttributes);
        $codeData = $this->parseAttributes($codeAttributes);

        $lang = $this->extractLanguageFromClass($codeData['class'] ?? '');

        // Prefer data-lang from <pre>, then from <code>, then from class
        $lang = $preData['lang'] ?? $codeData['lang'] ?? $lang;
        $file = $preData['file'] ?? $codeData['file'] ?? '';
        $themeName = $preData['theme'] ?? $codeData['theme'] ?? '';

        $lang = LanguageNormalizer::normalize($lang);
        $file = $this->sanitizeFilePath($file);

        if (empty($lang)) {
            $lang = 'php';
        }

        return $this->parseBlock($block, $lang, $file, $themeName);
    }

    /**
     * Extract language from class attribute (e.g., "language-php" -> "php")
     */
    private function extractLanguageFromClass(string $class): string
    {
        if (preg_match('/language-([a-zA-Z0-9_-]+)/', $class, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Process a single <pre> tag match
     *
     * @param array<int, string> $matches Regex matches from preg_replace_callback
     */
    private function processPreTag(array $matches): string
    {
        $attributesString = $matches[1] ?? '';
        $block = isset($matches[2]) ? trim($matches[2]) : '';

        if (empty($block)) {
            return '';
        }

        $data = $this->parseAttributes($attributesString);
        $lang = LanguageNormalizer::normalize($data['lang'] ?? '');
        $file = $this->sanitizeFilePath($data['file'] ?? '');
        $themeName = $data['theme'] ?? '';

        if (empty($lang)) {
            $lang = 'php';
        }

        return $this->parseBlock($block, $lang, $file, $themeName);
    }

    /**
     * Parse HTML attributes from a string using DOMDocument for reliability
     *
     * @return array<string, string> Associative array of attribute names and values
     */
    private function parseAttributes(string $attributesString): array
    {
        if (empty(trim($attributesString))) {
            return [];
        }

        // Try to use DOMDocument for reliable parsing
        try {
            // Wrap in a temporary tag to make it valid HTML
            $html = '<div ' . $attributesString . '></div>';

            // Suppress warnings for invalid HTML
            $previousErrorReporting = error_reporting(E_ALL & ~E_WARNING);
            $dom = new \DOMDocument();
            $loaded = @$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            error_reporting($previousErrorReporting);

            if ($loaded) {
                $xpath = new \DOMXPath($dom);
                $nodes = $xpath->query('//div[@*]');

                if ($nodes->length > 0) {
                    $node = $nodes->item(0);
                    if ($node instanceof \DOMElement) {
                        $attributes = [];
                        foreach ($node->attributes as $attr) {
                            $name = $attr->nodeName;
                            $value = $attr->nodeValue;
                            // Extract data-* attributes and class attribute (for language detection)
                            if (str_starts_with($name, 'data-')) {
                                $attributes[substr($name, 5)] = $value;
                            } elseif ($name === 'class') {
                                $attributes['class'] = $value;
                            }
                        }

                        return $attributes;
                    }
                }
            }
        } catch (\Throwable) {
            // Fall through to regex fallback
        }

        // Fallback to regex parsing if DOMDocument fails
        return $this->parseAttributesWithRegex($attributesString);
    }

    /**
     * Fallback method to parse attributes using regex
     *
     * @return array<string, string> Associative array of attribute names and values
     */
    private function parseAttributesWithRegex(string $attributesString): array
    {
        $data = [];

        if (preg_match_all(self::PATTERN_QUOTED_ATTR, $attributesString, $quotedMatches, PREG_SET_ORDER)) {
            foreach ($quotedMatches as $match) {
                $attrName = $match[1];
                $attrValue = $match[3];
                $data[$attrName] = html_entity_decode($attrValue, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }

        // Pattern for unquoted attributes: data-lang=php
        // Only match if not already found in quoted matches
        if (preg_match_all(self::PATTERN_UNQUOTED_ATTR, $attributesString, $unquotedMatches, PREG_SET_ORDER)) {
            foreach ($unquotedMatches as $match) {
                $attrName = $match[1];
                // Only add if not already parsed as quoted attribute
                if (!isset($data[$attrName])) {
                    $attrValue = $match[2];
                    $data[$attrName] = html_entity_decode($attrValue, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
        }

        // Also extract class attribute for language detection (e.g., class="language-xml")
        if (preg_match('/class\s*=\s*(["\'])((?:(?!\1).)*)\1/', $attributesString, $classMatches)) {
            $data['class'] = $classMatches[2];
        } elseif (preg_match('/class\s*=\s*([^\s>]+)/', $attributesString, $classMatches)) {
            $data['class'] = html_entity_decode($classMatches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $data;
    }

    /**
     * Parse and highlight a code block
     *
     * @throws InvalidLanguageException If language is invalid.
     */
    private function parseBlock(string $block, string $lang, string $filePath = '', string $themeName = ''): string
    {
        $trimmedBlock = trim($block);
        if (empty($trimmedBlock)) {
            return '';
        }

        $lang = LanguageNormalizer::normalize($lang);
        if (empty($lang)) {
            throw new InvalidLanguageException('Language cannot be empty');
        }

        $theme = $this->getTheme($themeName);

        $highlighter = $this->createHighlighter($lang, $trimmedBlock);

        $theme->PHPColorSchemaDto->applyColors();
        $highlighter->setTheme($theme);
        $highlightedBlock = $highlighter->highlight();

        if ($theme !== $this->theme) {
            $this->codeBlockWrapper = new CodeBlockWrapper($this->showLineNumbers, $this->showActionPanel, $theme);
        }

        return $this->codeBlockWrapper->wrap($highlightedBlock, $theme->defaultColorSchema->getBackgroundColor(), $filePath);
    }

    /**
     * Create appropriate highlighter instance based on language
     */
    private function createHighlighter(string $lang, string $block): HighlighterBase
    {
        return HighlighterFactory::create($lang, $block);
    }

    /**
     * Get theme instance (use override if provided, otherwise use default)
     */
    private function getTheme(string $themeName): Theme
    {
        if (!empty($themeName)) {
            try {
                return $this->themePool->getByTitle($themeName);
            } catch (ThemeNotSetException) {
                return $this->theme;
            }
        }

        return $this->theme;
    }

    /**
     * Sanitize file path to prevent XSS attacks
     */
    private function sanitizeFilePath(string $filePath): string
    {
        $sanitized = htmlspecialchars($filePath, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (strlen($sanitized) > 255) {
            $sanitized = substr($sanitized, 0, 252) . '...';
        }

        return $sanitized;
    }

    /**
     * Enable or disable line numbers display
     *
     * @note Line numbers are not shown for single-line code blocks
     */
    public function showLineNumbers(bool $showLineNumbers): self
    {
        $this->showLineNumbers = $showLineNumbers;
        $this->codeBlockWrapper = new CodeBlockWrapper($this->showLineNumbers, $this->showActionPanel, $this->theme);

        return $this;
    }

    /**
     * Enable or disable action panel display
     * Shows file path from data-file attribute at the top of code block.
     *
     * @note Action panel only appears if data-file attribute is present
     */
    public function showActionPanel(bool $showActionPanel): self
    {
        $this->showActionPanel = $showActionPanel;
        $this->codeBlockWrapper = new CodeBlockWrapper($this->showLineNumbers, $this->showActionPanel, $this->theme);

        return $this;
    }
}
