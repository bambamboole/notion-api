<?php

namespace Bambamboole\NotionApi\Models\Properties;

class MultiSelectProperty implements Property
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        private readonly array $values
    )
    {
    }

    public function getValue(): array
    {
        return $this->values;
    }
}
