# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2019-05-20
- Initial release

## [1.0.1] - 2019-06-03
- Replaced theme css by class

## [1.1.0] - 2019-09-14
- Fixed htmlspecialchars
- Fixed showing line number if there is only one line
- Added themes: obsidian, far, vs2015
- Changed examples
- Other code changes and small fixes

## [1.1.1] - 2020-01-15
- Added c64 theme

## [2.0.0] - 2023-06-03
- Completely redesigned project structure 
- Updated syntaxes to PHP 8.1
- Updated examples
- 
## [2.1.0] - 2023-06-13
- Set PHP minimum version in composer
- Throws UnknownThemeException
- Added tests

## [3.0.0] - 2025-11-21

### Added
- Support for `<pre><code>` pattern (in addition to `<pre>`) for better Markdown compatibility
- Support for `class="language-*"` attribute on `<code>` tag for language detection
- Fluent interface for `showLineNumbers()` and `showActionPanel()` methods
- `HighlighterFactory` class for creating highlighter instances based on language
- `CodeBlockWrapper` class for separating presentation logic from highlighting
- `LanguageNormalizer` class for normalizing language identifiers with aliases support
- Custom exceptions: `InvalidLanguageException`, `InvalidThemeException`, `ThemeNotSetException`
- PHP as default language for code blocks without specified language
- Comprehensive test suite

### Changed
- **BREAKING**: Removed Singleton pattern from all highlighter classes (`HighlighterPHP`, `HighlighterXML`, `HighlighterBash`)
- **BREAKING**: Made `HighlighterBase` an abstract class (cannot be instantiated directly)
- **BREAKING**: Added `ext-dom` PHP extension requirement (previously optional with regex fallback)
- Improved HTML attribute parsing using `DOMDocument` with regex fallback
- Enhanced syntax highlighting logic in `HighlighterBase`
- Improved XML/HTML highlighting: fixed line-by-line processing, proper attribute highlighting
- Updated PHPDoc comments throughout the codebase

### Fixed
- Fixed issue with extra empty lines at the beginning and end of code blocks
- Fixed line numbering
