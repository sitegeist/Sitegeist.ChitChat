<?php

declare(strict_types=1);

namespace Sitegeist\ChitChat\FusionObjects;

use Sitegeist\ChitChat\Domain\FormatOption;

trait GetFormatOptionsTrait
{
    /**
     * @return FormatOption[]
     */
    protected function getFormatOptions(): array
    {
        $formatOptions = [];
        if ($this->fusionValue('links')) {
            $formatOptions[] = FormatOption::Links;
        }
        if ($this->fusionValue('italic')) {
            $formatOptions[] = FormatOption::Italic;
        }
        if ($this->fusionValue('bold')) {
            $formatOptions[] = FormatOption::Bold;
        }
        return $formatOptions;
    }
}
