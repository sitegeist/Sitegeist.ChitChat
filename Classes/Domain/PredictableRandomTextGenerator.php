<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

class PredictableRandomTextGenerator
{
    public function __construct(
        protected DictionaryProviderInterface $dictionaryProvider,
        protected int $seed = 0
    ) {
    }

    protected function randomNumber(int $min, int $max): int
    {
        mt_srand($this->seed);
        $result = mt_rand($min, $max);
        $this->seed = mt_rand(0, getrandmax());
        return $result;
    }

    public function applyFormatting(string $text, bool $link = false, bool $strong = false, bool $em = false): string
    {
        if (!$strong && !$em && !$link) {
            return $text;
        }

        $formattedText = preg_replace_callback(
            '/[^\\s\\.]+/u',
            fn(array $matches) => match ($this->randomNumber(0, 20)) {
                0 => $link ? '<a href="#">' . $matches[0] . '</a>' : $matches[0],
                1 => $strong ? '<strong>' . $matches[0] . '</strong>' : $matches[0],
                2 => $em ? '<em>' . $matches[0] . '</em>' : $matches[0],
                default => $matches[0]
            },
            $text
        );

        return $formattedText ?? $text;
    }

    public function generateText(int $minLength, int $maxLength): string
    {
        $sentences = $this->generateSentences($minLength, $maxLength);
        return implode(' ', $sentences);
    }

    public function generateLine(int $minLength, int $maxLength): string
    {
        $words = $this->generateWords($minLength, $maxLength);
        return implode(' ', $words);
    }

    /**
     * @return array<int,string>
     */
    public function generateSentences(int $minTotalLength, int $maxTotalLength, int $minSentenceLength = 40, int $maxSentenceLength = 100): array
    {
        if ($minSentenceLength > $minTotalLength) {
            $minSentenceLength = $minTotalLength;
        }

        if ($maxSentenceLength > $maxTotalLength) {
            $maxSentenceLength = $maxTotalLength;
        }

        $targetTotalLength = $this->randomNumber($minTotalLength, $maxTotalLength);

        $firstWords = $this->generateWords($minSentenceLength, $maxSentenceLength);
        $firstSentence = implode(' ', $firstWords) . $this->dictionaryProvider->provideSentenceSeparator();
        $currentLength = strlen($firstSentence);
        $sentences = [$firstSentence];

        while (true) {
            $words = $this->generateWords($minSentenceLength, $maxSentenceLength);
            $nextSentence = implode(' ', $words) . $this->dictionaryProvider->provideSentenceSeparator();
            $nextLength = $currentLength + 1 + strlen($nextSentence);

            if ($nextLength > $maxTotalLength || $currentLength > $targetTotalLength) {
                break;
            } else {
                $sentences[] = $nextSentence;
                $currentLength = $nextLength;
            }
        }

        return $sentences;
    }

    /**
     * @return array<int,string>
     */
    public function generateWords(int $minLength, int $maxLength): array
    {
        $targetLength = $this->randomNumber($minLength, $maxLength);

        $words = [];

        $opener = $this->dictionaryProvider->provideOpener($this->randomNumber(0, $this->dictionaryProvider->provideMaxOpenerIndex()));
        $words[] = ucfirst($opener);
        $currentLength = strlen($opener);

        while (true) {
            $nextWord = $this->dictionaryProvider->provideWord($this->randomNumber(0, $this->dictionaryProvider->provideMaxWordIndex()));
            $nextLength = $currentLength + 1 + strlen($nextWord);
            $nextUppercase = $this->randomNumber(0, 2);

            if ($nextUppercase === 0) {
                $nextWord = ucfirst($nextWord);
            }

            if ($nextLength > $maxLength || $currentLength > $targetLength) {
                break;
            } else {
                $words[] = $nextWord;
                $currentLength = $nextLength;
            }
        }

        return $words;
    }
}
