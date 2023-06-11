<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Sitegeist\ChitChat\Domain\PredictableRandomTextGenerator;

class TextImplementation extends BaseFusionObject
{
    public function evaluate(): string
    {
        $seed = crc32($this->path . ($this->fusionValue('seed') ?: ''));

        $probabilityProvider = $this->resolveProbablityProvider();
        $probabilityProvider->initialize($seed);

        $dictionaryProvider = $this->resolveDictionaryProvider();

        $generator = new PredictableRandomTextGenerator(
            $dictionaryProvider,
            $probabilityProvider
        );

        $maxLength = $this->getLength();
        $minLength = (int) ($maxLength * $this->getVariance());

        return $generator->applyFormatting(
            $generator->generateText($minLength, $maxLength),
            $this->getLink(),
            $this->getStrong(),
            $this->getEm(),
        );
    }
}
