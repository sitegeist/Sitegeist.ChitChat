<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

use Neos\Flow\Annotations as Flow;

#[Flow\Scope('singleton')]
class PseudoLatinDictionaryProvider implements DictionaryProviderInterface
{
    /**
     * @var string[]
     */
    protected readonly array $opener;

    protected readonly int $openerNumber;

    /**
     * @var string[]
     */
    protected readonly array $words;

    protected readonly int $wordNumber;

    public function __construct()
    {
        $this->opener = [
            'lorem', 'ipsum', 'dolor', 'sit',
            'amet', 'consectetur', 'adipiscing', 'elit'
        ];
        $this->openerNumber = count($this->opener) - 1;

        $this->words = [
            'a', 'ac', 'accumsan', 'ad',
            'aenean', 'aliquam', 'aliquet', 'ante',
            'aptent', 'arcu', 'at', 'auctor',
            'augue', 'bibendum', 'blandit', 'class',
            'commodo', 'condimentum', 'congue', 'consequat',
            'conubia', 'convallis', 'cras', 'cubilia',
            'cum', 'curabitur', 'curae', 'cursus',
            'dapibus', 'diam', 'dictum', 'dictumst',
            'dignissim', 'dis', 'donec', 'dui',
            'duis', 'egestas', 'eget', 'eleifend',
            'elementum', 'enim', 'erat', 'eros',
            'est', 'et', 'etiam', 'eu',
            'euismod', 'facilisi', 'facilisis', 'fames',
            'faucibus', 'felis', 'fermentum', 'feugiat',
            'fringilla', 'fusce', 'gravida', 'habitant',
            'habitasse', 'hac', 'hendrerit', 'himenaeos',
            'iaculis', 'id', 'imperdiet', 'in',
            'inceptos', 'integer', 'interdum', 'justo',
            'lacinia', 'lacus', 'laoreet', 'lectus',
            'leo', 'libero', 'ligula', 'litora',
            'lobortis', 'luctus', 'maecenas', 'magna',
            'magnis', 'malesuada', 'massa', 'mattis',
            'mauris', 'metus', 'mi', 'molestie',
            'mollis', 'montes', 'morbi', 'mus',
            'nam', 'nascetur', 'natoque', 'nec',
            'neque', 'netus', 'nibh', 'nisi',
            'nisl', 'non', 'nostra', 'nulla',
            'nullam', 'nunc', 'odio', 'orci',
            'ornare', 'parturient', 'pellentesque', 'penatibus',
            'per', 'pharetra', 'phasellus', 'placerat',
            'platea', 'porta', 'porttitor', 'posuere',
            'potenti', 'praesent', 'pretium', 'primis',
            'proin', 'pulvinar', 'purus', 'quam',
            'quis', 'quisque', 'rhoncus', 'ridiculus',
            'risus', 'rutrum', 'sagittis', 'sapien',
            'scelerisque', 'sed', 'sem', 'semper',
            'senectus', 'sociis', 'sociosqu', 'sodales',
            'sollicitudin', 'suscipit', 'suspendisse', 'taciti',
            'tellus', 'tempor', 'tempus', 'tincidunt',
            'torquent', 'tortor', 'tristique', 'turpis',
            'ullamcorper', 'ultrices', 'ultricies', 'urna',
            'ut', 'varius', 'vehicula', 'vel',
            'velit', 'venenatis', 'vestibulum', 'vitae',
            'vivamus', 'viverra', 'volutpat', 'vulputate'
        ];

        $this->wordNumber = count($this->words) - 1;
    }

    public function provideOpener(int $index): string
    {
        return $this->opener[$index];
    }

    public function provideMaxOpenerIndex(): int
    {
        return $this->openerNumber;
    }

    public function provideWord(int $index): string
    {
        return $this->words[$index];
    }

    public function provideMaxWordIndex(): int
    {
        return $this->wordNumber;
    }

    public function provideSentenceSeparator(): string
    {
        return '.';
    }
}
