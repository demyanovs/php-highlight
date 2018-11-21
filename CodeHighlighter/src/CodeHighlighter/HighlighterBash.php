<?php

namespace CodeHighlighter;

use CodeHighlighter\Traits\SetOptions;

class HighlighterBash extends HighlighterAbstract {

    use SetOptions;

    private static $_instance;

    /**
     * @var array
     */
    private $_keywords = ['wget', 'tar', 'cd', 'rsync', 'cp', 'echo', 'if', 'else', 'then', 'fi', 'while', 'echo', '=', '==', '==='];

    /**
     * @var string
     */
    private $_flagColor = '#fa6e6e';

    public static function getInstance(string $text)
    {
        self::setText($text);
        if (self::$_instance) {
            return self::$_instance;
        }
        return self::$_instance = new self($text);
    }

    /**
     * @return mixed|string
     */
    public function highlight()
    {
        $by_lines = explode(PHP_EOL, self::$_text);
        $lines = [];
        $i = 1;
        foreach ($by_lines as $key => $line) {
            // Comment line
            if ($this->isCommentLine($line)) {
                $lines[$key] = $this->setLineNumber($i).self::colorWord($line, $line, self::getCommentColor());
                $i++;
                continue;
            }
            $words = array_unique(explode(' ', $line));
            foreach ($words as $word) {
                $word = trim($word);
                if (in_array($word, $this->_keywords)) {
                    $line = self::colorWord($word, $line, self::getKeywordColor());
                } elseif ($this->isFlag($word)) {
                    $line = self::colorWord($word, $line, self::getFlagColor());
                } elseif ($this->isVariable($word)) {
                    $line = self::colorWord($word, $line, self::getVariableColor());
                } else {
                    $line = self::colorWord($word, $line, self::getStringColor());
                }
                $lines[$key] = $this->setLineNumber($i).$line;
            }
            $i++;
        }

        return $text = implode("<br />", $lines);
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isFlag(string $word): bool
    {
        if (substr($word, 0, 1) == "-") {
            return true;
        }
        return false;
    }

    private function isCommentLine($word)
    {
        if (substr($word, 0, 1) == "#") {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    private function getFlagColor(): string
    {
        return $this->_flagColor;
    }

    /**
     * @param string $color
     */
    private function setFlagColor(string $color)
    {
        $this->_flagColor = $color;
    }
}