<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;

class SentencesImplementation extends AbstractFusionObject
{
    use GetFormatOptionsTrait;

    /**
     * @return string[]
     */
    public function evaluate(): array
    {
        $generator = new PredictableTextGenerator();

        $seed = $this->path . ($this->fusionValue('seed') ?: '');
        $length = intval($this->fusionValue('length') ?: 10);
        $deviation = intval($this->fusionValue('deviation') ?: 5);
        $formatOptions = $this->getFormatOptions();

        return $generator->sentences($seed, $length, $deviation, ...$formatOptions);
    }
}
