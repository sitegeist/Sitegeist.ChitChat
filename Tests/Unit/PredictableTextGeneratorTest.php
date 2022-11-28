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
            ['Dolor', 'eget', 'est', 'eget', 'Facilisis', 'fames', 'faucibus', 'himenaeos', 'Etiam', 'felis', 'Fusce', 'Hac',  'facilisis', 'fames', 'hendrerit'],
            $generator->words('nudelsuppe', 16, .2)
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


    /**
     * @test
     */
    public function wordListsHasExactNumberOfItemsWhenNoDeviationIsGiven(): void
    {
        $generator = $this->getGenerator();
        $this->assertSame(
            20,
            count($generator->words('nudelsuppe', 20, 0))
        );
    }

    /**
     * @test
     */
    public function wordListsHasMaximalGivenNumberOfItemsWhenDeviationIsGiven(): void
    {
        $generator = $this->getGenerator();
        for($i = 0; $i < 1000; $i++) {
            $words = $generator->words(random_bytes(20), 20, .5);
            $this->assertTrue(
                count($words) <= 20
            );
        }

    }

    /**
     * @test
     */
    public function sentenceHasMaximalGivenNumberOfCharacters(): void
    {
        $generator = $this->getGenerator();
        for($i = 0; $i < 1000; $i++) {
            $sentence = $generator->sentence(random_bytes(20), 70, .5);
            $this->assertTrue(
                strlen($sentence) <= 70
            );
        }
    }

    /**
     * @test
     */
    public function paragraphHasMaximalGivenNumberOfCharacters(): void
    {
        $generator = $this->getGenerator();
        for($i = 0; $i < 1000; $i++) {
            $paragraph = $generator->paragraph(random_bytes(20), 1000, .5);
            $this->assertTrue(
                strlen($paragraph) <= 1000
            );
        }
    }
}
