<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Tests\Utility;

use PHPUnit\Framework\TestCase;
use Sitegeist\ChitChat\Domain\DictionaryProviderInterface;
use Sitegeist\ChitChat\Domain\FormatOption;
use Sitegeist\ChitChat\Domain\PredictableProbabilityProvider;
use Sitegeist\ChitChat\Domain\PredictableRandomTextGenerator;
use Sitegeist\ChitChat\Domain\PredictableTextGenerator;
use Sitegeist\ChitChat\Domain\ProbabilityProviderInterface;
use Sitegeist\ChitChat\Domain\PseudoLatinDictionaryProvider;
use Sitegeist\Noderobis\Utility\ConfigurationUtility;

class PredictableRandomTextGeneratorTest extends TestCase
{


    public function createTextGeneratorWithSeed(string $seed): PredictableRandomTextGenerator
    {
        $dictionaryProvider = new PseudoLatinDictionaryProvider();
        $probabilityProvider = new PredictableProbabilityProvider();
        $probabilityProvider->initialize(crc32($seed));

        return new PredictableRandomTextGenerator(
        $dictionaryProvider,
        $probabilityProvider
        );
    }
    public function testThatLinesThatAreGeneratedMatchTheRequirements (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        for($i = 1; $i < 200; $i ++) {
            $line = $generator->generateLine(50, 150);
            $this->assertGreaterThanOrEqual(50, strlen($line));
            $this->assertLessThanOrEqual(150, strlen($line));
        }
    }

    public function testThatSameSeedsYieldIdenticalLines (): void
    {
        $generator1 = $this->createTextGeneratorWithSeed('nudelsuppe');
        $generator2 = $this->createTextGeneratorWithSeed('nudelsuppe');
        $generator3 = $this->createTextGeneratorWithSeed('tomatensuppe');

        $text1 = $generator1->generateLine(20, 50);
        $text2 = $generator2->generateLine(20, 50);
        $text3 = $generator3->generateLine(20, 50);

        $this->assertSame($text1, $text2);
        $this->assertNotSame($text1, $text3);
    }

    public function testThatConsecutiveCallsYieldDifferentLines (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        $text1 = $generator->generateLine(20, 50);
        $text2 = $generator->generateLine(20, 50);
        $text3 = $generator->generateLine(20, 50);

        $this->assertNotSame($text1, $text2);
        $this->assertNotSame($text1, $text3);
    }

    public function testThatTextThatAreGeneratedMatchTheRequirements (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        for($i = 1; $i < 200; $i ++) {
            $line = $generator->generateText(500, 1500);
            $this->assertGreaterThanOrEqual(500, strlen($line));
            $this->assertLessThanOrEqual(1500, strlen($line));
        }
    }

    public function testThatTextsThatAreGeneratedMatchTheRequirements (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        for($i = 1; $i < 200; $i ++) {
            $line = $generator->generateText(200, 500);
            $this->assertGreaterThanOrEqual(200, strlen($line));
            $this->assertLessThanOrEqual(500, strlen($line));
        }
    }

    public function testThatSameSeedsYieldIdenticalTexts (): void
    {
        $generator1 = $this->createTextGeneratorWithSeed('nudelsuppe');
        $generator2 = $this->createTextGeneratorWithSeed('nudelsuppe');
        $generator3 = $this->createTextGeneratorWithSeed('tomatensuppe');

        $text1 = $generator1->generateText(200, 500);
        $text2 = $generator2->generateText(200, 500);
        $text3 = $generator3->generateText(200, 500);

        $this->assertSame($text1, $text2);
        $this->assertNotSame($text1, $text3);
    }

    public function testThatConxecutiveCallsYieldDifferentTexts (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        $text1 = $generator->generateText(200, 500);
        $text2 = $generator->generateText(200, 500);
        $text3 = $generator->generateText(200, 500);

        $this->assertNotSame($text1, $text2);
        $this->assertNotSame($text1, $text3);
    }

    public function testThatFormattingsAreApplies (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        $origin = 'Lorem et Himenaeos cras Ridiculus nostra Cras congue Lectus Donec Risus. Adipiscing Dictum viverra commodo Mollis venenatis Phasellus Nam Nunc. Dolor lacinia hac Velit porttitor risus ad Ante ligula habitant.';

        $text = $generator->applyFormatting($origin, true, false, false);
        $this->assertStringContainsString('<a href="#">', $text);
        $this->assertStringNotContainsString('<strong>', $text);
        $this->assertStringNotContainsString('<em>', $text);

        $text = $generator->applyFormatting($origin, false, true, false);
        $this->assertStringContainsString('<strong>', $text);
        $this->assertStringNotContainsString('<a href="#">', $text);
        $this->assertStringNotContainsString('<em>', $text);

        $text = $generator->applyFormatting($origin, false, false, true);
        $this->assertStringNotContainsString('<strong>', $text);
        $this->assertStringNotContainsString('<a href="#">', $text);
        $this->assertStringContainsString('<em>', $text);

        $text = $generator->applyFormatting($origin, true, true, true);
        $this->assertStringContainsString('<strong>', $text);
        $this->assertStringContainsString('<a href="#">', $text);
        $this->assertStringContainsString('<em>', $text);
    }


    public function testThatSameSeedsYieldIdenticalFormatting (): void
    {
        $generator1 = $this->createTextGeneratorWithSeed('nudelsuppe');
        $generator2 = $this->createTextGeneratorWithSeed('nudelsuppe');
        $generator3 = $this->createTextGeneratorWithSeed('tomatensuppe');

        $text = 'Lorem et Himenaeos cras Ridiculus nostra Cras congue Lectus Donec Risus. Adipiscing Dictum viverra commodo Mollis venenatis Phasellus Nam Nunc. Dolor lacinia hac Velit porttitor risus ad Ante ligula habitant.';

        $text1 = $generator1->applyFormatting($text, true, true, true);
        $text2 = $generator2->applyFormatting($text, true, true, true);
        $text3 = $generator3->applyFormatting($text, true, true, true);

        $this->assertSame($text1, $text2);
        $this->assertNotSame($text1, $text3);
    }

    public function testThatConsecutiveCallsYieldDifferentFormatting (): void
    {
        $generator = $this->createTextGeneratorWithSeed('nudelsuppe');

        $text = 'Lorem et Himenaeos cras Ridiculus nostra Cras congue Lectus Donec Risus. Adipiscing Dictum viverra commodo Mollis venenatis Phasellus Nam Nunc. Dolor lacinia hac Velit porttitor risus ad Ante ligula habitant.';

        $text1 = $generator->applyFormatting($text, true, true, true);
        $text2 = $generator->applyFormatting($text, true, true, true);
        $text3 = $generator->applyFormatting($text, true, true, true);

        $this->assertNotSame($text1, $text2);
        $this->assertNotSame($text1, $text3);
    }
}
