<?php

namespace Sitegeist\ChitChat\Domain;

interface DictionaryProviderInterface
{
    public function provideOpener(int $number): string;

    public function provideOpenerNumber(): int;

    public function provideWord(int $number): string;

    public function provideWordNumber(): int;
}
