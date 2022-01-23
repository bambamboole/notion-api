<?php

namespace Bambamboole\NotionApi\Models\Properties;

use Bambamboole\NotionApi\Models\Blocks\Paragraph;

class TextProperty implements Property
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        private readonly Paragraph $value
    )
    {
    }

    public function getValue(): Paragraph
    {
        return $this->value;
    }
}
