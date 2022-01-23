<?php

namespace Bambamboole\NotionApi\Models;

use Bambamboole\NotionApi\Models\Blocks\Paragraph;
use Bambamboole\NotionApi\Models\Properties\PropertyDeclaration;

class Collection
{
    public function __construct(
        public readonly string $id,
        public readonly Paragraph $name,
        /** @var PropertyDeclaration[] */
        public readonly array $schema,
        /** @var CollectionEntry[] */
        public readonly array $entries
    )
    {
    }
}
