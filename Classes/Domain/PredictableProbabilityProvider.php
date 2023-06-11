<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

class PredictableProbabilityProvider implements ProbabilityProviderInterface
{
    protected int $seed = 0;
    public function initialize(int $seed): void
    {
        $this->seed = $seed;
    }

    public function provideNumber(int $min, int $max): int
    {
        mt_srand($this->seed);
        $result = mt_rand($min, $max);
        $this->seed = mt_rand(0, getrandmax());
        return $result;
    }
}
