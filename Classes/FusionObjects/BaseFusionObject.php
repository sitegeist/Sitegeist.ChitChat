<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\DictionaryProviderInterface;

abstract class BaseFusionObject extends AbstractFusionObject
{
    #[Flow\Inject(lazy:false)]
    protected DictionaryProviderInterface $dictionaryProvider;

    protected function getLength(): int
    {
        $length = $this->fusionValue('length');
        return is_scalar($length) ? (int) $length : 100;
    }

    protected function getVariance(): float
    {
        $variance = $this->fusionValue('variance');
        $result = is_scalar($variance) ? (float) $variance : 0;
        if (0 < $result && 1 > $result) {
            return $result;
        } else {
            return 0.5;
        }
    }

    protected function getLink(): bool
    {
        $link = $this->fusionValue('link');

        return is_scalar($link) ? (bool) $link : false;
    }

    protected function getStrong(): bool
    {
        $em = $this->fusionValue('strong');
        return is_scalar($em) ? (bool) $em : false;
    }

    protected function getEm(): bool
    {
        $em = $this->fusionValue('em');
        return is_scalar($em) ? (bool) $em : false;
    }
}
