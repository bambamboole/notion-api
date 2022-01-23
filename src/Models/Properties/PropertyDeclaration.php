<?php

namespace Bambamboole\NotionApi\Models\Properties;

use Bambamboole\NotionApi\Enums\PropertyType;

class PropertyDeclaration
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly PropertyType $propertyType
    )
    {
    }
}
