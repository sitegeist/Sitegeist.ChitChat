<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

interface DictionaryProviderInterface
{
    public function provideOpener(int $index): string;

    public function provideMaxOpenerIndex(): int;

    public function provideWord(int $index): string;

    public function provideMaxWordIndex(): int;

    public function provideSentenceSeparator(): string;
}
