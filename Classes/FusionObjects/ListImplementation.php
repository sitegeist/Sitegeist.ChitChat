<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;

class ListImplementation extends AbstractFusionObject
{
    public function evaluate()
    {
        $generator = new PredictableTextGenerator();

        $seed = $this->path . ($this->fusionValue('seed') ?: '');
        $items = intval($this->fusionValue('items') ?: 10);
        $ordered = intval($this->fusionValue('ordered'));
        $deviation = intval($this->fusionValue('deviation') ?: 5);

        $items = $generator->sentences($seed, $items, $deviation);
        return ($ordered ? '<ol>' : '<ul>') . '<li>' . implode('</li><li>', $items) . '</li>' . ($ordered ? '</ol>' : '</ul>');
    }
}
