<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;

class ParagraphImplementation extends AbstractFusionObject
{
    public function evaluate()
    {
        $generator = new PredictableTextGenerator();

        $seed = $this->path . ($this->fusionValue('seed') ?: '');
        $sentences = intval($this->fusionValue('sentences') ?: 10);
        $deviation = intval($this->fusionValue('deviation') ?: 5);

        return '<p>' . $generator->paragraph($seed, $sentences, $deviation) . '</p>';
    }
}
