<?php

namespace Bambamboole\NotionApi\Models\Properties;

class DateProperty implements Property
{
    private \DateTime $value;

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        string $rawValue
    )
    {
        $this->value = $this->parse($rawValue);
    }

    private function parse(string $rawValue): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d', substr($rawValue, 0,10));
    }

    public function getValue(): \DateTime
    {
        return $this->value;
    }
}
