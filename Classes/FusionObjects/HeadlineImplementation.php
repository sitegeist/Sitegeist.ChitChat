<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;

class HeadlineImplementation extends AbstractFusionObject
{
    public function evaluate()
    {
        $generator = new PredictableTextGenerator();

        $seed = $this->path . ($this->fusionValue('seed') ?: '');
        $words = intval($this->fusionValue('words') ?: 10);
        $deviation = intval($this->fusionValue('deviation') ?: 5);
        $level = intval($this->fusionValue('level') ?: 1);

        return '<h' . $level . '>' . $generator->sentence($seed, $words, $deviation) . '</h' . $level . '>' ;
    }
}
