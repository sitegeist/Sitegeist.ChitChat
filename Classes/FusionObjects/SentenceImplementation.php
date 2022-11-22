<?php
declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class SentenceImplementation extends AbstractFusionObject
{
    #[Flow\InjectConfiguration('dictionary.opener')]
    protected $opener;

    #[Flow\InjectConfiguration('dictionary.words')]
    protected $words;

    public function evaluate()
    {
        $seed = $this->path . ($this->fusionValue('seed') ?: '');

        $words = $this->fusionValue('words') ?: 10;
        $deviation = $this->fusionValue('deviation') ?: 5;

        // configure seed for the mt_srand to create randomess bound to the fusion path
        mt_srand( crc32($seed));

        $actualWords = $words + mt_rand(-1 * $deviation , $deviation);

        $openerKey = mt_rand(array_key_first($this->opener), array_key_last($this->opener));
        $wordKeys = [];
        for ($i=0; $i < $actualWords; $i++) {
            $wordKeys[] = mt_rand(array_key_first($this->words), array_key_last($this->words));
        }

        $words = [ucfirst($this->opener[$openerKey])];
        foreach ($wordKeys as $wordKey) {
            $uppercase = mt_rand(0,4);
            if ($uppercase === 0) {
                $words[] = ucfirst($this->words[$wordKey]);
            } else {
                $words[] = $this->words[$wordKey];
            }
        }

        // reset mt_srand to default again
        mt_srand();

        return implode(' ', $words) . '.';
    }

}
