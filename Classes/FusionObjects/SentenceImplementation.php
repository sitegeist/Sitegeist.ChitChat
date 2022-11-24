<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;

class SentenceImplementation extends AbstractFusionObject
{
    use GetFormatOptionsTrait;

    public function evaluate(): string
    {
        $generator = new PredictableTextGenerator();

        $seed = $this->path . ($this->fusionValue('seed') ?: '');
        $length = intval($this->fusionValue('length') ?: 10);
        $deviation = intval($this->fusionValue('deviation') ?: 5);
        $formatOptions = $this->getFormatOptions();

        return $generator->sentence($seed, $length, $deviation, ...$formatOptions);
    }
}
