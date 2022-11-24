<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

use Neos\Flow\Annotations as Flow;
use Neos\Utility\Arrays;

class PredictableTextGenerator
{
    /** @phpstan-var  array<int,string> */
    protected array $opener;

    /** @phpstan-var array<int,string> */
    protected array $words;

    /**
     * @param mixed[] $settings
     * @return void
     */
    public function injectSettings(array $settings): void
    {
        $opener = Arrays::getValueByPath($settings, 'dictionary.opener');
        $words = Arrays::getValueByPath($settings, 'dictionary.words');
        $this->opener = is_array($opener) ? array_values($opener) :  [];
        $this->words = is_array($words) ? array_values($words) :  [];
    }

    /**
     * @return string
     */
    public function paragraph(string $seed, int $length, int $deviation, FormatOption ...$formatOptions): string
    {
        $this->initializeDeterministicCoincidence($seed);
        $sentences = $this->sentencesInternal($length, $deviation, ...$formatOptions);
        return implode(' ', $sentences);
    }

    /**
     * @return array<int,string>
     */
    public function sentences(string $seed, int $length, int $deviation, FormatOption ...$formatOptions): array
    {
        $this->initializeDeterministicCoincidence($seed);
        $sentences = $this->sentencesInternal($length, $deviation, ...$formatOptions);
        return $sentences;
    }

    /**
     * @return string
     */
    public function sentence(string $seed, int $length, int $deviation, FormatOption ...$formatOptions): string
    {
        $this->initializeDeterministicCoincidence($seed);
        $result = $this->wordsInternal($length, $deviation, ...$formatOptions);
        return ucfirst(implode(' ', $result));
    }

    /**
     * @return array<int,string>
     */
    public function words(string $seed, int $length, int $deviation): array
    {
        $this->initializeDeterministicCoincidence($seed);
        $result = $this->wordsInternal($length, $deviation);
        return $result;
    }


    protected function initializeDeterministicCoincidence(string $seed): void
    {
        mt_srand(crc32($seed));
    }

    /**
     * @return string[]
     */
    protected function sentencesInternal(int $length, int $deviation, FormatOption ...$formatOptions): array
    {
        if ($deviation > 0) {
            $actualLength = $length + mt_rand(-1 * $deviation, $deviation);
        } else {
            $actualLength = $length;
        }

        $chars = 0;
        $sentences = [];

        while ($chars <= $actualLength) {
            $words = $this->wordsInternal(60, 20, ...$formatOptions);
            $sentence = ucfirst(implode(' ', $words)) . '.';
            $sentences[] = $sentence;
            $chars += strlen($sentence);
        }

        return $sentences;
    }

    /**
     * @return array<int,string>
     */
    protected function wordsInternal(int $length, int $deviation, FormatOption ...$formatOptions): array
    {
        if ($deviation > 0) {
            $actualLength = $length + mt_rand(-1 * $deviation, $deviation);
        } else {
            $actualLength = $length;
        }

        $chars = 0;
        $words = [];

        /** @phpstan-ignore-next-line */
        $openerKey = mt_rand(array_key_first($this->opener), array_key_last($this->opener));
        $words[] = ucfirst($this->opener[$openerKey]);
        $chars += strlen($this->opener[$openerKey]);

        while ($chars <= $actualLength) {
            /** @phpstan-ignore-next-line */
            $wordKey = mt_rand(array_key_first($this->words), array_key_last($this->words));
            $uppercase = mt_rand(0, 4);
            if ($uppercase === 0) {
                $words[] = ucfirst($this->words[$wordKey]);
            } else {
                $words[] = $this->words[$wordKey];
            }
            $chars += strlen($this->words[$wordKey]);
        }

        if ($formatOptions) {
            foreach ($words as $key => $value) {
                $formatOption = $formatOptions[mt_rand(0, count($formatOptions) + 20)] ?? null;
                $words[$key] = match ($formatOption) {
                    FormatOption::Links => '<a href="#">' . $value . '</a>',
                    FormatOption::Bold => '<strong>' . $value . '</strong>',
                    FormatOption::Italic => '<i>' . $value . '</i>',
                    default => $value
                };
            }
        }

        return $words;
    }
}
