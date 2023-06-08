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

    public function generateText(int $minLength, int $maxLength): string
    {
        $sentences = $this->generateSentences($minLength, $maxLength);
        return implode(' ', $sentences);
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
        $firstSentence = implode(' ', $firstWords) . '.';
        $currentLength = strlen($firstSentence);
        $sentences = [$firstSentence];

        while (true) {
            $words = $this->generateWords($minSentenceLength, $maxSentenceLength);
            $nextSentence = implode(' ', $words) . '.';
            $nextLength = $currentLength + 1 + strlen($nextSentence);

            if ($nextLength >= $targetTotalLength || $nextLength >= $maxTotalLength) {
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

        $opener = $this->dictionaryProvider->provideOpener($this->randomNumber(1, $this->dictionaryProvider->provideOpenerNumber()));
        $words[] = ucfirst($opener);
        $currentLength = strlen($opener);

        while (true) {
            $nextWord = $this->dictionaryProvider->provideWord($this->randomNumber(1, $this->dictionaryProvider->provideWordNumber()));
            $nextLength = $currentLength + 1 + strlen($nextWord);
            $nextUppercase = $this->randomNumber(0, 2);

            if ($nextUppercase === 0) {
                $nextWord = ucfirst($nextWord);
            }

            if ($nextLength >= $targetLength || $nextLength >= $maxLength) {
                break;
            } else {
                $words[] = $nextWord;
                $currentLength = $nextLength;
            }
        }

        return $words;
    }
}
