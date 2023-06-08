<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\Domain;

class PseudoLatinDictionaryProvider implements DictionaryProviderInterface
{
    /**
     * @var string[]
     */
    protected array $opener = [
        'lorem', 'ipsum', 'dolor', 'sit',
        'amet', 'consectetur', 'adipiscing', 'elit'
    ];

    protected int $openerNumber;

    /**
     * @var string[]
     */
    protected array $words = [
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


    protected int $wordNumber;

    public function __construct()
    {
        $this->openerNumber = count($this->opener);
        $this->wordNumber = count($this->words);
    }

    public function provideOpener(int $number): string
    {
        return $this->opener[$number - 1];
    }

    public function provideOpenerNumber(): int
    {
        return $this->openerNumber;
    }

    public function provideWord(int $number): string
    {
        return $this->words[$number - 1];
    }

    public function provideWordNumber(): int
    {
        return $this->wordNumber;
    }
}
