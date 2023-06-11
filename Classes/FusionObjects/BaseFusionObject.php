<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManager;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Sitegeist\ChitChat\Domain\DictionaryProviderInterface;
use Sitegeist\ChitChat\Domain\ProbabilityProviderInterface;
use Sitegeist\ChitChat\Domain\PseudoLatinDictionaryProvider;

abstract class BaseFusionObject extends AbstractFusionObject
{
    #[Flow\Inject]
    protected ObjectManager $objectManager;

    /**
     * @var array<string,string>
     */
    #[Flow\InjectConfiguration(path:'dictionaries')]
    protected array $dictionariesConfiguration;

    /**
     * @var array<string,string>
     */
    #[Flow\InjectConfiguration(path:'probablility')]
    protected array $probalilityConfiguration;

    /**
     * @var array<string,string>
     */
    #[Flow\InjectConfiguration(path:'defaults')]
    protected array $defaultsConfiguration;

    public function resolveDictionaryProvider(): DictionaryProviderInterface
    {
        $dictionary = $this->fusionValue('dictionary') ?: $this->defaultsConfiguration['dictionary'] ?? null;
        $dictionaryProvider = null;

        if (
            is_string($dictionary)
            && array_key_exists($dictionary, $this->dictionariesConfiguration)
            && $this->objectManager->has($this->dictionariesConfiguration[$dictionary])
        ) {
            $dictionaryProvider = $this->objectManager->get($this->dictionariesConfiguration[$dictionary]);
        }
        if ($dictionaryProvider instanceof DictionaryProviderInterface) {
            return $dictionaryProvider;
        } else {
            throw new \Exception('missing dictionary provider');
        }
    }

    public function resolveProbablityProvider(): ProbabilityProviderInterface
    {
        $probability = $this->fusionValue('probability') ?: $this->defaultsConfiguration['probability'] ?? null;
        $probabilityProvider = null;

        if (
            is_string($probability)
            && array_key_exists($probability, $this->probalilityConfiguration)
            && $this->objectManager->has($this->probalilityConfiguration[$probability])
        ) {
            $probabilityProvider = $this->objectManager->get($this->probalilityConfiguration[$probability]);
        }
        if ($probabilityProvider instanceof ProbabilityProviderInterface) {
            return $probabilityProvider;
        } else {
            throw new \Exception('missing probability provider');
        }
    }

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
