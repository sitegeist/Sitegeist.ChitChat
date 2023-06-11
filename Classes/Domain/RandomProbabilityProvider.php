<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

class RandomProbabilityProvider implements ProbabilityProviderInterface
{
    public function initialize(int $seed): void
    {
        // ignore since random
    }

    public function provideNumber(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
