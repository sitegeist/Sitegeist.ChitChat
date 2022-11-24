<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;

class WordsImplementation extends AbstractFusionObject
{
    /**
     * @return string[]
     */
    public function evaluate(): array
    {
        $generator = new PredictableTextGenerator();

        $seed = $this->path . ($this->fusionValue('seed') ?: '');
        $length = intval($this->fusionValue('length') ?: 60);
        $deviation = floatval($this->fusionValue('deviation') ?: .5);

        return $generator->words($seed, $length, $deviation);
    }
}
