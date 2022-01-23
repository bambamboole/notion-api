<?php

namespace Bambamboole\NotionApi\Models;

use Bambamboole\NotionApi\Models\Blocks\Block;
use Bambamboole\NotionApi\Models\Blocks\Paragraph;
use Bambamboole\NotionApi\Models\Properties\Property;

class CollectionEntry
{
    public function __construct(
        public readonly string $id,
        public readonly Paragraph $title,
        /** @var Property[] */
        public readonly array $properties,
        /** @var Block[] */
        public readonly array $blocks,
    )
    {
    }
}
