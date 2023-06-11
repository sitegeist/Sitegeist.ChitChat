<?php

namespace Sitegeist\ChitChat\Domain;

interface ProbabilityProviderInterface
{
    public function initialize(int $seed): void;

    public function provideNumber(int $min, int $max): int;
}
