<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableRandomTextGenerator;
use Sitegeist\ChitChat\Domain\PseudoLatinDictionaryProvider;

class LineImplementation extends AbstractFusionObject
{
    public function evaluate(): string
    {
        $seed = crc32($this->path . ($this->fusionValue('seed') ?: ''));

        $generator = new PredictableRandomTextGenerator(
            new PseudoLatinDictionaryProvider(),
            $seed
        );

        $minLength = $this->fusionValue('minLength');
        $maxLength = $this->fusionValue('maxLength');

        return $generator->generateLine(
            is_int($minLength) ? $minLength : 100,
            is_int($maxLength) ? $maxLength : 500
        );
    }
}
