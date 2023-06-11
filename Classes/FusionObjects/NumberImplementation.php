<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Sitegeist\ChitChat\Domain\PredictableRandomTextGenerator;

class NumberImplementation extends BaseFusionObject
{
    public function evaluate(): int
    {
        $seed = crc32($this->path . ($this->fusionValue('seed') ?: ''));

        $probabilityProvider = $this->resolveProbablityProvider();
        $probabilityProvider->initialize($seed);

        $min = $this->fusionValue('min');
        $max = $this->fusionValue('max');

        if (!is_scalar($min)) {
            throw new \InvalidArgumentException("min requires and integer");
        }
        if (!is_scalar($max)) {
            throw new \InvalidArgumentException("max requires and integer");
        }

        return $probabilityProvider->provideNumber((int) $min, (int) $max);
    }
}
