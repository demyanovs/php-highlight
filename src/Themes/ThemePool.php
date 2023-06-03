<?php

namespace Demyanovs\PHPHighlight\Themes;

class ThemePool
{
    private const THEMES_CLASSES = [
        DefaultTheme::class,
        DarkulaTheme::class,
        RailscastsTheme::class,
        ObsidianTheme::class,
        FarTheme::class,
        VS2015Theme::class,
        C64Theme::class,
    ];

    /**
     * @var Theme[]
     */
    private array $themes;

    /**
     * @param Theme[] $customThemes
     */
    public function __construct(array $customThemes)
    {
        $this->addDefaultThemes();
        $this->addCustomThemes($customThemes);
    }

    public function getByTitle(string $title): Theme
    {
        foreach ($this->themes as $theme) {
            if ($theme->getTitle() === $title) {
                $theme->PHPColorSchemaDto->applyColors();

                return $theme;
            }
        }

        $theme = $this->themes['default'];
        $theme->PHPColorSchemaDto->applyColors();

        return $theme;
    }

    private function addDefaultThemes(): void
    {
        foreach (self::THEMES_CLASSES as $themeClass) {
            if (class_exists($themeClass)) {
                /** @var Theme $theme */
                $theme = new $themeClass();
                $this->themes[$theme->getTitle()] = $theme;
            }
        }
    }

    /**
     * @param Theme[] $customThemes
     */
    private function addCustomThemes(array $customThemes): void
    {
        foreach ($customThemes as $customTheme) {
            $this->themes[] = new $customTheme(
                $customTheme->getTitle(),
                $customTheme->defaultColorSchema,
                $customTheme->PHPColorSchemaDto,
                $customTheme->XMLColorSchemaDto,
            );
        }
    }
}
