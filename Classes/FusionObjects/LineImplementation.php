<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\DictionaryProviderInterface;
use Sitegeist\ChitChat\Domain\PredictableRandomTextGenerator;
use Sitegeist\ChitChat\Domain\PseudoLatinDictionaryProvider;

class LineImplementation extends AbstractFusionObject
{
    #[Flow\Inject(lazy:false)]
    protected DictionaryProviderInterface $dictionaryProvider;

    public function evaluate(): string
    {
        $seed = crc32($this->path . ($this->fusionValue('seed') ?: ''));

        $generator = new PredictableRandomTextGenerator(
            $this->dictionaryProvider,
            $seed
        );

        $minLength = $this->fusionValue('minLength');
        $maxLength = $this->fusionValue('maxLength');

        $line = $generator->generateLine(
            is_int($minLength) ? $minLength : 100,
            is_int($maxLength) ? $maxLength : 500
        );

        $links = $this->fusionValue('links');
        $strong = $this->fusionValue('strong');
        $italic = $this->fusionValue('italic');

        return $generator->applyFormatting(
            $line,
            is_bool($links) ? $links : false,
            is_bool($strong) ? $strong : false,
            is_bool($italic) ? $italic : false,
        );
    }
}
