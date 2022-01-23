<?php

namespace Bambamboole\NotionApi\Models\Properties;

class TextProperty implements Property
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        private readonly string $value
    )
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
