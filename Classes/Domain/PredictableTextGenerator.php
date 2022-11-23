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

    public function paragraph(string $seed, int $sentences = 10, int $deviation = 0): string
    {
        $this->initializeRandomness($seed);
        $result = implode(' ', $this->sentenceArray($sentences, $deviation));
        $this->resetRandomness();
        return $result;
    }

    /**
     * @return array<int,string>
     */
    public function sentences(string $seed, int $items = 10, int $deviation = 0): array
    {
        $this->initializeRandomness($seed);
        $items = $this->sentenceArray($items, $deviation);
        $this->resetRandomness();
        return $items;
    }

    public function sentence(string $seed, int $words = 10, int $deviation = 0): string
    {
        $this->initializeRandomness($seed);
        $result = implode(' ', $this->wordArray($words, $deviation));
        $this->resetRandomness();
        return $result;
    }

    /**
     * @return array<int,string>
     */
    public function words(string $seed, int $words = 10, int $deviation = 0): array
    {
        $this->initializeRandomness($seed);
        $result = $this->wordArray($words, $deviation);
        $this->resetRandomness();
        return $result;
    }

    protected function initializeRandomness(string $seed): void
    {
        mt_srand(crc32($seed));
    }

    protected function resetRandomness(): void
    {
        mt_srand();
    }

    /**
     * @return array<int,string>
     */
    protected function sentenceArray(int $number, int $deviation = 0): array
    {
        if ($deviation) {
            $actualNumber = $number + mt_rand(-1 * $deviation, $deviation);
        } else {
            $actualNumber = $number;
        }
        $sentences = [];
        for ($i = 0; $i < $actualNumber; $i++) {
            $sentences[] = ucfirst(implode(' ', $this->wordArray(10, $deviation))) . '.';
        }
        return $sentences;
    }

    /**
     * @return array<int,string>
     */
    protected function wordArray(int $number, int $deviation = 0): array
    {
        if ($deviation) {
            $actualWords = $number + mt_rand(-1 * $deviation, $deviation);
        } else {
            $actualWords = $number;
        }

        /** @phpstan-ignore-next-line */
        $openerKey = mt_rand(array_key_first($this->opener), array_key_last($this->opener));
        $wordKeys = [];
        for ($i = 0; $i < $actualWords; $i++) {
            /** @phpstan-ignore-next-line */
            $wordKeys[] = mt_rand(array_key_first($this->words), array_key_last($this->words));
        }

        $words = [ucfirst($this->opener[$openerKey])];
        foreach ($wordKeys as $wordKey) {
            $uppercase = mt_rand(0, 4);
            if ($uppercase === 0) {
                $words[] = ucfirst($this->words[$wordKey]);
            } else {
                $words[] = $this->words[$wordKey];
            }
        }
        return $words;
    }
}
