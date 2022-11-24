<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Tests\Utility;

use PHPUnit\Framework\TestCase;
use Sitegeist\ChitChat\Domain\FormatOption;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;
use Sitegeist\Noderobis\Utility\ConfigurationUtility;

class PredictableTextGeneratorTest extends TestCase
{

    /**
     * @test
     */
    public function wordListsGeneratedPredictably(): void
    {
        $generator = $this->getGenerator();
        $this->assertSame(
            ['Dolor', 'eget', 'est', 'eget', 'Facilisis', 'fames', 'faucibus', 'himenaeos', 'Etiam', 'felis', 'Fusce', 'Hac'],
            $generator->words('nudelsuppe', 60, 20)
        );
    }

    /**
     * @test
     */
    public function wordListsGeneratedWithTheSameSeedEqual(): void
    {
        $generator = $this->getGenerator();
        $this->assertSame(
            $generator->words('nudelsuppe', 10, 5),
            $generator->words('nudelsuppe', 10, 5)
        );
    }

    /**
     * @test
     */
    public function wordListsGeneratedWithDifferentSeedEqual(): void
    {
        $generator = $this->getGenerator();
        $this->assertNotSame(
            $generator->words('nudelsuppe', 10, 5),
            $generator->words('tomatensuppe', 10, 5)
        );
    }

    protected function getGenerator(): PredictableTextGenerator
    {
        $generator = new PredictableTextGenerator();
        $generator->injectSettings([
            'dictionary' => [
                'opener' => ['Lorem', 'ipsum', 'dolor', 'sit', 'amet'],
                'words' => [
                    'dignissim',    'dis',         'donec',        'dui',
                    'duis',         'egestas',     'eget',         'eleifend',
                    'elementum',    'enim',        'erat',         'eros',
                    'est',          'et',          'etiam',        'eu',
                    'euismod',      'facilisi',    'facilisis',    'fames',
                    'faucibus',     'felis',       'fermentum',    'feugiat',
                    'fringilla',    'fusce',       'gravida',      'habitant',
                    'habitasse',    'hac',         'hendrerit',    'himenaeos',
                    'iaculis',      'id',          'imperdiet',    'in',
                    'inceptos',     'integer',     'interdum',     'justo',
                    'lacinia',      'lacus',       'laoreet',      'lectus'
                ]
            ]
        ]);
        return $generator;
    }

}
