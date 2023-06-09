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

        $generator = new PredictableRandomTextGenerator(
            $this->resolveDictionaryProvider(),
            $seed
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
